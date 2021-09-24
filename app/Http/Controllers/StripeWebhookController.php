<?php

namespace App\Http\Controllers;

use App\User;
use App\StripePlan;
use Carbon\Carbon;
use Exception;
use App\SubscriptionStripe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Events\WebhookReceived;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use App\Jobs\ShareasaleCommission;

class StripeWebhookController extends Controller
{

    /**
     * Create a new WebhookController instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (config('cashier.webhook.secret')) {
            $this->middleware(VerifyWebhookSignature::class);
        }
    }

    /**
     * Handle a Stripe webhook call.
     *
     * @param \Illuminate\Http\Request $request
     * @return boolean
     */
    public function handleWebhook(Request $request)
    {
        \logger('handle Web hook called');

        $payload = json_decode($request->getContent(), true);
        $method = 'handle' . Str::studly(str_replace('.', '_', $payload['type']));

        if ($method != 'handleInvoiceCreated') {
            //  return true;
        }

        WebhookReceived::dispatch($payload);
        \logger('method name is ' . $method);
        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return false;
    }


    /**
     * Handle invoice payment succeeded.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoiceCreated($payload)
    {
        //
    }

    private function loadImpact($payload)
    {
        if (!config('env-variables.IMPACT_ENABLED')) {
            return;
        }

        \logger('===Impact started===');
        $invoiceData = $payload['data']['object'];
        $billingType = $invoiceData['billing_reason'];
        \logger("Billing type for Impact method is " . $billingType);
        if ($billingType != 'subscription_cycle') {
             return true;
        }

        $customerId = $invoiceData['customer'];
        $amount = $invoiceData['amount_paid'];
        $tax = $invoiceData['tax'];
        $subscription = $invoiceData['subscription'];
        $couponName = $invoiceData['discount']['coupon']['name'] ?? '';

        $customer = User::where('stripe_id', $customerId)->first();
        if (empty($customer)) {
            \logger('===Impact is ended as no customer founded===');
            return true;
        }
        \logger('Subscription Renew.');
        $actionTrackerId = $billingType == 'subscription_update'|| $billingType == 'subscription_cycle' ? '24406':'23344';
        \logger('Action Tracker Id for this transaction is . '.$actionTrackerId);

        if ($tax) {
            $amount -= $tax;
        }

        // Call Impact API - when renew subscription
        try {
            // Account SID (username): IR4tZu7VkvDr2559139NXkEsVhZJYravM1
            // Auth Token (password): NVCMHrWb99iTatevpXwGx_.CYRwwcCxN
            // https://api.impact.com/Advertisers/IR4tZu7VkvDr2559139NXkEsVhZJYravM1/Conversions

            $response = Http::withBasicAuth(config('env-variables.IMPACT_USERNAME'), config('env-variables.IMPACT_PASSWORD'))
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.impact.com/Advertisers/IR4tZu7VkvDr2559139NXkEsVhZJYravM1/Conversions', [
                    'CampaignId' => '12660',
//                    'ActionTrackerId' => '23345',
                    'ActionTrackerId' => $actionTrackerId,
                    'EventDate' => Carbon::now()->toIso8601String(),
                    'orderId' => $subscription,
                    'customerId' => $customer->id,
                    'ItemSubTotal1' => $amount / 100,
                    'ItemCategory1' => $customer->sub_plan,
                    'ItemSku1' => $customer->alladdons_plan,
                    'orderPromoCode' => $couponName,
                    'ItemQuantity1' => 1
                ]);
            $response = $response->body();
            \logger($response);
        } catch (Exception $exception) {
            \logger('Failed to Impact API Call.');
            \logger($exception->getMessage());
            return false;
        };
        \logger('===Impact is ended===');
        return true;
    }

    /**
     * Handle subscription cancelled.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleSubscriptionCancelled(Request $request)
    {
        logger('Customer sub deleted webhook');

        try {
            $object = $request['data']['object'];
            logger('Stripe subs webhook delete request object' . json_encode($object));
            $subscription = SubscriptionStripe::where('stripe_id', $object['id'])->where('stripe_status', 'active')->first();

            if($subscription) {
                $shop = User::where('stripe_id', $object['customer'])->first();
                $plan = StripePlan::where('stripe_plan', $object['plan']['id'])->first();
                app('App\Http\Controllers\ThemeController')->cancel_all_subscription($request, $plan, false, $shop);
            }
        } catch (Exception $e) {
            logger('Error in stripe cancel sub webhook');
        }

    }

    /**
     * Handle payment succeeded.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handlePaymentSucceeded(Request $request)
    {
        sleep(5);
        logger('handlePaymentSucceeded');

        $this->loadImpact($request);

        try {
            $object = $request['data']['object'];

            $shop = User::where('stripe_id', $object['customer'])->first();

            if (!$shop)
            {
                return true; #stop execute if shop doesnt exists
            }

            if ($shop->commission_count < 12)
            {
                $billingType = $object['billing_reason'];
                if ($billingType === 'subscription_cycle')
                {
                    $amount = (float) $object['total'];
                    $tax = (float) $object['tax'];
                    $subscription = $object['subscription'];
                    $amount -= $tax;
                    $data['amount'] = ((float) $amount) / 100; #format amount from cent
                    $data['tracking'] = $object['id']; #use invoice id to avoid shareasale not persisting
                    $data['ordernumber'] = $subscription;
                    $data['date'] = now();
                    $data['action'] = 'reference';
                    dispatch(new ShareasaleCommission($shop, $data));
                }
            }

            $cycle = optional(optional($shop->stripeSubscription)->plan)->cycle;

            $activeCampaign = new ActiveCampaignJobV3();
            $contact = $activeCampaign->sync([
                'email' => $shop->email,
                'fieldValues' => [
                    [
                        'field' => AC::FIELD_THEME_BILLING, 'value' => $cycle
                    ]
                ]
            ]);
            $tagSuccessfulPayment = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_SUCCESSFUL_PAYMENT);
            $tagFailedPayment = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_FAILED_PAYMENT);

            if ($tagFailedPayment) {
                $untag = $activeCampaign->untag($tagFailedPayment['id']);
            }

        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Handle refund
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleRefund(Request $request)
    {
        logger('handleRefund');

        try {
            $object = $request['data']['object'];
            $shop = User::where('stripe_id', $object['customer'])->first();

            if ($shop) {
                $shop->increment('refund_count');
            }
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Handle payment failed.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handlePaymentFailed(Request $request)
    {
        sleep(5);
        logger('handlePaymentFailed');

        try {
            $object = $request['data']['object'];
            $shop = User::where('stripe_id', $object['customer'])->first();
            $activeCampaign = new ActiveCampaignJobV3();
            $contact = $activeCampaign->sync(['email' => $shop->email]);
            $tagFailedPayment = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_FAILED_PAYMENT);
            $tagSuccessfulPayment = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_SUCCESSFUL_PAYMENT);

            if ($tagSuccessfulPayment) {
                $untag = $activeCampaign->untag($tagSuccessfulPayment['id']);
            }
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }
}
