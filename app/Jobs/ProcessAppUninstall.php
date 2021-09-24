<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ActiveCampaignJobV3;
use App\MainSubscription;
use App\SubscriptionPaypal;
use App\Constants\ActiveCampaignConstants as AC;

class ProcessAppUninstall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shopData;
    public $shop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shopData, $shop)
    {
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
        logger('ProcessAppUninstall started');
        $activeCampaign = new ActiveCampaignJobV3();

        if (isset($this->shop->script_tags) && $this->shop->script_tags) {
            deleteScriptTagCurl($this->shop);
        }

        $contact = $activeCampaign->sync([
            'email' => $this->shopData['email'],
            'fieldValues' => [
                ['field' => AC::FIELD_APP_STATUS, 'value' => 'Uninstalled'],
            ]
        ]);

        intercomUpdate($this->shopData['id'], ['custom_attributes' => ['App Status' => 'Uninstalled']]);

        //Pause subscription
        try {
            $mainSubscription = $this->shop->mainSubscription;
            
            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                pauseSubscription($this->shop);
            }

            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
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

        $this->shop->license_key = null;
        $this->shop->uninstalled_at = now();
        $this->shop->deleted_at = date("Y-m-d H:i:s");
        $this->shop->save();
        logger('ProcessAppUninstall ended');
    }
}
