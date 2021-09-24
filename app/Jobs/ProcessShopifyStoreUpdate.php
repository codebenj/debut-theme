<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\MainSubscription;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;

class ProcessShopifyStoreUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $mainSubscription;
    public $shopData;
    public $shop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $mainSubscription, $shopData, $shop)
    {
        $this->email = $email;
        $this->mainSubscription = $mainSubscription;
        $this->shopData = $shopData;
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('ProcessShopifyStoreUpdate started');
        $activeCampaign = new ActiveCampaignJobV3();

        try {
            if (isset($this->mainSubscription->payment_platform) && $this->mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                $address = array('line1' => $this->shopData['address1'], 'city' => $this->shopData['city'], 'country' => $this->shopData['country_name'], 'line2' => $this->shopData['address2'], 'postal_code' => $this->shopData['zip'], 'state' => $this->shopData['province']);
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                if ($this->shop->stripe_id) {
                    \Stripe\Customer::update(
                        $this->shop->stripe_id,
                        [
                            'email' => $this->shopData['email'],
                            'description' => $this->shop->name,
                            'name' => $this->shopData['shop_owner'],
                            'address' => $address,
                            'phone' => $this->shopData['phone']
                        ]
                    );
                }
            }
        } catch(\Stripe\Exception\CardException $e) {
            $body = $e->getJsonBody();
            logger(json_encode($body['error']));
        } catch (\Stripe\Exception\RateLimitException $e) {
            $body = $e->getJsonBody();
            logger(json_encode($body['error']));
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $body = $e->getJsonBody();
            logger(json_encode($body['error']));
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $body = $e->getJsonBody();
            logger(json_encode($body['error']));
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $body = $e->getJsonBody();
            logger(json_encode($body['error']));
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $body = $e->getJsonBody();
            logger(json_encode($body['error']));
        } catch (\Exception $e) {
            $body = $e->getMessage();
            logger($body);
        }

        logger('Active campaign logs begin');

        if ($this->shop->trial_days > 0) {
            $subscription ='Trial';
        } else if ($this->shop->alladdons_plan == 'Freemium' || $this->shop->alladdons_plan == '') {
            $subscription = 'Freemium';
        } else {
            $subscription = $this->shop->alladdons_plan;
        }

        try {
            $contact = $activeCampaign->sync([
                'email' => $this->email,
                'firstName' => getName($this->shopData['shop_owner'], 'first'),
                'lastName' => getName($this->shopData['shop_owner'], 'last'),
                'phone' => $this->shopData['phone'],
                'fieldValues' => [
                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $subscription],
                    ['field' => AC::FIELD_COMPANY, 'value' => $this->shopData['domain']],
                    ['field' => AC::FIELD_APP_STATUS, 'value' => 'Installed'],
                    ['field' => AC::FIELD_COUNTRY, 'value' => $this->shopData['country_name']],
                    ['field' => AC::FIELD_CITY, 'value' => $this->shopData['city']],
                    ['field' => AC::FIELD_ZIP, 'value' => $this->shopData['zip']],
                    ['field' => AC::FIELD_ADDRESS_LINE_1, 'value' => $this->shopData['address1']],
                    ['field' => AC::FIELD_ADDRESS_LINE_2, 'value' => $this->shopData['address2']],
                    ['field' => AC::FIELD_PROVINCE, 'value' => $this->shopData['province']],
                    ['field' => AC::FIELD_LANGUAGE, 'value' => $this->shopData['primary_locale']],
                    ['field' => AC::FIELD_STORE_NAME, 'value' => $this->shopData['name']],
                ]
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        if ($this->shopData['email'] != $this->email) {
            try {
                $contact = $activeCampaign->update($contact['id'], ['email' => $this->shopData['email']]);
            } catch (\Exception $e)     {
                logger($e->getMessage());
            }
        }

        logger('ProcessShopifyStoreUpdate finished');
    }
}
