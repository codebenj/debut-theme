<?php

namespace App\Http\Controllers;

use App\User;
use App\Subscription;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\MainSubscription;
use App\SubscriptionStripe;
use App\SubscriptionPaypal;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Currently included as attribute on the User model
    public function getAddonsPlan($shop) {
        $trial_plan = 'Master';
        $trial_days = $shop->trial_days;

        $all_addons_plan = ( $trial_days == 0 || $trial_days == null ) ? $shop->alladdons_plan : $trial_plan;

        return $all_addons_plan;
    }

    public function formatContent($content) {
        if ( isset( $content ) && ! ! empty( $content ) ) {
            $content = str_replace('"', "'", str_replace(["\r\n", "\r", "\n"], "<br/>", $content));
        }

        return $content;
    }

    // is theme completely download or procesing
    public function getThemeProcessing($theme_id){
        $shop = Auth::user();
        $endPoint = "/admin/api/themes/{$theme_id}.json";

        try {
            $is_theme_processing  = $shop->api()->request('GET', $endPoint )['body']['theme'];
        } catch (\Exception $e) {
            $is_theme_processing = $e->getMessage();
        }

        if (isset($is_theme_processing['processing'])) {
            return $is_theme_processing['processing'];
        }

        return true;
    }

    public function routesArray() {
        return [
            'home',
            'plans',
            'app_courses',
            'theme_addons',
            'theme_view',
            'winning_products',
            'mentoring',
            'app_partners',
            'integrations',
            'billing',
            'changelog',
            'support',
            'feedback',
            'affiliate',
            'free_trial_expired_old'
        ];
    }

    public function subscriptionStatus() {
        $shop = Auth::user();

        // subscription status
        $subscriptionStatus = '';

        $mainSubscription = $shop->mainSubscription;

        if (isset($mainSubscription)) {

            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE)
            {
                $subscription = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();

                if ($subscription && $subscription->stripe_id)
                {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                    $stripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_id);

                    if ($stripeSubscription)
                    {
                        if ( $stripeSubscription->status == 'past_due' )
                        {
                            $subscriptionStatus = 'past_due';
                        }
                        else if ( $stripeSubscription->status == 'unpaid')
                        {
                            $subscriptionStatus = 'unpaid';
                            $shop->license_key = null;
            
                            if ( $shop->script_tags )
                            {
                                deleteScriptTagCurl( $shop );
                            }
            
                        }
                        else if ( $stripeSubscription->status == 'active' )
                        {
                            $license_key = Hash::make( Str::random(12) );
                            $shop->license_key = $license_key;
            
                            if ( $shop->script_tags )
                            {
                                addScriptTag( $shop );
                            }
                        }
                    }
                    $shop->save();
                }
            }

            if ($mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL)
            {
                $subscription = $shop->paypalSubscription()->status('ACTIVE')->first();
   
                if ($subscription && isset($subscription->paypal_id)) {
                    $paypalSubId = $subscription->paypal_id;
                    $paypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("/v1/billing/subscriptions/${paypalSubId}"))->json();
   
                   if ($paypalSubscription)
                   {
                       if ($paypalSubscription['status'] == 'EXPIRED')
                       {
                           $subscriptionStatus = 'past_due';
                       }
                       else if ($paypalSubscription['status'] == 'CANCELLED'|| $paypalSubscription['status'] == 'SUSPENDED')
                       {
                           $subscriptionStatus = 'unpaid';
                           $shop->license_key = null;
   
                           if ($shop->script_tags)
                           {
                               deleteScriptTagCurl($shop);
                           }
                       }
                       else if ($paypalSubscription['status'] == 'ACTIVE')
                       {
                           $subscriptionStatus = 'active';
                           $license_key = Hash::make(Str::random(12));
                           $shop->license_key = $license_key;
   
                           if ($shop->script_tags)
                           {
                               addScriptTag($shop);
                           }
                       }
   
                       $shop->save();
                   }
                }
            }
        }

        return $subscriptionStatus;
    }

    public function getPaypalSubscription()
    {
        try {
            $shop = Auth::user();
            $mainSubscription = $shop->mainSubscription;

            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL)
            {
                $subscription = $shop->paypalSubscription()->status('ACTIVE')->first();

                if ($subscription && isset($subscription->paypal_id)) {
                    $paypalSubId = $subscription->paypal_id;
                    $getPaypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("/v1/billing/subscriptions/${paypalSubId}"))->json();

                    return [
                        'subscription' => $subscription,
                        'data' => $getPaypalSubscription
                    ];
                }
            }

            return false;
        } catch (\Exception $th) {
            //throw $th;
        }
    }

    public function getStripeSubscription()
    {
        try {
            $shop = Auth::user();
            $mainSubscription = $shop->mainSubscription;
            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE)
            {
                $subscription = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();

                if ($subscription && $subscription->stripe_id)
                {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                    $stripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_id);

                    return [
                        'subscription' => $subscription,
                        'data' => $stripeSubscription
                    ];
                }
            }

            return false;
        } catch (\Exception $e) {
            //throw $th;
        }
    }
    public function getShareSale($amount,$tracking)
    {
        // Please add these variable in the .env
        $myMerchantID = config('services.shareasale.merchant_id');
        $APIToken = config('services.shareasale.token');
        $APISecretKey = config('services.shareasale.secret');
        $APIVersion =  config('services.shareasale.version');
        $myTimeStamp = gmdate(DATE_RFC1123);
        
        // Getting the SSID Cookie from the landing page for api Its SSID
        
        // Static Cookie value of ssid is for testing purpose
        $ssid =  Cookie::get('sas_m_awin') ? cookie::get('sas_m_awin') : '61k5_12zjos';

        if($ssid){
            $APIVersion = 2.9;
            $actionVerb = "new";
            $sig = $APIToken.':'.$myTimeStamp.':'.$actionVerb.':'.$APISecretKey;

            $sigHash = hash("sha256",$sig);

            $myHeaders = array("x-ShareASale-Date: $myTimeStamp","x-ShareASale-Authentication: $sigHash");
       
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.shareasale.com/w.cfm?merchantId=$myMerchantID&token=$APIToken&version=$APIVersion&action=$actionVerb&tracking=$tracking&transtype=sale&amount=$amount&sscid=$ssid");
            curl_setopt($ch, CURLOPT_HTTPHEADER,$myHeaders);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $returnResult = curl_exec($ch);

            if ($returnResult) 
            {
                //parse HTTP Body to determine result of request
                if (stripos($returnResult,"Error Code ")) {
                    // error occurred
                    trigger_error($returnResult,E_USER_ERROR);
                }
                else{
                    // success
                    return true;
                    echo $returnResult;
                }
            }

            else
            {
                // connection error
                trigger_error(curl_error($ch),E_USER_ERROR);
            }

            curl_close($ch);
        }
    }
}
