<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Carbon\Carbon;
use App\StripePlan;
use App\SubscriptionPaypal;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\ActiveCampaignJobV3;
use App\Jobs\ShareasaleCommission;
use App\Jobs\LinkminkJob;
use Illuminate\Support\Facades\Hash;
use App\Constants\ActiveCampaignConstants as AC;

class PaypalWebhookController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $eventType = $request->get('event_type');
            logger('Paypal Webhook Event Type ' . $eventType, $request->all());

            switch ($eventType)
            {
                case $eventType == "BILLING.SUBSCRIPTION.CANCELLED";
                    $this->handleSubscriptionCancel($request);
                    break;
                case $eventType == "PAYMENT.SALE.COMPLETED";
                    $this->handleSubscriptionRenew($request);
                    break;
                case $eventType == "BILLING.SUBSCRIPTION.ACTIVATED";
                    $this->handleSubscriptionActivated($request);
                    break;
                case $eventType == "BILLING.SUBSCRIPTION.PAYMENT.FAILED";
                    $this->handleSubscriptionPaymentFailed($request);
                    break;
                case $eventType == "BILLING.SUBSCRIPTION.SUSPENDED";
                    $this->handleSubscriptionSuspended($request);
                    break;
                case $eventType == "PAYMENT.SALE.REFUNDED";
                    $this->handleRefund($request);
                    break;
            }
        }
        catch (Exception $exception)
        {
            logger("Paypal Webhook Error " . $exception->getMessage());
        }
    }

    private function getSubIdFromRequest($request)
    {
        $tempReq = $request->toArray();
        logger('PaypalWebhookController/getSubIdFromRequest subscription id ' . $tempReq['resource']['id']);
        return $tempReq['resource']['id'];
    }

    private function handleRefund(Request $request)
    {
        logger('===PaypalWebhookController/handleRefund started ===');
        try {
            $shop = User::where('name', $request['resource']['custom'])->first();

            if ($shop) {
                logger('===PaypalWebhookController/handleRefund name ===' . $request['resource']['custom']);
                $shop->increment('refund_count');
            }
        } catch (Exception $e) {
            logger("PaypalWebhookController/handleRefund Error Message " . $e->getMessage());
        }

        logger('===PaypalWebhookController/handleRefund ended ===');
        return true;
    }

    private function handleSubscriptionCancel(Request $request)
    {
        logger('===PaypalWebhookController/handleSubscriptionCancel started ===');
        try
        {
            $subId = $this->getSubIdFromRequest($request);
            $subscription = SubscriptionPaypal::where('paypal_id', $subId)->activeOrSuspended()->first();
            logger("PaypalWebhookController/handleSubscriptionCancel subscription " . json_encode($subscription));
            if ($subscription)
            {
                $shop = User::find($subscription->user_id);
                $requestArr = $request->toArray();
                $plan = StripePlan::where('paypal_plan', $subscription->paypal_plan)->first();
                logger("PaypalWebhookController/handleSubscriptionCancel plan " . json_encode($plan));
                app('App\Http\Controllers\ThemeController')->cancel_all_subscription($request, $plan, false, $shop);

                $subscription->paypal_status = 'CANCELLED';
                $subscription->save();
            }
            else
            {
                logger("PaypalWebhookController/handleSubscriptionCancel NO SUBSCRIPTION FOUND ");
                return true;
            }
        }
        catch (Exception $e)
        {
            logger("PaypalWebhookController/handleSubscriptionCancel Error Message " . $e->getMessage());
            return true;
        }

        logger('===PaypalWebhookController/handleSubscriptionCancel ended ===');
        return true;
    }


    private function handleSubscriptionActivated(Request $request)
    {
        $arrReq = $request->toArray();
        logger('===PaypalWebhookController/handleSubscriptionActivated started ===');
        try
        {
            if (isset($arrReq['resource']['id']) && $arrReq['resource']['id'] != '')
            {
                $subId = $this->getSubIdFromRequest($request);
                $subscription = SubscriptionPaypal::where('paypal_id', $subId)->where('paypal_status','!=','CANCELLED')->first();
                
                if ($subscription)
                {
                    $user = User::find($subscription->user_id);
                    $plan = StripePlan::where('paypal_plan', $arrReq['resource']['plan_id'])->first();

                    logger('PaypalWebhookController/handleSubscriptionActivated user ' . json_encode($user));
                    $subscription_response = SubscriptionPaypal::updateOrCreate(['paypal_id' => $subId], [
                        'user_id' => $user->id,
                        'name' => $subscription->name,
                        'paypal_status' => 'ACTIVE',
                        'paypal_plan' => $arrReq['resource']['plan_id'],
                        'paypal_email' => $arrReq['resource']['subscriber']['email_address'],
                        'quantity' => 1,
                        'ends_at' => Carbon::parse($arrReq['resource']['billing_info']['next_billing_time'])->toDateTimeString()
                    ]);

                    $shop = User::find($subscription->user_id);
                    if($shop && $shop->is_paused) {
                        $unpaused_plan = unserialize($shop->pause_subscription);

                        app('App\Http\Controllers\Api\ThemeController')->unpauseAllAddOn($shop, 'master');
                        $license_key = Hash::make(Str::random(12));
                        $shop->all_addons = 1;
                        $shop->alladdons_plan = $unpaused_plan['plan_name'];
                        $shop->license_key = $license_key;
                        $shop->is_paused = 0;
                        $shop->pause_subscription = null;
                        $shop->save();
                    }

                    logger("PaypalWebhookController/handleSubscriptionActivated shop  " . json_encode($shop));

                    $activeCampaign = new ActiveCampaignJobV3();
                    $contact = $activeCampaign->sync([
                        'email' => $shop->email,
                        'fieldValues' => [
                            [
                                'field' => AC::FIELD_THEME_BILLING, 'value' => $plan->cycle
                            ]
                        ]
                    ]);
                    $tagSuccessfulPayment = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_SUCCESSFUL_PAYMENT);
                    $tagFailedPayment = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_FAILED_PAYMENT);
                    if ($tagFailedPayment)
                    {
                        $untag = $activeCampaign->untag($tagFailedPayment['id']);
                    }
                }
            }
        }
        catch (Exception $e)
        {
            logger("PaypalWebhookController/handleSubscriptionActivated Error Message " . $e->getMessage());
            return true;
        }
        logger('===PaypalWebhookController/handleSubscriptionActivated ended ===');
        return true;
    }


    private function handleSubscriptionRenew(Request $request)
    {
        /*
         * Determine if payment from subscription
         */
        if ($request->input('resource.billing_agreement_id'))
        {
            $subId = $request->input('resource.billing_agreement_id');
        }
        else
        {
            return true;
        }

        $subscriptionPaypal = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/" . $subId))->json();

        $subscription = SubscriptionPaypal::where('paypal_id', $subId)->first();
        /*
         * Determine if the payment is from a subscription renew
         * Check if cycle_completed greater than 1
         * default is 1 for new created subscription
         */
        if (!$subscriptionPaypal || Arr::get($subscriptionPaypal, 'billing_info.cycle_executions.0.cycles_completed', 0) <= 1)
        {
            logger('===PaypalWebhookController/handleSubscriptionRenew false alarm ===', [
                "subscription_paypal" => $subscriptionPaypal,
                'subscription' => $subscription,
                "request" => $request->all(),
            ]);
            return true;
        }

        logger('===PaypalWebhookController/handleSubscriptionRenew started ===', [
            "subscription_paypal" => $subscriptionPaypal,
            'subscription' => $subscription,
            "request" => $request->all(),
        ]);

        if ($subscription)
        {
            $shop = User::find($subscription->user_id);
            if (empty($shop))
            {
                logger('PaypalWebhookController/handleSubscriptionRenew shop not found');
                return true;
            }

            try
            {
                $amount = (float) $request->input('resource.amount.total');
                $transaction_fee = (float) $request->input('resource.transaction_fee.value');
                if ($shop->commission_count < 12)
                {
                    $data['amount'] = $amount - $transaction_fee;
                    $data['tracking'] = $request->input('resource.id');
                    $data['ordernumber'] = $subId;
                    $data['date'] = now();
                    $data['action'] = 'reference';
                    dispatch(new ShareasaleCommission($shop, $data));
                }

                // dispatch linkmink
                if (config('env-variables.LINKMINK_API')) {
                    $dataLinkmink['amount'] = $amount;
                    $dataLinkmink['paypalid'] = $subId;
                    $dataLinkmink['email'] = $subscription->paypal_email;
                    $dataLinkmink['paypalplan'] = $subscription->paypal_plan;

                    dispatch(new LinkminkJob($shop, $dataLinkmink, 'renewal'));
                }

                if (config('env-variables.IMPACT_ENABLED'))
                {
                    $curl = curl_init();
                    $generateBase64 = base64_encode(config('env-variables.IMPACT_USERNAME').':'.config('env-variables.IMPACT_PASSWORD'));
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.impact.com/Advertisers/IR4tZu7VkvDr2559139NXkEsVhZJYravM1/Conversions',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{
                            "CampaignId" : "12660",
                            "ActionTrackerId" : "24406",
                            "EventDate" :"' . Carbon::now()->toIso8601String() . '",
                            "orderId" : "' . $subId . '",
                            "customerId" : "' . $shop->id . '",
                            "ItemSubTotal1" : "' . $amount . '",
                            "ItemCategory1" : "' . $shop->sub_plan . '",
                            "ItemSku1" : "' . $shop->alladdons_plan . '",
                            "orderPromoCode" : "",
                            "ItemQuantity1" : 1
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                            'Authorization: Basic ' . $generateBase64
                        ),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    logger('PaypalWebhookController/handleSubscriptionRenew Impact API Response ' . $response);
                }
            }
            catch (Exception $exception)
            {
                logger("PaypalWebhookController/handleSubscriptionRenew Failed to Impact API Call. Error Message " . $exception->getMessage());
                return true;
            }
        }
        logger('===PaypalWebhookController/handleSubscriptionRenew ended ===');
        return true;
    }


    private function handleSubscriptionPaymentFailed(Request $request)
    {
        logger('===PaypalWebhookController/handleSubscriptionActivated started ===');
        try
        {
            $subId = $this->getSubIdFromRequest($request);
            echo    $subId;
            logger('===PAYPAL $subId ===');
            $subscription = SubscriptionPaypal::where('paypal_id', $subId)->activeOrSuspended()->first();
            if ($subscription)
            {
                logger('===PAYPAL Subscription exists ===');
                $shop = User::find($subscription->user_id);
                logger("PaypalWebhookController/handleSubscriptionPaymentFailed shop  " . json_encode($shop));
                $activeCampaign = new ActiveCampaignJobV3();
                $contact = $activeCampaign->sync(['email' => $shop->email]);
                $tagFailedPayment = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_FAILED_PAYMENT);
                $tagSuccessfulPayment = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_SUCCESSFUL_PAYMENT);

                if ($tagSuccessfulPayment)
                {
                    $untag = $activeCampaign->untag($tagSuccessfulPayment['id']);
                }
            }
        }
        catch (Exception $e)
        {
            logger("PaypalWebhookController/handleSubscriptionActivated Error Message " . $e->getMessage());
            return true;
        }
        logger('===PaypalWebhookController/handleSubscriptionActivated ended ===');
        return true;
    }

    private function handleSubscriptionSuspended(Request $request)
    {
        logger('===PaypalWebhookController/handleSubscriptionSuspended started ===');
        try
        {
            $subId = $this->getSubIdFromRequest($request);
            $subscription = SubscriptionPaypal::where('paypal_id', $subId)->where('paypal_status', SubscriptionPaypal::ACTIVE)->first();

            if ($subscription)
            {
                $shop = User::find($subscription->user_id);
                logger("PaypalWebhookController/handleSubscriptionSuspended shop  " . json_encode($shop));

                if ($shop->alladdons_plan != 'Starter' && $shop->alladdons_plan != 'Hustler' && $shop->alladdons_plan != 'Master')
                {
                    logger("PaypalWebhookController/handleSubscriptionSuspended already  " . $shop->name);
                    return;
                }

                SubscriptionPaypal::where('paypal_id', $subId)->update(['paypal_status' => SubscriptionPaypal::SUSPENDED]);
                $plan_name = $shop->alladdons_plan;
                $sub_plan = $shop->sub_plan;

                $shop->is_paused = 1;
                $data_pause = ['plan_name' => $plan_name, 'sub_plan' => $sub_plan];
                $shop->pause_subscription =  serialize($data_pause);
                $shop->alladdons_plan = "Freemium";
                $shop->save();

                if ($shop->script_tags)
                {
                    deleteScriptTagCurl($shop);
                }

                $activeCampaign = new ActiveCampaignJobV3();
                $contact = $activeCampaign->sync([
                    'email' => $shop->email,
                    'fieldValues' => [
                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $plan_name],
                        ['field' => AC::FIELD_THEME_BILLING, 'value' => null],
                    ]
                ]);
                $tag = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);
            }
        }
        catch (Exception $e)
        {
            logger("PaypalWebhookController/handleSubscriptionSuspended Error Message " . $e->getMessage());
            return true;
        }
        logger('===PaypalWebhookController/handleSubscriptionSuspended ended ===');
        return true;
    }
}
