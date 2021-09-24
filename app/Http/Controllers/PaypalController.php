<?php

namespace App\Http\Controllers;
use App\AddOnInfo;
use App\FreeAddon;
use App\StripePlan;
use App\SubscriptionStripe;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\SubscriptionPaypal;
use App\MainSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\ThemeController;
use App\Jobs\ActiveCampaignJobV3;
use App\Jobs\LinkminkJob;
use App\Constants\ActiveCampaignConstants as AC;
use App\Constants\SubscriptionPlans;
use Illuminate\Support\Facades\Http;

class PaypalController extends Controller
{
    public $activeCampaign;
    public function __construct()
    {
        $this->activeCampaign = new ActiveCampaignJobV3();
    }

    public function success(Request $request)
    {
        $shop = Auth::user();
        $ba_token = $request->has('ba_token') ? $request->get('ba_token'):'';
        $order_id = $request->has('orderID') ? $request->get('orderID'):'';
        $sub_id = $request->has('sub_id') ? $request->get('sub_id'):'';
        $upgrade = $request->has('upgrade') ? $request->boolean('upgrade'): false;
        $lm_data = $request->has('lm_data') ? ($request->get('lm_data') ?? '') : '';

        logger("===Paypal Subscription started===");
        logger("PaypalController/success user ".json_encode($shop));
        logger("PaypalController/success sub_id ".$sub_id);
        logger("PaypalController/success ba_token ".$ba_token);
        logger("PaypalController/success order_id ".$order_id);

        //add session for previous plan on thank you page
        session(['prevPlan' => $shop['alladdons_plan']]);

        try{
            app('App\Http\Controllers\ThemeController')->fetchInitialData();
        }catch (Exception $e){
            logger("PaypalController/success Exception 1 ".$e->getMessage());
        }
        $free_addons = FreeAddon::where('shopify_domain', $shop->name)->where('status',1)->first();

        $exit_code = '50OFF3MONTHS';
        $new_code = 'DEBUTIFY20';
        $freemium = 'Freemium';
        $starter = 'Starter';
        $hustler = 'Hustler';
        $guru = 'Master';
        $previous_plan='';
        $savings = '';
        $savings_extra10 = '';
        $next_plan = '';
        $user_count = '';
        $thank_you_data = array(
            'tracking' => '',
            'amount' => '',
            'subscription_id' => '',
            'plan_id' => '',
            'revenue' => '',
            'tax' => '',
            'savings'=> '',
            'savings_extra10'=> '',
            'next_plan'=> '',
            'user_count'=> '',
            'alladdons_plan' => '',
            'sub_plan' => '',
            'coupon' => '',
        );

        //Finding if any subscription active, cancel active subscription before activating new one.
        $current_sub = SubscriptionPaypal::activeOrSuspended()
            ->where('user_id',$shop->id)->where('paypal_id','<>',$sub_id)
            ->orderBy('id', 'desc')->first();
        logger("PaypalController/success current_sub ".json_encode($current_sub));
        if($current_sub)
        {
            logger("Paypal Active subscription found cancelling this before activating new one - step1: upselltesting");
            $this->cancelSubscription($request,$current_sub,$current_sub->paypal_id);

            if($upgrade) {
                logger("Paypal action upgrade true: Subscription found cancelling and refund this before activating new one - step13: upselltesting");
                $this->refundSubscription($current_sub,$current_sub->paypal_id);
            }
        }

        $stripeSubs = SubscriptionStripe::where('user_id',$shop->id)->where('stripe_status','active')
            ->orderBy('id', 'desc')->first();
        if($stripeSubs){
            cancelStripeSubscription($stripeSubs);
        }
        if($sub_id != ''){
            $paypalResponse = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}"))->json();
            logger("PaypalController/success paypalResponse ".json_encode($paypalResponse));
            $paypalPlanResponse = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/plans/${paypalResponse['plan_id']}"))->json();
            logger("PaypalController/success paypalPlanResponse ".json_encode($paypalPlanResponse));
            $isBrandNewSubscription = MainSubscription::where('user_id',$shop->id)->get();
            logger("PaypalController/success isBrandNewSubscription ".json_encode($isBrandNewSubscription));
            $planDetails = explode("Price",$paypalPlanResponse['name']);
            $current_cost = $paypalPlanResponse['billing_cycles'][0]['pricing_scheme']['fixed_price']['value'];
            $planName = $planDetails[0];
            if($planName=="guru")
            {
                $planName="master";
            }
            $subPlanName = $planDetails[1];
            if(strpos($subPlanName, 'Annually') !== false) {
                $subPlanName = 'Yearly';
            } else if(strpos($subPlanName, 'Quarterly') !== false) {
                $subPlanName = 'Quarterly';
            } else if(strpos($subPlanName, 'Monthly') !== false) {
                $subPlanName = 'Monthly';
            }
            logger("PaypalController/success subPlanName ".$subPlanName);

            if (strtolower($subPlanName) == "yearly") {
                $planEndDate = Carbon::parse($paypalResponse['start_time'])->addYear(1)->toDateTimeString();
            } else if (strtolower($subPlanName) == "quarterly") {
                $planEndDate = Carbon::parse($paypalResponse['start_time'])->addMonth(3)->toDateTimeString();
            } else {
                $planEndDate = Carbon::parse($paypalResponse['start_time'])->addMonth(1)->toDateTimeString();
            }
            logger("PaypalController/success  planEndDate ".$planEndDate);
            try {
                DB::transaction(function() use ($sub_id, $shop,$paypalResponse,$paypalPlanResponse,$planEndDate,$planName,$subPlanName){
                    $mainSubscription = MainSubscription::updateOrCreate(['user_id' => $shop->id],['payment_platform' => 'paypal']);
                    logger("PaypalController/success mainSubscription ".json_encode($mainSubscription));
                    $paypalSubcription = SubscriptionPaypal::updateOrCreate(
                        ['user_id' => $shop->id , 'paypal_id' => $sub_id],
                        [
                            'user_id' => $shop->id,
                            'name' => $paypalPlanResponse['name'],
                            'paypal_id' => $paypalResponse['id'],
                            'paypal_status' => $paypalResponse['status'],
                            'paypal_plan' => $paypalResponse['plan_id'],
                            'paypal_email' => $paypalResponse['subscriber']['email_address'],
                            'quantity' => 1,
                            'ends_at' => $planEndDate,
                        ]
                    );
                    logger("PaypalController/success paypalSubcription ".json_encode($paypalSubcription));
                });
            }
            catch (Exception $e){
                logger("PaypalController/success Exception 2 ".$e->getMessage());
            }
            $applyTaxes = false;
            //setting data as per stripe sub.
            $shopData = $shop->api()->request(
                'GET',
                '/admin/api/shop.json',
                []
            )['body']['shop'];

            logger("PaypalController/success shopData ".json_encode($shopData));

            if($shopData['country_name'] == 'Canada'){
                $applyTaxes = true;
            }
            $shop->sub_trial_ends_at = 0;
            $shop->trial_days = 0;
            $shop_owner = $shopData['shop_owner'];

            // dispatch linkmink
            if (config('env-variables.LINKMINK_API') && $lm_data != '') {
                $data['lmdata'] = $lm_data;
                $data['planname'] = $planName . ' ' . $subPlanName;
                $data['amount'] = $current_cost;
                $data['paypalid'] = $sub_id;
                $data['paypalplan'] = $paypalResponse['plan_id'];
                $data['email'] = $paypalResponse['subscriber']['email_address'];

                dispatch(new LinkminkJob($shop, $data, 'subscription'));
            }

            // Active campain (remove cancelled tag)
            try {
                $contact = $this->activeCampaign->sync([
                    'email' => $shop->email,
                    'fieldValues' => [
                        ['field' => AC::FIELD_PAYPAL_EMAIL, 'value' => $paypalResponse['subscriber']['email_address']],
                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $shop->alladdons_plan]
                    ]
                ]);
                $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);

