<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\MainSubscription;
use App\SubscriptionPaypal;
use App\SubscriptionStripe;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;

class ProcessShopifyStoreClose implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mainSubscription;
    public $shopData;
    public $shop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mainSubscription, $shopData, $shop)
    {
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
        logger('ProcessShopifyStoreClose started');
        $activeCampaign = new ActiveCampaignJobV3();

        if (isset($this->mainSubscription->payment_platform) && $this->mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
            $subscription = SubscriptionStripe::where('user_id', $this->shop->id)->orderBy('id', 'desc')->first();

            //Cancel subscription on store close
            if (isset($subscription->stripe_plan)) {
                try {
                    cancelSubscription($this->shop);
                } catch (\Exception $e) {
                    logger($e->getMessage());
                }
            }
        }

        if (isset($this->mainSubscription->payment_platform) && $this->mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
            $paypalSubscription = SubscriptionPaypal::where('user_id', $this->shop->id)->orderBy('id', 'desc')->first();
            if ($paypalSubscription && $paypalSubscription->paypal_plan) {
                try {
                    $paypalResponse = cancelPaypalSubscription($paypalSubscription->paypal_id);

                    if (@$paypalResponse['statusCode'] == 204) {
                        $paypalSubscription->paypal_status = 'CANCELLED';
                        $paypalSubscription->ends_at = null;
                        $paypalSubscription->save();
                        logger('paypalSubscription '.json_encode($paypalSubscription));
                    }
                } catch (\Exception $e) {
                    logger($e->getMessage());
                }
            }
        }

        $contactTag = AC::TAG_EVENT_SHOPIFY_STORE_CLOSED;

        try {
            $contact = $activeCampaign->sync([
                'email' => $this->shopData['email'],
                'fieldValues' => [
                    [
                        'field' => AC::FIELD_THEME_BILLING, 'value' => null
                    ],
                    [
                        'field' => AC::FIELD_APP_STATUS, 'value' => AC::FIELD_VALUE_APP_STATUS_UNINSTALLED
                    ],
                    [
                        'field' => AC::FIELD_SUBSCRIPTION, 'value' => AC::FIELD_VALUE_SUBSCRIPTION_FREEMIUM
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        $this->shop->delete();

        try {
            if ($contactTag) {
                $tag = $activeCampaign->tag($contact['id'], $contactTag);
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        logger('ProcessShopifyStoreClose finished');
    }
}
