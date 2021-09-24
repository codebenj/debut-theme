<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use App\MainSubscription;
use App\SubscriptionPaypal;

class ProcessShopifyStorePause implements ShouldQueue
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
        logger('ProcessShopifyStorePause started');

        //Pause subscription on store pause
        $activeCampaign = new ActiveCampaignJobV3();
        $contactTag = AC::TAG_EVENT_SHOPIFY_STORE_PAUSED;

        try {
            $contact = $activeCampaign->sync([
                'email' => $this->shopData['email']
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        if($this->shop->is_beta_tester != 1) {
            try {
                if (isset($this->mainSubscription->payment_platform) && $this->mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                    pauseSubscription($this->shop);
                }

                if (isset($this->mainSubscription->payment_platform) && $this->mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                    $paypalSubscription = SubscriptionPaypal::where('user_id', $this->shop->id)->orderBy('id', 'desc')->first();

                    if ($paypalSubscription && $paypalSubscription->paypal_plan) {
                        try {
                            $paypalResponse = pausePaypalSubscription($paypalSubscription->paypal_id);

                            if (@$paypalResponse['statusCode'] == 204) {
                                $paypalSubscription->paypal_status = 'SUSPENDED';
                                $paypalSubscription->ends_at = null;
                                $paypalSubscription->save();
                                $data_pause = ['plan_name' => $this->shop->alladdons_plan, 'sub_plan' => $this->shop->sub_plan];
                                $this->shop->pause_subscription = serialize($data_pause);
                                $this->shop->is_paused = 1;
                                $this->shop->save();
                                logger('paypalSubscription '.json_encode($paypalSubscription));
                            }

                        } catch (\Exception $e) {
                            logger($e->getMessage());
                        }
                    }
                }
            } catch (\Exception $e) {
                logger($e->getMessage());
            }
        }
        
        try {
            if ($contactTag) {
                $tag = $activeCampaign->tag($contact['id'], $contactTag);
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        logger('ProcessShopifyStorePause finished');
    }
}