                if ($contactTag) {
                    $untag = $this->activeCampaign->untag($contactTag['id']);
                }
            } catch (Exception $e) {
                $e->getMessage();
            }
            setPlanActionTag($shop, ucfirst($planName));
            
            try{
                $shop->all_addons = 1;
                $shop->alladdons_plan = ucfirst($planName);
                $shop->sub_plan = $subPlanName;
                // license key created
                $license_key = Hash::make(Str::random(12));
                $shop->license_key = $license_key;
                $shop->custom_domain = $shopData['domain'];
                $shop->is_paused = null;
                $shop->pause_subscription = null;
                if($shop->script_tags){
                    addScriptTag($shop);
                }
                $shop->save();

                // Active campain (remove plan month free tag)
                try {
                    $contact = $this->activeCampaign->sync([
                        'email' => $shop->email,
                        'fieldValues' => [
                            ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $shop->alladdons_plan]
                        ]
                    ]);
                    logger("PaypalController/success contact ".json_encode($contact));
                    $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_MONTH_FREE);

                    logger("PaypalController/success contactTag ".json_encode($contactTag));
                    if ($contactTag) {
                        $untag = $this->activeCampaign->untag($contactTag['id']);
                    }
                }
                catch(Exception $e) {
                    logger("PaypalController/success Exception 3".$e->getMessage());
                }
            } catch (Exception $e){
                logger("PaypalController/success Exception 4".$e->getMessage());
            }

            $StripePlan = StripePlan:: all();
            if($free_addons){
                $free_addons = $free_addons->status;
            }

            $hustler_count = ((int) User::where('alladdons_plan', 'Hustler')->count());
            $master_count  = ((int) User::where('alladdons_plan', 'Guru')->orWhere('alladdons_plan', 'Master')->count());
            $starterPriceAnnually = $starterPriceQuarterly = $starterPriceMonthly = 0;
            $hustlerPriceAnnually = $hustlerPriceQuarterly = $hustlerPriceMonthly = 0;
            $guruPriceAnnually = $guruPriceQuarterly = $guruPriceMonthly = 0;

            // get active plan price and ID
            foreach ($StripePlan as $plan) {
                if($plan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY){
                    $starterPriceAnnually = $plan->cost;
                    $starteridAnnually = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY){
                    $starterPriceQuarterly = $plan->cost;
                    $starteridQuarterly = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY){
                    $starterPriceMonthly = $plan->cost;
                    $starteridMonthly = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY){
                    $hustlerPriceAnnually = $plan->cost;
                    $hustleridAnnually = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY){
                    $hustlerPriceQuarterly = $plan->cost;
                    $hustleridQuarterly = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY){
                    $hustlerPriceMonthly = $plan->cost;
                    $hustleridMonthly = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY){
                    $guruPriceAnnually = $plan->cost;
                    $guruidAnnually = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY){
                    $guruPriceQuarterly = $plan->cost;
                    $guruidQuarterly = $plan->stripe_plan;
                }
                if($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY){
                    $guruPriceMonthly = $plan->cost;
                    $guruidMonthly = $plan->stripe_plan;
                }
            }

            if ($subPlanName == 'Quarterly') {
                $first_month_or_year = "quarter";
                if (ucfirst($planName) == $starter ) {
                    $savings = number_format($hustlerPriceQuarterly - ($hustlerPriceQuarterly * 0.7),2);
                    $savings_extra10 = number_format($hustlerPriceQuarterly - ($hustlerPriceQuarterly * 0.6),2);
                    $next_plan = $hustler;
                    $user_count = $hustler_count;
                }
                else if (ucfirst($planName) == $hustler ) {
                    $savings = number_format($guruPriceMonthly - ($guruPriceMonthly * 0.6),2);
                    $savings_extra10 = number_format($guruPriceMonthly - ($guruPriceMonthly * 0.5),2);
                    $next_plan = $guru;
                    $user_count = $master_count;
                }
            } else if ($subPlanName != 'Annually'){
                $first_month_or_year = "month";
                if (ucfirst($planName) == $starter ) {
                    $savings = number_format($hustlerPriceMonthly - ($hustlerPriceMonthly * 0.7),2);
                    $savings_extra10 = number_format($hustlerPriceMonthly - ($hustlerPriceMonthly * 0.6),2);
                    $next_plan = $hustler;
                    $user_count = $hustler_count;
                }
                else if (ucfirst($planName) == $hustler ) {
                    $savings = number_format($guruPriceMonthly - ($guruPriceMonthly * 0.6),2);
                    $savings_extra10 = number_format($guruPriceMonthly - ($guruPriceMonthly * 0.5),2);
                    $next_plan = $guru;
                    $user_count = $master_count;
                }
            }
            else {
                $first_month_or_year = "year";
                if (ucfirst($planName) == $starter ) {
                    $savings = number_format($hustlerPriceAnnually - ($hustlerPriceAnnually * 0.7),2);
                    $savings_extra10 = number_format($hustlerPriceAnnually - ($hustlerPriceAnnually * 0.6),2);
                    $next_plan = $hustler;
                    $user_count = $hustler_count;
                }
                else if (ucfirst($planName) == $hustler ) {
                    $savings = number_format($guruPriceAnnually - ($guruPriceAnnually * 0.6),2);
                    $savings_extra10 = number_format($guruPriceAnnually - ($guruPriceAnnually * 0.5),2);
                    $next_plan = $guru;
                    $user_count = $master_count;
                }
            }

            if($planName){
                if($current_cost == '10' || $current_cost == '84' || $current_cost == '27' || $current_cost == '197' || $current_cost == '15' || $current_cost == '90'){
                    $previous_plan = $current_cost;
                }
            }
            if ($isBrandNewSubscription->isempty()) {
                $request->session()->flash('isBrandNewSubscription', true);
            }
            if($planName == 'master'){
                $request->session()->flash('subscription', 'Master');
            }
            elseif($planName == 'hustler'){
                $request->session()->flash('subscription', 'Hustler');
            }
            else{
                $request->session()->flash('subscription', 'Starter');
            }

            $planPrice = $paypalPlanResponse['billing_cycles'][0]['pricing_scheme']['fixed_price']['value'];
            $total = $paypalResponse['billing_info']['last_payment']['amount']['value'];
            $tax = $total - $planPrice;

            $request->session()->flash('status', 'Subscription activated');
            $thank_you_data = [
                'tracking' => $paypalResponse['id'],
                'amount' => $planPrice,
                'subscription_id' => $paypalResponse['id'],
                'plan_id' => $paypalResponse['plan_id'],
                'revenue' => $total,
                'tax' => $tax,
                'savings'=>$savings,
                'savings_extra10'=>$savings_extra10,
                'next_plan'=>$next_plan,
                'user_count'=>$user_count,
                'alladdons_plan' => $planName,
                'sub_plan' => $subPlanName,
                'coupon' => '',
            ];
            logger("PaypalController/success thank_you_data ".json_encode($thank_you_data));
            $request->session()->put('thank_you', true);
            session(['thank_you_data' => $thank_you_data]);
            logger("===Paypal Subscription end===");
            return redirect()->route('paypal-thankyou');
        }
        return redirect()->route('plans');
    }

    public function pausePaypalSubscriptionl(Request $request)
    {
        return redirect()->route('plans');
    }
    public function populatePlans()
    {
        $allPlans = getPaypalHttpClient()->get(getPaypalUrl('v1/billing/plans'))->json();
        foreach ($allPlans['plans'] as $plan) {
            StripePlan::where('name', $plan['name'])->update(['paypal_plan' => $plan['id']]);
        }
    }

    public function cancelSubscription($requestInfo, $subscription, $paypal_id){
        $shop = Auth::user();

        logger('PaypalController/cancelSubscription Paypal Subscription Cancellation Started for ' . $paypal_id. ' - step2: upselltesting cancelSubscription');
        logger('subscription ' . json_encode($subscription));
        if (!$subscription) {
            logger("PaypalController/cancelSubscription Paypal Subscription Cancellation Ended NO SUBSCRIPTION FOUND - step3: upselltesting cancelSubscription");
            return false;
        }
        try {
            DB::transaction(function () use ($subscription) {
                $sub_id = $subscription->paypal_id;
                logger("PaypalController/cancelSubscription Calling Cancel Paypal Subscription for " . $sub_id . ' - step4: upselltesting cancelSubscription');
                $paypalResponse = cancelPaypalSubscription($sub_id);
                logger("PaypalController/cancelSubscription paypalResponse " . json_encode($paypalResponse) . ' - step9: upselltesting cancelSubscription');

                if (@$paypalResponse['statusCode'] == 204) {
                    $subscription->paypal_status = 'CANCELLED';
                    $subscription->ends_at = null;
                    $subscription->save();
                    logger('PaypalController/cancelSubscription ' . json_encode($subscription) . ' - step10: upselltesting cancelSubscription');
                }
            });

            // Active campain
            try {
                $contact = $this->activeCampaign->sync([
                    'email' => $shop->email,
                    'fieldValues' => [
                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $shop->alladdons_plan]
                    ]
                ]);
                $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);
            } catch (Exception $e) {
                $e->getMessage();
            }
            logger("PaypalController/cancelSubscription Paypal Subscription Cancellation Ended " . $paypal_id . ' - step11: upselltesting cancelSubscription ended');
            return true;
        } catch (\Exception $exception) {
            logger("Exception - step12: upselltesting cancelSubscription");
            logger("PaypalController/cancelSubscription Paypal Subscription Cancellation Error for " . $paypal_id);
            logger("PaypalController/cancelSubscription Error Message " . $exception->getMessage());
            return false;
        }
    }

    public function refundSubscription($subscription, $paypal_id){
        $shop = Auth::user();

        logger('PaypalController/refundSubscription Paypal Subscription Refund Started for ' . $paypal_id . ' - step14: upselltesting refundSubscription started');
        logger('subscription ' . json_encode($subscription));
        if (!$subscription) {
            logger("PaypalController/refundSubscription Paypal Subscription Refund Ended NO SUBSCRIPTION FOUND  - step15: upselltesting refundSubscription");
            return false;
        }
        try {
            $sub_id = $subscription->paypal_id;
            logger("PaypalController/refundSubscription Calling Refund Paypal Subscription for " . $sub_id . ' - step16: upselltesting refundSubscription');
            $paypalResponse = refundPaypalSubscription($sub_id);
            logger("PaypalController/refundSubscription paypalResponse " . json_encode($paypalResponse));

            if (@$paypalResponse['statusCode'] != 201) {
                logger("- step21: upselltesting refundSubscription");
                return false;
            }
            logger("PaypalController/refundSubscription Paypal Subscription Refund Ended  - step22: upselltesting refundSubscription ended" . $paypal_id);
            return true;
        } catch (\Exception $exception) {
            logger("- step23: upselltesting refundSubscription ended");
            logger("PaypalController/refundSubscription Paypal Subscription Refund Error for " . $paypal_id);
            logger("PaypalController/refundSubscription Error Message " . $exception->getMessage());
            return false;
        }
    }    
}