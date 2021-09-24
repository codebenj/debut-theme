<?php

namespace App\Jobs;

use App\AddOns;
use DateTime;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use App\MainSubscription;
use App\SubscriptionPaypal;
use Intercom\IntercomClient;

class AfterAuthenticateJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $shop;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(User $shop)
  {
    $this->shop = $shop;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    try {
      logger('After authenticate job starts');

      $shopData = $this->shop->api()->request(
        'GET',
        '/admin/api/shop.json',
        []
      )['body']['shop'];
      logger('After authenticate fetch shop data'. json_encode($shopData));
      $this->shop->shopify_raw = json_encode($shopData);
      $this->shop->script_tags = 1;

      // Unpause subscription on app re-install
      if ($this->shop && $this->shop->is_paused == 1 && $this->shop->uninstalled_at) {
        $mainSubscription = $this->shop->mainSubscription;
        $this->shop->uninstalled_at = null;
        
        try {
          if ($mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
            unpauseSubscription($this->shop);
          }

          if ($mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
              $paypalSubscription = SubscriptionPaypal::where('user_id', $this->shop->id)->orderBy('id', 'desc')->first();

              if ($paypalSubscription && $paypalSubscription->paypal_plan) {
                unPausePaypalSubscription($paypalSubscription->paypal_id);
                $this->shop->is_paused = 0;
              }
          }
        } catch (\Exception $e) {
          logger($e->getMessage());
        }
      }

      $cnt_addons = AddOns::where('user_id', $this->shop->id)->where('status', 1)->count();
      $activeCampaign = new ActiveCampaignJobV3();

      if ($cnt_addons == 0 ) {
        $this->shop->is_updated_addon = 1;
      }

      // Update shop email on initial install.
      if (substr($this->shop->email, 0, 5) == 'shop@' && str_contains($this->shop->email, 'shopify.com')) {
        $this->shop->email = $shopData['email'];
      }

      $date = new DateTime();
      $new_formats_trial = $date->format('Y-m-d');
      $creation_date = $this->shop->created_at->format('Y-m-d');

      if ($new_formats_trial <= $creation_date) {
        if ($this->shop->trial_ends_at == null) {
          logger('After authenticate set trial days');
          setTrialDays($this->shop, 14, true);
        }
      }

      $this->shop->save();

      if ($this->shop->trial_days > 0) {
        $subscription = 'Trial';
      } else if ($this->shop->alladdons_plan == null || $this->shop->alladdons_plan == '' || $this->shop->alladdons_plan == 'Freemium') {
        $subscription = 'Freemium';
      } else {
        $subscription = $this->shop->alladdons_plan;
      }

      // Synchronize AC Contact Details
			$contact = $activeCampaign->sync([
				'email' => $this->shop->email,
        'firstName' => getName($shopData['shop_owner'], 'first'),
        'lastName' => getName($shopData['shop_owner'], 'last'),
        'phone' => $shopData['phone'],
        'fieldValues' => [
          ['field' => AC::FIELD_ID, 'value' => $shopData['id']],
          ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $subscription],
          ['field' => AC::FIELD_WEBSITE, 'value' => $shopData['myshopify_domain']],
          ['field' => AC::FIELD_COMPANY, 'value' => $shopData['domain']],
          ['field' => AC::FIELD_APP_STATUS, 'value' => 'Installed'],
          ['field' => AC::FIELD_COUNTRY, 'value' => $shopData['country_name']],
          ['field' => AC::FIELD_CITY, 'value' => $shopData['city']],
          ['field' => AC::FIELD_ZIP, 'value' => $shopData['zip']],
          ['field' => AC::FIELD_ADDRESS_LINE_1, 'value' => $shopData['address1']],
          ['field' => AC::FIELD_ADDRESS_LINE_2, 'value' => $shopData['address2']],
          ['field' => AC::FIELD_PROVINCE, 'value' => $shopData['province']],
          ['field' => AC::FIELD_LANGUAGE, 'value' => $shopData['primary_locale']],
          ['field' => AC::FIELD_STORE_NAME, 'value' => $shopData['name']],
        ]
			]);

      // Update ActiveCampaign email
      try {
        if ($this->shop->email != $shopData['email']) {
          $contact = $activeCampaign->update($contact['id'], ['email' => $shopData['email']]);
        }
      } catch (\Exception $e) {
        logger($e->getMessage());
      }
      
      // Subscribe newly created contact to Masterlist 
      if ($contact['cdate'] === $contact['udate']) {
        $activeCampaign ->updateListStatus([
          'list' => AC::LIST_MASTERLIST,
          'contact' => $contact['id'],
          'status' => AC::LIST_SUBSCRIBE
        ]);
      }

      if ($this->shop->subscribed == 0) {
        $this->shop->subscribed=1;
      }

      if ($this->shop->trial_check == null || $this->shop->trial_check == '') {
        $this->shop->trial_check = 0;
      }

      if ($this->shop->theme_check == null || $this->shop->theme_check == '') {
        $this->shop->theme_check = 0;
      }

      try {
        $storeClosedTag = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_SHOPIFY_STORE_CLOSED);

        if ($storeClosedTag) {
          $activeCampaign->untag($storeClosedTag['id']);
        }
      } catch (\Exception $e) {
        logger($e->getMessage());
      }

      try {
        $shopifyId = json_decode($this->shop->shopify_raw)->id;
        // create new contact in Intercom
        $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
        $createIntercom = $client->contacts->create([
          'role' => 'user',
          'email' => $shopData['email'],
          'name' => $this->shop->name,
          'external_id' => $shopifyId
        ]);
      } catch (\Exception $e) {
       if($e->getMessage() == 'Conflict') { logger('contact already exists'); }
      }

      $this->shop->shop_id = $shopData['id'];
      $this->shop->email = $shopData['email'];
      logger('Saving shop save second');
      $this->shop->save();
    } catch (\Exception $e) {
      logger($e->getMessage());
    }
  }
}
