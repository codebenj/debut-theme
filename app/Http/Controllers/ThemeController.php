<?php

namespace App\Http\Controllers;

use App\Constants\Master;
use App\MainSubscription;
use App\SubscriptionPaypal;
use DateTime;
use Exception;
use App\User;
use App\Taxes;
use App\AddOns;
use App\Themes;
use App\Updates;
use App\Course;
use App\FreeAddon;
use App\StripePlan;
use App\ChildStore;
use App\StoreThemes;
use App\AddOnInfo;
use App\Subscription;
use App\SubscriptionStripe;
use App\GlobalAddons;
use App\MentoringCall;
use App\WinningProduct;
use App\Partner;
use App\FrequentlyAskedQuestion;
use App\Jobs\ActiveCampaignJob;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cookie;
use App\ExtendTrial;
use App\UserExtendTrialRequest;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use Mediatoolkit\ActiveCampaign\Client as ACClient;
use App\Constants\SubscriptionPlans;

class ThemeController extends Controller{
    public $subscription_status;
    public $secong_addon_name;
    public $third_theme_name;
    public $activeCampaign;

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */

    public function __construct(){
      $shop = Auth::user();
      $this->activeCampaign = new ActiveCampaignJobV3();
    }


    public function fetchInitialData(){
        $shop = Auth::user();
        $subscription = null;
          //         $api_action = 'contact_tag_add';
          // $this->addactive_campaign($shop, "Free", 'app', 'Event - Plan Month Free',$api_action);
          // die;


        //compairUpdateCommonFilesDiff($shop, 'templates/cart.liquid', 120138924181, 118902751381, '2.0.2');
        //exit();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        if($shop){
          // Mentoring Data
          $mentoringWinnercount = MentoringCall::where('user_id', $shop->id)->where('days', '>', 0)->count();
          // if($mentoringCallWinner){
          //   logger("mentoring Call Winner store");
          //   logger(json_encode($mentoringCallWinner));
          // }
          // user details
            $owner_details = array();

            $shopData = $shop->api()->request(
                'GET',
                '/admin/api/shop.json',
                []
            )['body']['shop'];

            $shop_owner = $shopData['shop_owner'];
            $shop_owner_name = explode(" ", $shop_owner);


            if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
              $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
            }
            else {
              $latest_theme = Themes::where('is_beta_theme', NULL)->orWhere('is_beta_theme', 0)->orderBy('id', 'desc')->first();
            }
            $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
            $latestupload = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('id', 'desc')->first();


            /*if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
                $latestupload = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('id', 'desc')->first();
            }else{
                $latest_theme = Themes::where('is_beta_theme', NULL)->orWhere('is_beta_theme', 0)->orderBy('id', 'desc')->first();
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
                $latestupload = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orderBy('id', 'desc')->first();
            }*/

            if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }


              $new_update_theme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('version', $latest_theme->version)->orderBy('id', 'desc')->count();


            if(!isset($StoreThemes) || empty($StoreThemes)){
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
            }

            if(!isset($latestupload) || empty($latestupload)){
                $latestupload = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('id', 'desc')->first();
            }

            // echo "<pre>"; print_r($StoreThemes);
            // die;

            $prior_beta_theme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->orderBy('role', 'desc')->orderBy('id', 'desc')->count();
            //$StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();

            $addons_count = GlobalAddons::count();
            $user_id = $shop->id;
            $already_addon_activated = AddOns::where('user_id',$shop->id)->where('status',1)->count();
            $global_add_ons = GlobalAddons::leftJoin('add_ons',function ($join) use ($user_id) {
                $join->on('global_addons.id', '=' , 'add_ons.global_id') ;
                $join->where('add_ons.user_id','=', $user_id) ;
            })->select('global_addons.*','add_ons.status', 'add_ons.global_id', 'add_ons.user_id')->orderBy('title')->get();
            $dashboard_add_ons = GlobalAddons::leftJoin('add_ons',function ($join) use ($user_id) {
                $join->on('global_addons.id', '=' , 'add_ons.global_id') ;
                $join->where('add_ons.user_id','=', $user_id) ;
            })->select('global_addons.*','add_ons.status', 'add_ons.global_id', 'add_ons.user_id')->orderBy('id', 'desc')->get();

            $addon_infos = AddOnInfo::orderBy('name')->get();
            $addon_infos_count = AddOnInfo::count();

            $theme_count = count($StoreThemes);
            $name = $shopData['shop_owner'];
            $owner = explode(' ', $name);
            $owner_details['fname']= $owner[0];
            $owner_details['phone']= $shopData['phone'];
            if(empty($owner[1]))
            {
                $owner_details['lname'] = '';
            } else {
                $owner_details['lname'] = $owner[1];
            }
            $owner_details['email']= $shopData['email'];
            $owner_details['storeID']= $shopData['id'];

            $owner_details['sign']=   hash_hmac('sha256', $shopData['id'], Master::HASH_hmac);
            // $shopdomain = Session::get('shopify_domain');

            // trial
            $trial_end_date = null;
            $show_end_at = null;
//            $subscription = Subscription::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
            $getstripesub = null;
            $getPaypalSub = null;
            $billingDate = null;
            $date = new DateTime();
            $mainSubscription = $shop->mainSubscription;
            if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                $subscription = SubscriptionStripe::where('user_id', $shop->id)->orderBy('id', 'desc')->first();

                if ($subscription && isset($subscription->stripe_id)) {

                    $getstripesub = \Stripe\Subscription::retrieve($subscription->stripe_id);
//                    $date = new DateTime();
                    $date->setTimestamp($getstripesub->current_period_end);
                    $new_format = $date->format('Y-m-d');
                    $billingDate = $new_format;
                    if (isset($subscription->trial_ends_at) && $subscription->trial_ends_at != null) {
                        $dates = new DateTime();
                        $new_formats = $dates->format('Y-m-d');
                        $dates = new DateTime($subscription->trial_ends_at);
                        $end_at = $dates->format('Y-m-d');
                        if ($end_at >= $new_formats) {
                            $show_end_at = $dates->format('M. d, Y');
                            $diff = strtotime($new_formats) - strtotime($end_at);
                            $days = abs(round($diff / 86400));
                            $trial_end_date = $days;
                        }
                    }
                } else {
                    $show_end_at = Carbon::now()->addWeek()->format('M. d, Y');
                    $trial_end_date = "7";
                }
            }
            if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {

//                $subscription = SubscriptionPaypal::where('user_id', $shop->id)->orderBy('id', 'desc')->first();
                $subscription = SubscriptionPaypal::where('user_id', $shop->id)->where('paypal_status','ACTIVE')->orderBy('id', 'desc')->first();

                if ($subscription && isset($subscription->paypal_id)) {
                    $paypalSubId = $subscription->paypal_id;
                    $getPaypalSub = getPaypalHttpClient()->get(getPaypalUrl("/v1/billing/subscriptions/${paypalSubId}"))->json();
//                    $date = new DateTime();
//                    $date->setTimestamp($getPaypalSub['billing_info']['next_billing_time']);

                    if(isset($getPaypalSub['status'])) {

                      if($getPaypalSub['status']=='ACTIVE'){
                          $new_format = Carbon::parse($getPaypalSub['billing_info']['next_billing_time'])->toDateString();
                          $billingDate = $new_format;
                          if (isset($subscription->trial_ends_at) && $subscription->trial_ends_at != null) {
                              $dates = new DateTime();
                              $new_formats = $dates->format('Y-m-d');
                              $dates = new DateTime($subscription->trial_ends_at);
                              $end_at = $dates->format('Y-m-d');
                              if ($end_at >= $new_formats) {
                                  $show_end_at = $dates->format('M. d, Y');
                                  $diff = strtotime($new_formats) - strtotime($end_at);
                                  $days = abs(round($diff / 86400));
                                  $trial_end_date = $days;
                              }
                          }
                      }

                      if($getPaypalSub['status']=='APPROVAL_PENDING'){
                          $links = $getPaypalSub['links'];
                          $approve_link = array_filter($links, function ($link) {
                              return $link['rel'] == "approve";
                          });
                          return redirect(array_values($approve_link)[0]['href']);
                      }
                  }
                } else {
                    $show_end_at = Carbon::now()->addWeek()->format('M. d, Y');
                    $trial_end_date = "7";
                }
            }

            // plans
            $freemium = 'Freemium';
            $starter = 'Starter';
            $hustler = 'Hustler';
//            $guru = 'Guru';
            $guru = 'Master';
            $starterLimit = '5';
            $hustlerLimit = '30';
            $guruLimit = '41';

            if($shop->alladdons_plan == $starter){
              $addonLimit = $starterLimit;
            }
            elseif($shop->alladdons_plan == $hustler){
              $addonLimit = $hustlerLimit;
            }
            elseif ($shop->alladdons_plan == $guru) {
              $addonLimit = $guruLimit;
            }
            else {
              $addonLimit = '0';
            }

            // master store check
            $master_shop = '';
            $card_number = '';
            if($shop->master_account != 1){
                $ch_stores =[];
                $child_store = ChildStore::where('store', $shop->name)->first();
                if($child_store){
                  // Cancle Subscription
                  $master_shops = User::where('id', $child_store->user_id)->first();
                  $master_shop = $master_shops->name;
                  // guru plan of child store
                  $shop->all_addons = 1;
                  $shop->alladdons_plan = $master_shops->alladdons_plan;
                  $shop->sub_plan = $master_shops->sub_plan;
                  $shop->is_paused = $master_shops->is_paused;

                  if($shop->is_paused == true){
                    $pause_plan_data = unserialize($master_shops->pause_subscription);
                    if(isset($pause_plan_data['plan_name']) && !empty($pause_plan_data['plan_name'])){
                      $paused_plan_name = $pause_plan_data['plan_name'];
                    }
                  }

                  // license key created
                  $license_key = Hash::make(Str::random(12));
                  $shop->license_key = $license_key;
                 // $shop->sub_trial_ends_at = $master_shops->sub_trial_ends_at;
                  $shop->save();
                  if($shop->script_tags){
                    addScriptTag($shop);
                  }
                } else{
                    if ($subscription && $subscription->stripe_id) {
                      if($getstripesub->status == "canceled"){
                        if($shop->all_addons == 1){
                          $this->delete_all_addon($shop, 'child',1);
                          $subscription->ends_at = $date;
                          $subscription->save();
                        }
                      }
                    }
                    if ($subscription && $subscription->paypal_id) {
                        if($getPaypalSub['status'] == "CANCELLED"){
                            if($shop->all_addons == 1){
                                $this->delete_all_addon($shop, 'child',1);
                                $subscription->ends_at = $date;
                                $subscription->save();
                            }
                        }
                    }
                }
            } else{
              $ch_stores = ChildStore::where('user_id', $shop->id)->get();
              if ($subscription && $subscription->stripe_id) {
                if($getstripesub->status == "canceled"){
                  if($shop->all_addons == 1){
                    $child_store_d = ChildStore::where('user_id', $shop->id)->delete();
                    $this->delete_all_addon($shop, 'master',1);
                    $subscription->ends_at = $date;
                    $subscription->save();
                  }
                }
              }
            if ($subscription && $subscription->paypal_id) {
                if($getPaypalSub['status'] == "CANCELLED"){
                    if($shop->all_addons == 1){
                        $child_store_d = ChildStore::where('user_id', $shop->id)->delete();
                        $this->delete_all_addon($shop, 'master',1);
                        $subscription->ends_at = $date;
                        $subscription->save();
                    }
                }
            }
            }

            // subscription status
            $subscription_status = '';
            if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
//                $subscriptions = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->where('stripe_status', '<>','canceled')->orderBy('id', 'desc')->first();
                $subscriptions = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();
                if ($subscriptions) {
                    $stripe_subs = \Stripe\Subscription::retrieve($subscriptions->stripe_id);
                    if ($stripe_subs->status == 'past_due') {
                        $subscription_status = 'past_due';
                    } else if ($stripe_subs->status == 'unpaid') {
                        $subscription_status = 'unpaid';
                        $shop->license_key = null;

                        if ($shop->script_tags) {
                            deleteScriptTagCurl($shop);
                        }

                    } else if ($stripe_subs->status == 'active') {
                        $subscription_status = 'active';
                        $license_key = Hash::make(Str::random(12));
                        $shop->license_key = $license_key;
                        if ($shop->script_tags) {
                            addScriptTag($shop);
                        }
                    }
                    $shop->save();
                }
            }
            if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                $subscriptions = SubscriptionPaypal::where('user_id', $shop->id)->where('paypal_status','ACTIVE')->orderBy('id', 'desc')->first();
                if ($subscriptions) {
                    $paypalSubId = $subscriptions->paypal_id;
                    $getPaypalSub = getPaypalHttpClient()->get(getPaypalUrl("/v1/billing/subscriptions/${paypalSubId}"))->json();
                    if ($getPaypalSub['status'] == 'EXPIRED') {
                        $subscription_status = 'past_due';
                    } else if ($getPaypalSub['status'] == 'CANCELLED'|| $getPaypalSub['status'] == 'SUSPENDED') {
                        $subscription_status = 'unpaid';
                        $shop->license_key = null;

                        if ($shop->script_tags) {
                            deleteScriptTagCurl($shop);
                        }

                    } else if ($getPaypalSub['status'] == 'ACTIVE') {
                        $subscription_status = 'active';
                        $license_key = Hash::make(Str::random(12));
                        $shop->license_key = $license_key;
                        if ($shop->script_tags) {
                            addScriptTag($shop);
                        }
                    }
                    $shop->save();
                }
            }

            $trial_check = $shop->trial_check;

            // ScriptTag and ActiveCampaign adder
            if (($shop->trial_ends_at != null || $shop->trial_ends_at != '') && $shop->sub_trial_ends_at == 1) {
              $current_date = new DateTime();
              $trial_ends_at = new DateTime($shop->trial_ends_at);
              $formatted_current_date = $current_date->format('Y-m-d');
              $formatted_trial_ends_at = $trial_ends_at->format('Y-m-d');

              if ($formatted_current_date < $formatted_trial_ends_at) {
                setTrialDays($shop);

                if ($shop->script_tags) {
                  addScriptTag($shop);
                }
              } else {
                if ($shop->sub_trial_ends_at == 1) {
                  $contact = $this->activeCampaign->sync([
                    'email' => $shop->email,
                    'fieldValues' => [
                      ['field' => AC::FIELD_SUBSCRIPTION, 'value' => 'Freemium']
                    ]
                  ]);
                }
              }
            }

            $trial_days = $shop->trial_days;

            // set default trial plan
            // $trial_plan = $hustler;
            $trial_plan = $guru;

            // if trial is over
            if($trial_days == 0 || $trial_days == null){
              $trial_days = null;
              $all_addons = $shop->all_addons;
              $sub_plan = $shop->sub_plan;
              $alladdons_plan = $shop->alladdons_plan;
            }
            // else fake hustler subscription for trial
            else{
              $all_addons = 1;
              $sub_plan = 'month';
              $alladdons_plan = $trial_plan;
              $addonLimit = $hustlerLimit;
            }

            // trial check
            if($trial_check == null || $trial_check == ''){
              $trial_check = 0;
            }

            // theme check
            if($shop->theme_check == null || $shop->theme_check == ''){
              $shop->theme_check = 0;
            }

            $hustlerPriceMonthly = $guruPriceMonthly = $starterPriceMonthly = 0;
            $hustlerPriceQuarterly = $guruPriceQuarterly = $starterPriceQuarterly = 0;

            $hustleridMonthly = $guruidMonthly = $starteridMonthly = "";
            $hustleridQuarterly = $guruidQuarterly = $starteridQuarterly = "";

            // stripe plan
            $StripePlan = StripePlan:: all();
            foreach ($StripePlan as $plan) {
              if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY) {
                  $hustlerPriceMonthly = $plan->cost;
                  $hustleridMonthly = $plan->stripe_plan;
              }

              if ($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY) {
                  $guruPriceMonthly = $plan->cost;
                  $guruidMonthly = $plan->stripe_plan;
              }

              if ($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY) {
                  $starterPriceMonthly = $plan->cost;
                  $starteridMonthly = $plan->stripe_plan;
              }

              if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY) {
                  $hustlerPriceQuarterly = $plan->cost;
                  $hustleridQuarterly = $plan->stripe_plan;
              }

              if ($plan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY) {
                  $guruPriceQuarterly = $plan->cost;
                  $guruidQuarterly = $plan->stripe_plan;
              }

              if ($plan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY) {
                  $starterPriceQuarterly = $plan->cost;
                  $starteridQuarterly = $plan->stripe_plan;
              }
            }

            $this->subscription_status = $subscription_status;
            $today = Carbon::now()->format('M. d, Y');
            $courses = Course::orderBy('id', 'desc')->get();

            // dashboard progress
            $progress = 0;
            $steps_completed = 0;
            // the trial is activated by default so hardcoding it for now
            $trial_check = true;
            if(isset($trial_check) && $trial_check)
            {
              $progress += 25;
              $steps_completed += 1;
            }
            if(isset($latestupload) && $latestupload)
            {
              $progress += 25;
              $steps_completed += 1;
            }
            if(isset($already_addon_activated) && $already_addon_activated > 0)
            {
              $progress += 25;
              $steps_completed += 1;
            }
            if(isset($shop->review_given) && $shop->review_given)
            {
              $progress += 25;
              $steps_completed += 1;
            }


            $webinar_taken = $shop->webinar_taken;
            $stripe_upcoming_invoice = false;
            if(isset($shop->stripe_id) && !empty($shop->stripe_id)){
              try {
                $upcoming_invoice = \Stripe\Invoice::upcoming(["customer" => $shop->stripe_id]);
                if(isset($upcoming_invoice->discount->coupon->created) && !empty($upcoming_invoice->discount->coupon->created) && isset($upcoming_invoice->discount->coupon->id) && !empty($upcoming_invoice->discount->coupon->id)) {
                  $free_one_month = strtotime ( '+1 month' , $upcoming_invoice->discount->coupon->created );
                  $monthly_coupon = "/ONEMONTHFREECANCEl/i";
                  $monthly_invoice_check =  preg_match($monthly_coupon, $upcoming_invoice->discount->coupon->id);
                  if($free_one_month >= time() && $monthly_invoice_check == 1){
                    $stripe_upcoming_invoice = 1;
                  }
                }
              } catch (Exception $e) {
                logger('No upcoming invoice for '.$shop);
                $stripe_upcoming_invoice = false;
              }
            }

            if(!isset($paused_plan_name)) {
              $paused_plan_name = '';
              if($shop->is_paused == true){
                  $pause_plan_data = unserialize($shop->pause_subscription);
                  if(isset($pause_plan_data['plan_name']) && !empty($pause_plan_data['plan_name'])){
                    $paused_plan_name = $pause_plan_data['plan_name'];
                  }
              }
            }
           if (!empty($shop->stripe_id)) {
              $stripe_customer = \Stripe\Customer::retrieve($shop->stripe_id);
              $card_data = $stripe_customer->sources->data[0]->card;

              // if json return of $card_data is empty
              if($card_data){} else{
                $card_data = $stripe_customer->sources->data[0];
              }

              $card_number = $card_data->last4;
            }


            // if beta user get old plan name
            $user_plan = User::where('id', $shop->id)->select('old_plan_meta')->get();
                  $old_plan_name = "";
                  if(isset($user_plan[0]->old_plan_meta)){
                      $old_plan = json_decode($user_plan[0]->old_plan_meta);
                      if(isset($old_plan->plan_name)){
                        $old_plan_name = $old_plan->plan_name;
                      }
                    }

            // get extend trial days , step and complete all
            $extend_trial_requests = UserExtendTrialRequest::where('extend_trial_status','approved')->where('user_id',$shop->id)->count();
            $all_extend_feature = ExtendTrial::count();
            $trial_extend_step = $extend_trial_requests.'/'.$all_extend_feature;
            $extend_all_step = "";
            if ($extend_trial_requests == $all_extend_feature) {
                    if( ($trial_days && !$master_shop && !$shop->is_beta_tester) || ($alladdons_plan == $freemium || $alladdons_plan == "") && !$shop->is_paused ){
                            $extend_all_step = 1;
                            $progress += 25;
                            $steps_completed += 1;
                      }
            }



            $routesArray = [
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
                'affiliate'
            ];
            View::share([
              'owner_details' => $owner_details,
              'fname' => $owner_details['fname'],
              'name' => $owner_details['lname'],
              'email' => $owner_details['email'],
              'customer_email_sha1' => sha1($owner_details['email']),
              'version' => $latest_theme->version,
              'customer_email_sha1' => sha1($owner_details['email']),
              'freemium' => $freemium,
              'starter' => $starter,
              'hustler' => $hustler,
              'guru' => $guru,
              'starterLimit' => $starterLimit,
              'hustlerLimit' => $hustlerLimit,
              'guruLimit' => $guruLimit,
              'all_addons'=> $all_addons,
              'trial_end_date'=> $trial_days,
              'show_end_at' => $show_end_at,
              'alladdons_plan'=> $alladdons_plan,
              'trial_plan'=> $trial_plan,
              'shop_domain' => $shop->name,
              'sub_plan' => $sub_plan,
              'billingDate' => $billingDate,
              'theme_count'=>$theme_count,
              'addons_count'=>$addons_count,
              'addonLimit' => $addonLimit,
              'global_add_ons' => $global_add_ons,
              'active_add_ons' => $already_addon_activated,
              'latestupload'=>$latestupload,
              'store_themes' => $StoreThemes,
              'master_shop' => $master_shop,
              'child_stores' => $ch_stores,
              'subscription_status' => $subscription_status,
              'today' => $today,
              'user_id' => $user_id,
              'trial_end_at' => $shop->trial_ends_at,
              'trial_days' => $trial_days,
              'theme_check' => $shop->theme_check,
              'trial_check' => $trial_check,
              'starterPriceMonthly' => $starterPriceMonthly,
              'starteridMonthly' => $starteridMonthly,
              'guruPriceMonthly' => $guruPriceMonthly,
              'guruidMonthly' => $guruidMonthly,
              'hustlerPriceMonthly' => $hustlerPriceMonthly,
              'hustleridMonthly' => $hustleridMonthly,
              'starterPriceQuarterly' => $starterPriceQuarterly,
              'starteridQuarterly' => $starteridQuarterly,
              'guruPriceQuarterly' => $guruPriceQuarterly,
              'guruidQuarterly' => $guruidQuarterly,
              'hustlerPriceQuarterly' => $hustlerPriceQuarterly,
              'hustleridQuarterly' => $hustleridQuarterly,
              'mentoringWinnercount' => $mentoringWinnercount,
              'review_given' => $shop->review_given,
              'webinar_taken' => $shop->webinar_taken,
              'courses' => $courses,
              'dashboard_add_ons' => $dashboard_add_ons,
              'progress' => $progress,
              'steps_completed' => $steps_completed,
              'shopify_shop_data' => $shopData,
              'script_tags_url' => scriptTagPermissionRedirectURL($shop),
              'script_tags' => $shop->script_tags,
              'is_paused' => $shop->is_paused,
              'has_taken_free_subscription' => $shop->has_taken_free_subscription,
              'stripe_upcoming_invoice' => $stripe_upcoming_invoice,
              'db_plan_name' => $shop->alladdons_plan,
              'is_beta_user' => $shop->is_beta_tester,
              'prior_beta_theme' => $prior_beta_theme,
              'routes' => $routesArray,
              'paused_plan_name' => $paused_plan_name,
              'card_number' => $card_number,
              'old_plan_name' => $old_plan_name,
              'new_update_theme' => $new_update_theme,
              'extend_trial' => $shop->extend_trial,
              'trial_extend_step_progress' =>$trial_extend_step,
              'extend_all_step' => $extend_all_step,
              'addon_infos'=>$addon_infos,
              'addon_infos_count'=>$addon_infos_count,
            ]);
        }
    }

    // app index view
    public function index(Request $request){
        $shop = Auth::user();

        $this->fetchInitialData();

        $latest_theme = Themes::orderBy('id', 'desc')->first();
        $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        $shopify_themes = array();
        $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->count();

        $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
        )['body']['shop'];
        $shop->email = $shopData['email'];
        $shop->save();

        $mentoringWinners = MentoringCall::orderBy('id', 'desc')->get();

        // winning products
        $products = [];
        $alladdons_plan = $this->getAddonsPlan($shop);

        if($alladdons_plan == 'Master' || $shop->is_beta_tester == true){
          $products = WinningProduct::where('saturationlevel', 'gold')->orderBy('id', 'desc')->paginate(3);
        }elseif ($alladdons_plan == 'Hustler') {
          $products = WinningProduct::where('saturationlevel', 'silver')->orderBy('id', 'desc')->paginate(3);
        }else{
          $products = WinningProduct::where('saturationlevel', 'bronze')->orderBy('id', 'desc')->paginate(3);
        }

      // print_r(DB::getQueryLog());

        $productCount = WinningProduct::count();
        $productss = [];

        if(is_array($products) && count($products)) {
            foreach ($products as $key => $product) {
              $date = new DateTime();
              $new_formats = $date->format('Y-m-d');
              $new_format = $product->created_at->format('Y-m-d');
              $diff = strtotime($new_formats) - strtotime($new_format);
              $days = abs(round($diff / 86400));
              $product->days = $days;

              if($days <= 7){
                $product->new_product = true;
              }else{
                $product->new_product = false;
              }

              if($product->opinion){
                $formattedOpinion = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->opinion);
                $formattedOpinion2 = str_replace('"', "'", $formattedOpinion);
                $product->opinion = $formattedOpinion2;
              }

              if($product->description){
                $formattedDescription = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->description);
                $formattedDescription2 = str_replace('"', "'", $formattedDescription);
                $product->description = $formattedDescription2;
              }

              $productss[] = $product;
            }
        }

        // latest 3 cources
        $courses = Course::orderBy('id', 'desc')->paginate(3);
        $update_popup = Updates::orderBy('id', 'desc')->first();
        if($update_popup != null){
            $update_popup->video = $this->generateVideoEmbedUrl($update_popup->video);
        }else{
            $update_popup = false;
        }

        return view('welcome', [
          'mentoringWinners' => $mentoringWinners,
          'products' => $productss,
          'courses' => $courses,
          'updates' => $update_popup,
          'is_update_addons' => $this->isUpdatePending($shop),
        ]);
    }

    public function isUpdatePending($shop){
        $is_update_addons = false;
        if( $shop->is_updated_addon == 0 ){
            $accessScopeData = $shop->api()->request(
                'GET',
                '/admin/oauth/access_scopes.json',
                []
            )['body']['access_scopes'];
            $accessScopeData = (@$accessScopeData->container) ? $accessScopeData->container : false;
            if( $accessScopeData ){
                if( is_array( $accessScopeData ) ){
                    foreach ( $accessScopeData as $key=>$val ){
                        $scopes[] = $val['handle'];
                    }
                    if (in_array("read_script_tags", $scopes) && in_array("write_script_tags", $scopes)){
                        $cnt_addons = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
                        if( $cnt_addons > 0 ){
                            $is_update_addons = true;
                        }else{
                            $shop->is_updated_addon = 1;
                            $shop->save();
                        }
                    }
                }
            }
        }
        return $is_update_addons;
    }
    public function redirect_review(Request $request){
      $shop = Auth::user();
      $msg = '';
      $shop->review_given = 1;
      if($shop->save()){
          $msg = "Review given successfully.";
      }
      return response()->json(array('msg'=> $msg), 200);
    }

    public function webinar_registration(Request $request){
      $shop = Auth::user();
      $shopData = $shop->api()->request(
        'GET',
        '/admin/api/shop.json',
        []
      )['body']['shop'];
      $full_name = explode(" ", $shopData['name']);
      $first_name = $full_name[0] ?? '';
      $last_name = $full_name[1] ?? '';
      $email = $shopData['email'];
      $phone = $shopData['phone'];
      $country_code = $shopData['country_code'];
      $timezone = $shopData['timezone'];

      $phone_country_code = '';
      $codes = config('country_codes.countries');
      if (!empty($codes)){
        foreach ($codes as $key => $value) {
          if($key == $country_code){
            $phone_country_code = $value['code'];
          }
        }
      }

      $url = 'https://event.webinarjam.com/register/1click/2/n67znt5?first_name='.$first_name.'&last_name='.$last_name.'&email='.$email.'&phone_country_code=%2B'.$phone_country_code.'&phone_number='.$phone.'&timezone='.$timezone.'&schedule_id=1';

      $shop->webinar_taken = 1;
      $shop->save();

      return Redirect::away($url);
    }

    public function partners(StripePlan $plan, Request $request)
    {
      $this->fetchInitialData();
      $partners = Partner::orderBy('id', 'desc')->get();

      return view('partners', [
        'partners' => $partners
      ]);
    }

    // onboarding view
    public function onboarding(){
        $this->fetchInitialData();
        return redirect()->route('theme_view');
    }

    // support view
    public function support(StripePlan $plan, Request $request){
        $this->fetchInitialData();

        return view('support', [
          'plan' => $plan,
        ]);
    }

    // technical support view
    public function technicalSupport(StripePlan $plan, Request $request){
        $this->fetchInitialData();

        return view('technical-support', [
          'plan' => $plan,
        ]);
    }

    // changelog view
    public function changeLog(StripePlan $plan, Request $request){
        $this->fetchInitialData();
        $updatePopup = Updates::orderBy('id', 'desc')->first();
        if($updatePopup != null){
            $updatePopup->video = $this->generateVideoEmbedUrl($updatePopup->video);
        }else{
            $updatePopup = false;
        }
        return view('changelog', [
          'updates' => $updatePopup
        ]);
    }

    // integrations view
    public function integrations(StripePlan $plan, Request $request){
        $this->fetchInitialData();
        if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }
        return view('integrations', [
          'plan' => $plan,
        ]);
    }

    // affiliate view
    public function affiliate(StripePlan $plan, Request $request){
        $this->fetchInitialData();

        return view('affiliate', [
          'plan' => $plan,
        ]);
    }

    // courses view
    public function courses(StripePlan $plan, Request $request){
      $this->fetchInitialData();

      if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }

      $courses = Course::orderBy('id', 'desc')->paginate(24);
      // print_r($courses);
      return view('courses', [
        'plan' => $plan,
        'courses' => $courses
      ]);
    }

    public function viewCourse(StripePlan $plan, Request $request,$id){
      $this->fetchInitialData();

      if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }

      $course = Course::where('courses.id',$id)->with(['modules.steps' => function ($query) { $query->orderBy('position', 'asc');}])->first();
      $course->sub_plans = explode(",", $course->plans);
      $course = json_decode($course);
      // echo "<pre>";
      // print_r($course);
      // echo "</pre>";

      return view('view-course', [
        'plan' => $plan,
        'course' => $course
      ]);
    }

    // mentoring view
    public function mentoring(StripePlan $plan, Request $request){
      $this->fetchInitialData();
      $mentoringWinners = MentoringCall::orderBy('id', 'desc')->get();
      if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }
      return view('mentoring', [
        'plan' => $plan,
        'mentoringWinners' => $mentoringWinners
      ]);
    }

    function getAddonsPlan($shop){
      // duplicated data for trial
      $trial_days = $shop->trial_days;
      $trial_plan = 'Master';
      if($trial_days == 0 || $trial_days == null || $shop->all_addons == 1){
        $alladdons_plan = $shop->alladdons_plan;
      }else{
        $alladdons_plan = $trial_plan;
      }
      return $alladdons_plan;
    }

    // winning products view bob
    public function winning_products(StripePlan $plan, Request $request){

      $shop = Auth::user();
      $this->fetchInitialData();

      if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }

      $products = [];
      // DB::enableQueryLog();
      $hiddenProducts = '';

      $alladdons_plan = $this->getAddonsPlan($shop);

      if($shop->master_account != 1){
        $ch_stores =[];
        $child_store = ChildStore::where('store', $shop->name)->first();
        if($child_store){
          // Cancle Subscription
          $master_shop = User::where('id', $child_store->user_id)->first();

          if(isset($master_shop->old_plan_meta)) {
            $old_plan = json_decode($master_shop->old_plan_meta);
            if(isset($old_plan->plan_name) && $old_plan->plan_name == 'Master') {
              $alladdons_plan = $old_plan->plan_name;
            }
          }
        }
      }

      // set product limitation per plan
      if($alladdons_plan == 'Master' || $shop->is_beta_tester == true){
        $products = WinningProduct::where('saturationlevel', 'gold')->orderBy('id', 'desc')->paginate(24);
      }elseif ($alladdons_plan == 'Hustler') {
        $products = WinningProduct::where('saturationlevel', 'silver')->orderBy('id', 'desc')->paginate(24);
        $hiddenProducts = WinningProduct::where('saturationlevel', 'silver')->orderBy('id', 'desc')->count();
      }elseif ($alladdons_plan == 'Starter') {
        $products = WinningProduct::where('saturationlevel', 'bronze')->orderBy('id', 'desc')->paginate(24);
        $hiddenProducts = WinningProduct::where('saturationlevel', 'bronze')->orderBy('id', 'desc')->count();
      }

      // print_r(DB::getQueryLog());

      $productCount = WinningProduct::count();
      $productss = [];

      if(is_array($products) && count($products)) {
          foreach ($products as $key => $product) {
            $date = new DateTime();
            $new_formats = $date->format('Y-m-d');
            $new_format = $product->created_at->format('Y-m-d');
            $diff = strtotime($new_formats) - strtotime($new_format);
            $days = abs(round($diff / 86400));
            $product->days = $days;

            if($days <= 7){
              $product->new_product = true;
            }else{
              $product->new_product = false;
            }

            if($product->opinion){
              $formattedOpinion = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->opinion);
              $formattedOpinion2 = str_replace('"', "'", $formattedOpinion);
              $product->opinion = $formattedOpinion2;
            }

            if($product->description){
              $formattedDescription = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->description);
              $formattedDescription2 = str_replace('"', "'", $formattedDescription);
              $product->description = $formattedDescription2;
            }

            $productss[] = $product;
          }
      }

      return view('winning-products', [
        'plan' => $plan,
        'products' => $productss,
        'productCount' => $productCount,
        'productspagination'=> $products,
        'hiddenProducts' => $hiddenProducts
      ]);
    }

    public function paginateWinningProducts(StripePlan $plan, Request $request){
      $shop = Auth::user();
      $this->fetchInitialData();
      if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }
      $products = [];
      // DB::enableQueryLog();
      $hiddenProducts = '';

      $alladdons_plan = $this->getAddonsPlan($shop);

      if($shop->master_account != 1){
        $ch_stores =[];
        $child_store = ChildStore::where('store', $shop->name)->first();
        if($child_store){
          // Cancle Subscription
          $master_shop = User::where('id', $child_store->user_id)->first();

          if(isset($master_shop->old_plan_meta)) {
            $old_plan = json_decode($master_shop->old_plan_meta);
            if(isset($old_plan->plan_name) && $old_plan->plan_name == 'Master') {
              $alladdons_plan = $old_plan->plan_name;
            }
          }
        }
      }

      // set product limitation per plan
      if($alladdons_plan == 'Master' || $shop->is_beta_tester == true){
        $products = WinningProduct::where('saturationlevel', 'gold')->orderBy('id', 'desc')->paginate(24);
      }elseif ($alladdons_plan == 'Hustler') {
        $products = WinningProduct::where('saturationlevel', 'silver')->orderBy('id', 'desc')->paginate(24);
        $hiddenProducts = WinningProduct::where('saturationlevel', 'silver')->orderBy('id', 'desc')->count();
      }elseif ($alladdons_plan == 'Starter') {
        $products = WinningProduct::where('saturationlevel', 'bronze')->orderBy('id', 'desc')->paginate(24);
        $hiddenProducts = WinningProduct::where('saturationlevel', 'bronze')->orderBy('id', 'desc')->count();
      }

      // print_r(DB::getQueryLog());

      $productCount = WinningProduct::count();
      $productss = [];

      if(is_array($products) && count($products)) {
          foreach ($products as $key => $product) {
            $date = new DateTime();
            $new_formats = $date->format('Y-m-d');
            $new_format = $product->created_at->format('Y-m-d');
            $diff = strtotime($new_formats) - strtotime($new_format);
            $days = abs(round($diff / 86400));
            $product->days = $days;

            if($days <= 7){
              $product->new_product = true;
            }else{
              $product->new_product = false;
            }

            if($product->opinion){
              $formattedOpinion = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->opinion);
              $formattedOpinion2 = str_replace('"', "'", $formattedOpinion);
              $product->opinion = $formattedOpinion2;
            }

            if($product->description){
              $formattedDescription = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->description);
              $formattedDescription2 = str_replace('"', "'", $formattedDescription);
              $product->description = $formattedDescription2;
            }

            $productss[] = $product;
          }
      }

      $html = View::make('searched-winning-products',['plan' => $plan, 'products' => $productss, 'productspagination'=> $products]);

      $response = $html->render();
      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    public function filterWinningProducts(StripePlan $plan, Request $request){
      $shop = Auth::user();
      $this->fetchInitialData();
      if($this->subscription_status =='unpaid'){
        return redirect()->route('billing');
      }

      //DB::enableQueryLog();
      $q = WinningProduct::query();
      if($request->query('saturation') != ''){
        $q->where('saturationlevel', 'like', '%' . $request->query('saturation') . '%');
      }

      if($request->query('q') != ''){
        $q->where(function ($query) use ($request) {
          $query->where('name', 'like', '%' . $request->query('q') . '%')
            ->orWhere('aliexpresslink', 'like', '%' . $request->query('q') . '%')
            ->orWhere('price', 'like', '%' . $request->query('q') . '%');
        });
      }

      if($request->query('category') != ''){
        $q->where('category', 'like', '%' . $request->query('category') . '%');
      }

      if($request->query('profit') != ''){
        $profit = explode('-', $request->query('profit'));
        if(count($profit) >= 2){
          $min = $profit[0]; $max = $profit[1];
          $q->whereBetween('profit', [(int)$min, (int)$max]);
        }else{
          $q->where('profit', '>=', (int)$request->query('profit'));
        }
      }

      $products = [];

      $alladdons_plan = $this->getAddonsPlan($shop);

      if($shop->master_account != 1){
        $ch_stores =[];
        $child_store = ChildStore::where('store', $shop->name)->first();
        if($child_store){
          // Cancle Subscription
          $master_shop = User::where('id', $child_store->user_id)->first();

          if(isset($master_shop->old_plan_meta)) {
            $old_plan = json_decode($master_shop->old_plan_meta);
            if(isset($old_plan->plan_name) && $old_plan->plan_name == 'Master') {
              $alladdons_plan = $old_plan->plan_name;
            }
          }
        }
      }

      // set product limitation per plan
      if($alladdons_plan == 'Master' || $shop->is_beta_tester == true){
        $products = $q->orderBy('id', 'desc')->paginate(24);
      }elseif ($alladdons_plan == 'Hustler') {
        $q->where(function ($query) {
          $query->where('saturationlevel', 'bronze')->orWhere('saturationlevel', 'silver');
        });
        $products = $q->orderBy('id', 'desc')->paginate(24);
        $hiddenProducts = $q->orderBy('id', 'desc')->count();
      }elseif ($alladdons_plan == 'Starter') {
        $products = $q->where('saturationlevel', 'bronze')->orderBy('id', 'desc')->paginate(24);
        $hiddenProducts = $q->where('saturationlevel', 'bronze')->orderBy('id', 'desc')->count();
      }

      // print_r(DB::getQueryLog());

      $productss = [];
      if(is_array($products) && count($products)) {
          foreach ($products as $key => $product) {
            $date = new DateTime();
            $new_formats = $date->format('Y-m-d');
            $new_format = $product->created_at->format('Y-m-d');
            $diff = strtotime($new_formats) - strtotime($new_format);
            $days = abs(round($diff / 86400));
            $product->days = $days;

            if($days <=7){
              $product->new_product = true;
            }else{
              $product->new_product = false;
            }

            if($product->opinion){
              $formattedOpinion = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->opinion);
              $formattedOpinion2 = str_replace('"', "'", $formattedOpinion);
              $product->opinion = $formattedOpinion2;
            }

            if($product->description){
              $formattedDescription = str_replace(["\r\n", "\r", "\n"], "<br/>", $product->description);
              $formattedDescription2 = str_replace('"', "'", $formattedDescription);
              $product->description = $formattedDescription2;
            }

            $productss[] = $product;
          }
      }

      $html = View::make('searched-winning-products',['plan' => $plan, 'products' => $productss, 'productspagination'=> $products]);

      $response = $html->render();
      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    // feedback view
    public function feedback(StripePlan $plan, Request $request){
      //logger('feedback');
      $this->fetchInitialData();

      $ssoToken = self::createUpvotyToken();
      return view('feedback', [
        'plan' => $plan,
        'ssoToken' => $ssoToken,
      ]);
    }

    function createUpvotyToken() {
        $shop = Auth::user();
        $owner_detail = json_decode($shop->shopify_raw);
        $owner_name = $owner_detail->shop_owner;
        if(!isset($owner_detail->shop_owner) || empty($owner_detail->shop_owner)){
            $owner_name = $owner_detail->shop_owner;
        }

        $privateKey = \Config::get('upvoty.upvoty_private_key');
        $userData = [
            'id' => $shop->id, // Required
            'name' => $owner_name,  // Required
            'email' => $shop->email,  // Optional but preferred
        ];
        return  JWT::encode($userData, $privateKey, 'HS256');
    }

    // theme view
    public function theme_view(StripePlan $plan, Request $request){
        $shop = Auth::user();

        $this->fetchInitialData();

         if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
                $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->count();
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
            }else{
                $latest_theme = Themes::where('is_beta_theme', '!=', 1)->orderBy('id', 'desc')->first();
                $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
          }
           if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }
            if(!isset($StoreThemes) || empty($StoreThemes)){
                  $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();

            }
            if(!isset($theme_count) || empty($theme_count)){
                    $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->count();
            }
        // $latest_theme = Themes::orderBy('id', 'desc')->first();
        $user_id = $shop->id;

        if($theme_count > 0){
            $theme_current_version = Themes::where('id', $shop->theme_id)->get();
            if($shop->theme_id != null && $shop->shopify_theme_id != null){
                if ($latest_theme->id > $shop->theme_id) {
                    $theme_url = $latest_theme->url;
                    $request->session()->flash('new_version', $theme_url);
                }
            }
        }

        // from old onboarding view
        $shopify_themes = array();
        foreach ($StoreThemes as $theme) {
            $shopify_themes[] = array('label'=>$theme->shopify_theme_name, 'href'=>'/admin/themes/'.$theme->shopify_theme_id.'/editor', 'target'=>'new');
        }

        if($this->subscription_status =='unpaid'){
          return redirect()->route('plans');
        }

        return view('theme_view', [
          'plan' => $plan,
          'shopify_themes' => json_encode($shopify_themes, true),
            'is_update_addons' => $this->isUpdatePending($shop)
        ]);
    }

    public function checkout(StripePlan $plan, Request $request){
        $shop = Auth::user();
        // Redirect old param to new billing param
        if (
            $request->has('monthly') && $request->input('monthly') == null ||
            $request->has('quarterly') && $request->input('quarterly') == null ||
            $request->has('yearly') && $request->input('yearly') == null
          ) {
          return redirect()->route('checkout', array_merge(
            [
              'plan' => lcfirst($plan->plan_name),
              'billing' => array_keys($request->only(['monthly', 'quarterly', 'yearly']))[0]
            ],
            $request->except(['monthly', 'quarterly', 'yearly'])
          ));
        }

        $this->fetchInitialData();
        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
                $theme_count = StoreThemes::where('user_id', $shop->id)->count();

        }else{
            $latest_theme = Themes::where('is_beta_theme', '!=', 1)->orWhere('is_beta_theme', NULL)->orderBy('id', 'desc')->first();
            $theme_count = StoreThemes::where('user_id', $shop->id)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();
        }

          if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
          }

          if(!isset($theme_count) || empty($theme_count)){
                  $theme_count = StoreThemes::where('user_id', $shop->id)->count();
          }

        $free_addons = FreeAddon::where('shopify_domain', $shop->name)->where('status',1)->first();
        // $theme_count = StoreThemes::where('user_id', $shop->id)->count();
        $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        $exit_code = '50OFF3MONTHS';
        $new_code = 'PLAN10';
        $coupon_name = '';
        $percent_off = '';
        $coupon_duration = '';
        $coupon_duration_months = '';
        $previous_plan = '';
        $discount = '';
        $next_invoice_total = '';
        $next_payment_attempt = '';
        $card_expire = '';
        $card_number = '';
        $card_brand ='';
        $card_data = '';
        $current_plan = '';
        $current_cost = '';

        $mainSubscription = $shop->mainSubscription;

        if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE && $mainSubscription->stripe_customer_id != null) {
           $stripe_customer = \Stripe\Customer::retrieve($mainSubscription->stripe_customer_id);

            // dd($stripe_customer);
            // get customer card details
            $card_data = $stripe_customer->sources->data[0]->card;

            // if json return of $card_data is empty
            if($card_data){} else{
                $card_data = $stripe_customer->sources->data[0];
            }

            $card_expire_m = $card_data->exp_month;
            $card_expire_y = $card_data->exp_year;
            if($card_expire_m < 10){
                $card_expire_m = '0'.$card_expire_m;
            }
            $card_expire = $card_expire_m.'/'.$card_expire_y;
            $card_number = $card_data->last4;
            $card_brand = $card_data->brand;
        }


        // subcription active
        if($shop->all_addons == 1){

            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {

                $subscriptions = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();

                if ($subscriptions) {
                    try {
                        $stripe_subs = \Stripe\Subscription::retrieve($subscriptions->stripe_id);
                        if (!$stripe_subs->cancel_at_period_end) {
                            $stripe_upcoming_invoice = \Stripe\Invoice::upcoming(["subscription" => $stripe_subs]);
                            $current_plan = $stripe_subs->plan;
                            $discount = $stripe_subs->discount;
                            // $next_invoice_total_1 = $stripe_upcoming_invoice->total/100;
                            $next_invoice_total_1 = $stripe_upcoming_invoice->amount_due / 100;
                            $next_invoice_total = number_format($next_invoice_total_1, 2);
                  $next_payment_attempt = Carbon::createFromTimestamp($stripe_upcoming_invoice->next_payment_attempt)->format("F d, Y");

                            // get subscription discount
                            if ($discount) {
                                $coupon_name = $discount->coupon->name;
                                $coupon_duration = $discount->coupon->duration;
                                $coupon_duration_months = $discount->coupon->duration_in_months;

                                if ($discount->coupon->percent_off) {
                                    $percent_off = $discount->coupon->percent_off . '% off';
                                } else {
                                    $percent_off_1 = $discount->coupon->amount_off / 100;
                                    $percent_off_2 = number_format($percent_off_1, 2);
                                    $percent_off = 'US$' . $percent_off_2 . ' off';
                                }
                            }

                            // get old pricing for current users
                            if ($current_plan) {
                                $current_cost = $current_plan->amount / 100;
                                if ($current_cost == '10' || $current_cost == '84' || $current_cost == '27' || $current_cost == '197' || $current_cost == '15' || $current_cost == '90') {
                                    $previous_plan = $current_cost;
                                }
                            }

                        }
                    } catch (Exception $e) {
                        $e->getMessage();
                    }
                }
            }
            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                $annualMonthPlans = [];
                if(strpos($plan->name,"Annually"))
                {
                    $annualMonthPlans['annually'] = $plan->paypal_plan;
                    $mPlanExploded = explode("Annually",$plan->name)[0];
                    $mPlan = $mPlanExploded."Monthly";
                    $qPlan = $mPlanExploded."Quarterly";
                    $current_plan = StripePlan::where('name',$mPlan)->first('paypal_plan');
                    $annualMonthPlans['monthly'] = $current_plan->paypal_plan;
                    $annualMonthPlans['quarterly'] = StripePlan::where('name', $qPlan)->first('paypal_plan')->paypal_plan;
                }else{
                    $annualMonthPlans['monthly'] = $plan->paypal_plan;
                    $mPlanExploded = explode("Monthly",$plan->name)[0];
                    $mPlan = $mPlanExploded."Annually";
                    $qPlan = $mPlanExploded."Quarterly";
                    $current_plan = StripePlan::where('name',$mPlan)->first('paypal_plan');
                    $annualMonthPlans['annually'] = $current_plan->paypal_plan;
                    $annualMonthPlans['quarterly'] = StripePlan::where('name', $qPlan)->first('paypal_plan')->paypal_plan;
                }
                $current_plan = json_encode($annualMonthPlans);
//                $subscriptions = SubscriptionPaypal::where('user_id', $shop->id)
//                    ->where('paypal_status','ACTIVE')
//                    ->orWhere('paypal_status','SUSPENDED')
//                    ->orderBy('id','desc')->first();
                $subscriptions_temp = SubscriptionPaypal::where('user_id',$shop->id)->get();
                $activeOrSuspendedSubscription = $subscriptions_temp->filter(function($sub){
                    return $sub->paypal_status == 'ACTIVE' || $sub->paypal_status == 'SUSPENDED';
                });
                $subscriptions = $activeOrSuspendedSubscription->sortKeysDesc()->first();
                if ($subscriptions) {
                    try {
                        $sub_id = $subscriptions->paypal_id;
                        $paypal_subs = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}"))->json();
                        // $next_invoice_total_1 = $stripe_upcoming_invoice->total/100;
                        $next_invoice_total_1 = $paypal_subs['billing_info']['last_payment']['amount']['value'];
                        $next_invoice_total = number_format($next_invoice_total_1, 2);
                        $currentPaymentDate = Carbon::parse($paypal_subs['billing_info']['last_payment']['time']);
                        $paypalPlan = explode('Price',$subscriptions->name);

                        if(strtolower($paypalPlan[1])=='monthly'){
                            $next_payment_attempt = $currentPaymentDate->copy()->addMonth();
                        }
                        if(strtolower($paypalPlan[1])=='quarterly'){
                            $next_payment_attempt = $currentPaymentDate->copy()->addMonths(3);
                        }
                        if(strtolower($paypalPlan[1])=='annually'){
                            $next_payment_attempt = $currentPaymentDate->copy()->addYear();
                        }
                        $next_payment_attempt = optional($next_payment_attempt)->format("F d, Y");
                        //Currently coupons are not supported by Paypal in current flow.
                    }catch (Exception $e){
                        $e->getMessage();
                    }
                }
            }
        }
        $StripePlans = StripePlan:: all();
        if($free_addons){
            $free_addons = $free_addons->status;
        }
        if($theme_count > 0){
            $theme_current_version = Themes::where('id', $shop->theme_id)->get();
            if($shop->theme_id != null && $shop->shopify_theme_id != null){
                if ($latest_theme->id > $shop->theme_id) {
                    $theme_url = $latest_theme->url;
                    $request->session()->flash('new_version', $theme_url);
                }
            }
        }

        $starterPriceAnnually = $starterPriceQuarterly = $starterPriceMonthly = 0;
        $hustlerPriceAnnually = $hustlerPriceQuarterly = $hustlerPriceMonthly = 0;
        $guruPriceAnnually = $guruPriceQuarterly = $guruPriceMonthly = 0;

        $starteridAnnually = $starteridQuarterly = $starteridMonthly = "";
        $hustleridAnnually = $hustleridQuarterly = $hustleridMonthly = "";
        $guruidAnnually = $guruidQuarterly = $guruidMonthly = "";

        // get active plan price and ID
        foreach ($StripePlans as $StripePlan) {
            if($StripePlan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY){
                $starterPriceAnnually = $StripePlan->cost;
                $starteridAnnually = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY){
              $starterPriceQuarterly = $StripePlan->cost;
              $starteridQuarterly = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY){
                $starterPriceMonthly = $StripePlan->cost;
                $starteridMonthly = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY){
                $hustlerPriceAnnually = $StripePlan->cost;
                $hustleridAnnually = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY){
                $hustlerPriceQuarterly = $StripePlan->cost;
                $hustleridQuarterly = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY){
                $hustlerPriceMonthly = $StripePlan->cost;
                $hustleridMonthly = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY){
                $guruPriceAnnually = $StripePlan->cost;
                $guruidAnnually = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY){
              $guruPriceQuarterly = $StripePlan->cost;
              $guruidQuarterly = $StripePlan->stripe_plan;
            }

            if($StripePlan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY){
                $guruPriceMonthly = $StripePlan->cost;
                $guruidMonthly = $StripePlan->stripe_plan;
            }
        }

        // child store count
        $store_count = ChildStore::where('user_id', $shop->id)->count();
        $store_limit = '2';

        // taxes
        $applyTaxes = false;
        $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
        )['body']['shop'];

        if($shopData['country_name'] == 'Canada'){
            $applyTaxes = true;
        }

        if($shop->all_addons == 1){
            // subcription active
            if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                $subscriptions = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();
                if ($subscriptions) {
                    $stripe_subs = \Stripe\Subscription::retrieve($subscriptions->stripe_id);
                    if (!$stripe_subs->cancel_at_period_end) {
                        $upcoming_invoice = \Stripe\Invoice::upcoming(["subscription" => $stripe_subs]);
                    }
                }
            }
        }

            $main_plan = strtolower($request->segments()[2]);

            if($main_plan == 'starter'){
                $c_plan = StripePlan::whereIn('name',[SubscriptionPlans::STARTER_PRICE_MONTHLY, SubscriptionPlans::STARTER_PRICE_QUARTERLY, SubscriptionPlans::STARTER_PRICE_ANNUALLY])->get();
            }
            if($main_plan == 'hustler'){
                $c_plan = StripePlan::whereIn('name',[SubscriptionPlans::HUSTLER_PRICE_MONTHLY, SubscriptionPlans::HUSTLER_PRICE_QUARTERLY, SubscriptionPlans::HUSTLER_PRICE_ANNUALLY])->get();
            }
            if($main_plan == 'master'){
                $c_plan = StripePlan::whereIn('name',[SubscriptionPlans::MASTER_PRICE_MONTHLY, SubscriptionPlans::MASTER_PRICE_QUARTERLY, SubscriptionPlans::MASTER_PRICE_ANNUALLY])->get();
            }

            $temp_array['monthly'] = $c_plan[0]['paypal_plan'] ?? "";
            $temp_array['annually'] = $c_plan[1]['paypal_plan'] ?? "";
            $temp_array['quarterly'] = $c_plan[2]['paypal_plan'] ?? "";
            $paypal_plan = json_encode($temp_array);

        // $tax_id = getTaxId($shopData->province);
        $pause_plan_data = "";
        if(isset($shop->pause_subscription) && !empty($shop->pause_subscription)){
          $pause_plan_data = unserialize($shop->pause_subscription);
        }


        return response()->view('checkout', [
            'starterPriceAnnually' => $starterPriceAnnually,
            'starterPriceQuarterly' => $starterPriceQuarterly,
            'starterPriceMonthly' => $starterPriceMonthly,
            'hustlerPriceAnnually' => $hustlerPriceAnnually,
            'hustlerPriceQuarterly' => $hustlerPriceQuarterly,
            'hustlerPriceMonthly' => $hustlerPriceMonthly,
            'guruPriceAnnually' => $guruPriceAnnually,
            'guruPriceQuarterly' => $guruPriceQuarterly,
            'guruPriceMonthly' => $guruPriceMonthly,
            'starteridAnnually' => $starteridAnnually,
            'starteridQuarterly' => $starteridQuarterly,
            'starteridMonthly' => $starteridMonthly,
            'hustleridAnnually' => $hustleridAnnually,
            'hustleridQuarterly' => $hustleridQuarterly,
            'hustleridMonthly' => $hustleridMonthly,
            'guruidAnnually' => $guruidAnnually,
            'guruidQuarterly' => $guruidQuarterly,
            'guruidMonthly' => $guruidMonthly,
            'plan' => $plan,
            'plan_name' => $plan->plan_name,
            'free_addons'=> $free_addons,
            'store_count' => $store_count,
            'store_limit' => $store_limit,
            'exit_code' => $exit_code,
            'new_code' => $new_code,
            'coupon_name' => $coupon_name,
            'percent_off' =>$percent_off,
            'coupon_duration' =>$coupon_duration,
            'coupon_duration_months' =>$coupon_duration_months,
            'discount' => $discount,
            'previous_plan' => $previous_plan,
            'next_invoice_total' => $next_invoice_total,
            'next_payment_attempt' => $next_payment_attempt,
            'card_expire' => $card_expire,
            'card_number' => $card_number,
            'card_brand' => $card_brand,
            'card_data' => $card_data,
            'all_addons' => $shop->all_addons,
            'alladdons_plan'=> $shop->alladdons_plan,
            'sub_plan' => $shop->sub_plan,
            'current_plan' => $current_plan,
            'paypal_plan' => $paypal_plan,
            'current_cost' => $current_cost,
            'applyTaxes' => $applyTaxes,
            'customer_id' => $shop->id,
            'customer_email_sha1' => sha1($shop->email),
            'pause_plan_data' => $pause_plan_data,
            'is_paused' => $shop->is_paused
        ])->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    public function settings(Request $request)
    {
        $shop = Auth::user();
        $this->fetchInitialData();

        $card_expire = '';
        $card_number = '';
        $card_brand ='';
        $card_data = '';
        $upcoming_invoice = '';
        $recent_invoice = '';
        $stripe_subs = '';

        $mainSubscription = $shop->mainSubscription;

        if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE){
            $stripe_customer = \Stripe\Customer::retrieve($mainSubscription->stripe_customer_id);
            // get customer card details
            $card_data = $stripe_customer->sources->data[0]->card;

            // if json return of $card_data is empty
            if(empty($card_data)){
                $card_data = $stripe_customer->sources->data[0];
            }

            $card_expire_m = $card_data->exp_month;
            $card_expire_y = $card_data->exp_year;
            if($card_expire_m < 10){
                $card_expire_m = '0'.$card_expire_m;
            }
            $card_expire = $card_expire_m.'/'.$card_expire_y;
            $card_number = $card_data->last4;
            $card_brand = $card_data->brand;
        }

        // child store count
        $store_count = ChildStore::where('user_id', $shop->id)->count();
        $store_limit = '2';
        $prevSubscriptionsInvoice = '';
        $account_balance ='';

        if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE){
            // subscription active
            $subscriptions = SubscriptionStripe::where('user_id',$shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();
            try{
                if($subscriptions){
                    $stripe_subs =  \Stripe\Subscription::retrieve($subscriptions->stripe_id);
                    try {$upcoming_invoice = \Stripe\Invoice::upcoming(["customer" => $shop->stripe_id]);
                }catch (Exception $e) {
                  logger('No upcoming invoice for '.$shop);
                  $upcoming_invoice = '';
                }
            }

                // all previous invoices
                $prevSubscriptionsInvoice = \Stripe\Invoice::all(["customer" => $shop->stripe_id]);

                // account balance
                $account_balance = \Stripe\Customer::retrieve($shop->stripe_id);

            }catch(\Stripe\Exception\CardException $e) {
                logger("Since it's a decline, \Stripe\Error\Card will be caught");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\RateLimitException $e) {
                logger("Too many requests made to the API too quickly");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                logger("Invalid parameters were supplied to Stripe's API, error=".$err['message']);
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\AuthenticationException  $e) {
                logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                logger("Network communication with Stripe failed");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\ApiErrorException $e) {
                logger("Display a very generic error to the user, and maybe send yourself an email");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (Exception $e) {
                $body = $e->getMessage();
                logger("Something else happened, completely unrelated to Stripe: " . $body);
                $request->session()->flash('error', $body);
                return redirect()->route('plans');
            }

        }

        if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL){

            // subscription active
            $subscriptions = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_status','ACTIVE')->first();

            if($subscriptions){
                $sub_id = $subscriptions->paypal_id;
                $paypal_subs = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}"))->json();

//              $upcoming_invoice = $paypal_subs['billing_info']['next_billing_time'];
                $upcoming_invoice='';

                // all previous invoices
                $payload = ['recipient_email'=>$shop->email];
                $prevSubscriptionsInvoice = getPaypalHttpClient()->post(getPaypalUrl('v2/invoicing/search-invoices'),$payload)->json();

                // account balance
                $sub_id = $subscriptions->paypal_id;
//              $account_balance = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}"))->json();;
                $account_balance = '';

            }

        }
        $billingCycle = 'yearly';

        if ($shop->sub_plan == 'month') {
            $billingCycle = 'monthly';
        }

        if ($shop->sub_plan == 'Quarterly') {
          $billingCycle = 'quarterly';
        }

        $master_shops = ChildStore::where('store', $shop->name)->first();
        if($master_shops) {
          return redirect()->route('plans');
        }

        $pause_plan = unserialize($shop->pause_subscription);
        $pause_plan_name = "";
        if(!empty($pause_plan)){
              if(isset($pause_plan['plan_name']) && !empty($pause_plan['plan_name']) ){
                    $pause_plan_name = $pause_plan['plan_name'];
              }
        }



        return view('settings', [
            'user_since' => $shop->created_at->format('M d, Y'),
            'sub_plan' => $shop->sub_plan,
            'subscription_plan' => $shop->alladdons_plan,
            'all_addons' => $shop->all_addons,
            'card_expire' => $card_expire,
            'card_number' => $card_number,
            'card_brand' => $card_brand,
            'card_data' => $card_data,
            'all_invoices' => $prevSubscriptionsInvoice,
            'account_balance' => $account_balance,
            'upcoming_invoice' => $upcoming_invoice,
            'store_count' => $store_count,
            'store_limit' => $store_limit,
            'billingCycle' => $billingCycle,
            'recent_invoice' => $recent_invoice,
            'pause_plan_name' => $pause_plan_name,
            'is_paused' => $shop->is_paused,
        ]);
    }

    // plans view
    public function plans(StripePlan $plan, Request $request){
        $shop = Auth::user();

        $this->fetchInitialData();
        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
                $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->count();

            }else{
                $latest_theme = Themes::where('is_beta_theme', NULL)->orWhere('is_beta_theme', 0)->orderBy('id', 'desc')->first();
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
                $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();

        }

        if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
        }

        if(!isset($StoreThemes) || empty($StoreThemes)){
            $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        }

        if(!isset($theme_count) || empty($theme_count)){
                $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->count();

        }
        // $shop = User::where('id', '179')->first();
        // $latest_theme = Themes::orderBy('id', 'desc')->first();
        $free_addons = FreeAddon::where('shopify_domain', $shop->name)->where('status',1)->first();
        // $theme_count = StoreThemes::where('user_id', $shop->id)->count();
        // $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        $faqs = FrequentlyAskedQuestion::all();
        $exit_code = '50OFF3MONTHS';
        $new_code = 'DEBUTIFY20';
        $previous_plan = '';
        $discount = '';
        $current_plan = '';
        $current_cost = '';

        // subcription active
        if($shop->all_addons == 1) {

           $mainSubscription = $shop->mainSubscription;
           if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
               $subscriptions = SubscriptionStripe::where('user_id', $shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();
               if ($subscriptions) {
                   $stripe_subs = \Stripe\Subscription::retrieve($subscriptions->stripe_id);

                   $current_plan = $stripe_subs->plan;
                   $discount = $stripe_subs->discount;

                   // get subscription discount
                   if ($discount) {
                       if ($discount->coupon->percent_off) {
                           // $percent_off = $discount->coupon->percent_off.'% off';
                       } else {
                           $percent_off_1 = $discount->coupon->amount_off / 100;
                           $percent_off_2 = number_format($percent_off_1, 2);
                           // $percent_off = 'US$'.$percent_off_2.' off';
                       }
                   }

                   // get old pricing for current users
                   if ($current_plan) {
                       $current_cost = $current_plan->amount / 100;
                       if ($current_cost == '10' || $current_cost == '84' || $current_cost == '27' || $current_cost == '197' || $current_cost == '15' || $current_cost == '90') {
                           $previous_plan = $current_cost;
                       }
                   }
               }
           }
           if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
               $subscriptions = SubscriptionPaypal::where('user_id', $shop->id)->where('paypal_status','ACTIVE')->first();
                if ($subscriptions) {
                    $sub_id = $subscriptions->paypal_id;
                    $paypal_subs = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}"))->json();
                    $current_plan = StripePlan::where('paypal_plan',$paypal_subs['plan_id'])->first();

//                  $current_plan = StripePlan::find(1);

//                  $discount = $stripe_subs->discount;

                    // get subscription discount
//                    if ($discount) {
//                        if ($discount->coupon->percent_off) {
//                            // $percent_off = $discount->coupon->percent_off.'% off';
//                        } else {
//                            $percent_off_1 = $discount->coupon->amount_off / 100;
//                            $percent_off_2 = number_format($percent_off_1, 2);
//                            // $percent_off = 'US$'.$percent_off_2.' off';
//                        }
//                    }

                    // get old pricing for current users
                    if ($current_plan) {
                        $current_cost = explode(".",$current_plan->cost)[0];
                        if ($current_cost == '10' || $current_cost == '84' || $current_cost == '27' || $current_cost == '197' || $current_cost == '15' || $current_cost == '90') {
                            $previous_plan = $current_cost;
                        }
                    }
                }
            }
        }

        $StripePlan = StripePlan:: all();
        $plans = StripePlan:: all();
        if($free_addons){
          $free_addons = $free_addons->status;
        }
        if($theme_count > 0){
          $theme_current_version = Themes::where('id', $shop->theme_id)->get();
          if($shop->theme_id != null && $shop->shopify_theme_id != null){
            if ($latest_theme->id > $shop->theme_id) {
              $theme_url = $latest_theme->url;
              $request->session()->flash('new_version', $theme_url);
            }
          }
        }

        $starterPriceAnnually = $hustlerPriceAnnually = $guruPriceAnnually = 0;
        $starterPriceQuarterly = $hustlerPriceQuarterly = $guruPriceQuarterly = 0;
        $starterPriceMonthly = $hustlerPriceMonthly = $guruPriceMonthly = 0;

        $starteridQuarterly = $hustleridQuarterly = $guruidQuarterly = "";
        $starteridMonthly = $guruidMonthly = $hustleridMonthly = "";


        // get active plan price and ID
        foreach ($StripePlan as $plan) {
            if ($plan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY) {
                $starterPriceAnnually = $plan->cost;
            }

            if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY) {
                $hustlerPriceAnnually = $plan->cost;
            }

            if ($plan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY) {
                $guruPriceAnnually = $plan->cost;
            }

            if ($plan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY) {
                $starterPriceQuarterly = $plan->cost;
                $starteridQuarterly = $plan->stripe_plan;
            }

            if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY) {
                $hustlerPriceQuarterly = $plan->cost;
                $hustleridQuarterly = $plan->stripe_plan;
            }

            if ($plan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY) {
                $guruPriceQuarterly = $plan->cost;
                $guruidQuarterly = $plan->stripe_plan;
            }

            if ($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY) {
                $starterPriceMonthly = $plan->cost;
                $starteridMonthly = $plan->stripe_plan;
            }

            if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY) {
                $hustlerPriceMonthly = $plan->cost;
                $hustleridMonthly = $plan->stripe_plan;
            }

            if ($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY) {
                $guruPriceMonthly = $plan->cost;
                $guruidMonthly = $plan->stripe_plan;
            }
        }

        // child store count
        $store_count = ChildStore::where('user_id', $shop->id)->count();
        $store_limit = '2';

        // taxes
        $applyTaxes = false;
        $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
        )['body']['shop'];

        if($shopData['country_name'] == 'Canada'){
          $applyTaxes = true;
        }

        $billingCycle = 'yearly';

        if ($shop->sub_plan == 'month') {
            $billingCycle = 'monthly';
        }

        if ($shop->sub_plan == 'Quarterly') {
          $billingCycle = 'quarterly';
        }

        // $tax_id = getTaxId($shopData->province);

        return view('plans', [
          'plans' => $plans,
          'starterPriceAnnually' => $starterPriceAnnually,
          'hustlerPriceAnnually' => $hustlerPriceAnnually,
          'guruPriceAnnually' => $guruPriceAnnually,
          'starterPriceQuarterly' => $starterPriceQuarterly,
          'hustlerPriceQuarterly' => $hustlerPriceQuarterly,
          'guruPriceQuarterly' => $guruPriceQuarterly,
          'starterPriceMonthly' => $starterPriceMonthly,
          'hustlerPriceMonthly' => $hustlerPriceMonthly,
          'guruPriceMonthly' => $guruPriceMonthly,
          'starteridMonthly' => $starteridMonthly,
          'hustleridMonthly' => $hustleridMonthly,
          'guruidMonthly' => $guruidMonthly,
          'starteridQuarterly' => $starteridQuarterly,
          'hustleridQuarterly' => $hustleridQuarterly,
          'guruidQuarterly' => $guruidQuarterly,
          'free_addons'=> $free_addons,
          'store_count' => $store_count,
          'store_limit' => $store_limit,
          'discount' => $discount,
          'previous_plan' => $previous_plan,
          'all_addons' => $shop->all_addons,
          'alladdons_plan'=> $shop->alladdons_plan,
          'sub_plan' => $shop->sub_plan,
          'current_plan' => $current_plan,
          'current_cost' => $current_cost,
          'applyTaxes' => $applyTaxes,
          'billingCycle' => $billingCycle,
          'faqs' => $faqs
        ]);
    }

    // add-ons view
    public function theme_addons($s = null, StripePlan $plan, Request $request){
        $shop = Auth::user();

        $this->fetchInitialData();

          if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
              $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
              $theme_count = StoreThemes::where('user_id', $shop->id)->where('status',1)->count();
          }else{
              $latest_theme = Themes::where('is_beta_theme', '!=', 1)->orWhere('is_beta_theme', NULL)->orderBy('id', 'desc')->first();
              $theme_count = StoreThemes::where('user_id', $shop->id)->where('status',1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();
          }
           if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }

            $userThemes = StoreThemes::where('user_id', $shop->id)->get();
            $themeVersionTwo = false;
            if(isset($userThemes) && !empty($userThemes))
            {
              foreach($userThemes as $t)
              {
                if($t->version == '2.0.2')
                {
                  $themeVersionTwo = true;
                }
              }
            }

            if(!$themeVersionTwo)
            {
              return redirect()->route('theme_view');
            }

            if(!isset($theme_count) || empty($theme_count)){
                    $theme_count = StoreThemes::where('user_id', $shop->id)->where('status', 1)->count();
            }

          // $theme_count = StoreThemes::where('user_id', $shop->id)->where('status',1)->where('is_beta_theme','!=',1)->count();
          if($theme_count == 0){
            // return redirect()->route('theme_view');
          }

        // $latest_theme = Themes::orderBy('id', 'desc')->first();
        $free_addons = FreeAddon::where('shopify_domain', $shop->name)->where('status',1)->first();

        if($free_addons){
          $free_addons = $free_addons->status;
        }
        if($theme_count > 0){
          $theme_current_version = Themes::where('id', $shop->theme_id)->get();
          if($shop->theme_id != null && $shop->shopify_theme_id != null){
            if ($latest_theme->id > $shop->theme_id) {
                $theme_url = $latest_theme->url;
                $request->session()->flash('new_version', $theme_url);
            }
          }
        }

        if($this->subscription_status =='unpaid'){
          return redirect()->route('plans');
        }

        if(!empty($s))
        {
          $request->session()->flash('status', 'Theme Added');
        }

        $request->session()->keep(['status', 'message', 'theme_id_cstm']);

//        $is_update_banner_addon = false;
//        $cnt_addons = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
//        if( !(bool)$shop->is_updated_addon  && $cnt_addons > 0 ) {
//            $is_update_banner_addon = true;
//        }

        // if($theme_count > 0){
          return view('add_ons', [
              'free_addons'=>$free_addons,
              'is_update_banner_addon' => $this->isUpdatePending($shop),
          ]);
        // } else{
          // return redirect()->route('theme_view');
        // }
    }

    // free addon view
    public function free_addons(){
        $this->fetchInitialData();
        if($this->subscription_status =='unpaid'){
          return redirect()->route('plans');
        }
        return view('free_addons');
    }

    // update card view
    public function update_card(){
        $this->fetchInitialData();
        $url = route('billing');

        return \redirect($url);
    }

    // report bug view
    public function report_bug_pop(){
        $this->fetchInitialData();
        if($this->subscription_status =='unpaid'){
          return redirect()->route('plans');
        }
        return view('report_bug_popup');
    }


    //copy of other function ProratedAmount /used for subscription upsell
    public function getProratedAmount($plan_id,$subscription_stripe, $subscription) {
    $items = [
          [
              'id' => $subscription_stripe->items->data[0]->id,
              'price' => $plan_id, # Switch to new plan
          ],
      ];

      $invoice = \Stripe\Invoice::upcoming([
          'customer' => $subscription_stripe->customer,
          'subscription' => $subscription->stripe_id,
          'subscription_items' => $items,
          'subscription_proration_date' => time(),
      ]);
      $cost = 0;
      $current_prorations = [];
      $cost = $invoice->lines->data[0]->amount;
      return $amount = ($cost/100) * -1;
    }

    // thank you view
    public function thank_you(Request $request){
         // $request->session()->flash('subscription_upsell', 'Guru');

  if ($request->session()->has('status')) {
    $shop = Auth::user();
    $this->fetchInitialData();
    $exit_code = '50OFF3MONTHS';
    $new_code = 'DEBUTIFY20';
    $plan = '';
    $coupon_name = '';
    $percent_off = '';
    $coupon_duration = '';
    $coupon_duration_months = '';
    $previous_plan = '';
    $discount = '';
    $next_invoice_total = '';
    $card_expire = '';
    $card_number = '';
    $card_brand ='';
    $card_data = '';
    $current_plan = '';
    $current_cost = '';
    $stripe_subs = $subscriptions = [];
    $free_addons = FreeAddon::where('shopify_domain', $shop->name)->where('status',1)->first();
    $mainSubscription = $shop->mainSubscription;


    if($shop->all_addons == 1){
        if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE){
            //check if the previous subscription is still active from paypal, if active then cancelling that.
            $paypalSubs = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_status','ACTIVE')->get();
            if($paypalSubs){
                foreach ($paypalSubs as $singlePaypalSub)
                {
                    $pc = new PaypalController();
                    $pc->cancelSubscription($request, $singlePaypalSub, $singlePaypalSub->paypal_id);
                }
            }

            $subscriptions = SubscriptionStripe::where('user_id',$shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();
            if($subscriptions){
                $stripe_subs =  \Stripe\Subscription::retrieve($subscriptions->stripe_id);
                $stripe_customer = \Stripe\Customer::retrieve($shop->stripe_id);
                $stripe_upcoming_invoice = \Stripe\Invoice::upcoming(["subscription" => $stripe_subs]);
                // get customer card details
                $card_data = $stripe_customer->sources->data[0]->card;

                // if json return of $card_data is empty
                if($card_data){} else{
                    $card_data = $stripe_customer->sources->data[0];
                }

                $card_expire_m = $card_data->exp_month;
                $card_expire_y = $card_data->exp_year;
                if($card_expire_m < 10){
                    $card_expire_m = '0'.$card_expire_m;
                }
                $card_expire = $card_expire_m.'/'.$card_expire_y;
                $card_number = $card_data->last4;
                $card_brand = $card_data->brand;
                // End Of card

                $current_plan = $stripe_subs->plan;
                $discount = $stripe_subs->discount;
                // $next_invoice_total_1 = $stripe_upcoming_invoice->total/100;
                $next_invoice_total_1 = $stripe_upcoming_invoice->amount_due/100;
                $next_invoice_total = number_format($next_invoice_total_1, 2);

                // get subscription discount
                if($discount){
                    $coupon_name = $discount->coupon->name;
                    $coupon_duration = $discount->coupon->duration;
                    $coupon_duration_months = $discount->coupon->duration_in_months;

                    if($discount->coupon->percent_off){
                        $percent_off = $discount->coupon->percent_off.'% off';
                    } else{
                        $percent_off_1 = $discount->coupon->amount_off/100;
                        $percent_off_2 = number_format($percent_off_1, 2);
                        $percent_off = 'US$'.$percent_off_2.' off';
                    }
                }
                $current_plan_duration = 'monthly';
                if(strpos(strtolower($current_plan->nickname), "annually") !== false){
                    $current_plan_duration = 'annually';
                }
                // get old pricing for current users
                if($current_plan){
                    $current_cost = $current_plan->amount/100;
                    if($current_cost == '10' || $current_cost == '84' || $current_cost == '27' || $current_cost == '197' || $current_cost == '15' || $current_cost == '90'){
                        $previous_plan = $current_cost;
                    }
                }
            }
        }
        if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL){
            $subscriptions = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_status','ACTIVE')->first();

            if($subscriptions){
                $sub_id = $subscriptions->paypal_id;
                $paypal_subs = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}"))->json();
                $paypalPlanResponse = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/plans/${paypal_subs['plan_id']}"))->json();

                $paypal_customer = $paypal_subs['subscriber']['payer_id'];
                $paypal_upcoming_invoice = $paypal_subs['billing_info']['next_billing_time'];
                $current_plan = $paypalPlanResponse['name'];

                // $next_invoice_total_1 = $stripe_upcoming_invoice->total/100;
                $next_invoice_total_1 = $paypal_subs['billing_info']['last_payment']['amount']['value'];
                $next_invoice_total = number_format($next_invoice_total_1, 2);

                $current_plan_duration = 'monthly';
                if(strpos(strtolower($current_plan), "annually") !== false){
                    $current_plan_duration = 'annually';
                }
                // get old pricing for current users
                if($current_plan){
                    $current_cost = (int)$paypal_subs['billing_info']['last_payment']['amount']['value'];
                    if($current_cost == '10' || $current_cost == '84' || $current_cost == '27' || $current_cost == '197' || $current_cost == '15' || $current_cost == '90'){
                        $previous_plan = $current_cost;
                    }
                }
            }
        }

    }

    $StripePlan = StripePlan:: all();
    if($free_addons){
      $free_addons = $free_addons->status;
    }

    $starterPriceAnnually = $starterPriceQuarterly = $starterPriceMonthly = 0;
    $hustlerPriceAnnually = $hustlerPriceQuarterly = $hustlerPriceMonthly = 0;
    $guruPriceAnnually = $guruPriceQuarterly = $guruPriceMonthly = 0;

    $starteridAnnually = $starteridQuarterly = $starteridMonthly = "";
    $hustleridAnnually = $hustleridQuarterly = $hustleridMonthly = "";
    $guruidAnnually = $guruidQuarterly = $guruidMonthly = "";

    // get active plan price and ID
    foreach ($StripePlan as $plan) {
      if ($plan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY) {
        $starterPriceAnnually = $plan->cost;
        $starteridAnnually = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY) {
        $starterPriceQuarterly = $plan->cost;
        $starteridQuarterly = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY) {
        $starterPriceMonthly = $plan->cost;
        $starteridMonthly = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY) {
        $hustlerPriceAnnually = $plan->cost;
        $hustleridAnnually = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY) {
        $hustlerPriceQuarterly = $plan->cost;
        $hustleridQuarterly = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY) {
        $hustlerPriceMonthly = $plan->cost;
        $hustleridMonthly = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY) {
        $guruPriceAnnually = $plan->cost;
        $guruidAnnually = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY) {
        $guruPriceQuarterly = $plan->cost;
        $guruidQuarterly = $plan->stripe_plan;
      }

      if ($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY) {
        $guruPriceMonthly = $plan->cost;
        $guruidMonthly = $plan->stripe_plan;
      }
    }


        // taxes
  $applyTaxes = false;
  $shopData = $shop->api()->request(
    'GET',
    '/admin/api/shop.json',
    []
  )['body']['shop'];

  if($shopData['country_name'] == 'Canada'){
    $applyTaxes = true;
  }


  $data = $request->session()->get('thank_you_data');
  $hustler_count = ((int) User::where('alladdons_plan', 'Hustler')->count());
  $master_count  = ((int) User::where('alladdons_plan', 'Guru')->orWhere('alladdons_plan', 'Master')->count());

  $user_count = '';
  $next_plan = '';
  $difference_extra10 = '';
  $savings_extra10  = '';
  $sub_plan = $shop->sub_plan;
  $alladdons_plan=  $shop->alladdons_plan;
  $freemium = 'Freemium';
  $starter = 'Starter';
  $hustler = 'Hustler';
  $difference = '';
  $savings = '';
  $user_count = '';
  $next_plan = '';
  $difference_extra10 = '';
  $savings_extra10  = '';
  $guru = 'Master';

  if ($sub_plan == 'Quarterly') {
    $first_month_or_year = "quarter";

    if ($alladdons_plan == $starter && $mainSubscription->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE) {
      $getProratedAmount = $this->getProratedAmount($hustleridQuarterly,$stripe_subs, $subscriptions);
      $difference =   number_format(($hustlerPriceQuarterly * 0.7)-$getProratedAmount,2);
      $difference_extra10 = number_format(($hustlerPriceQuarterly * 0.6)-$getProratedAmount,2);
      $savings = number_format($hustlerPriceQuarterly - ($hustlerPriceQuarterly * 0.7),2);
      $savings_extra10 = number_format($hustlerPriceQuarterly - ($hustlerPriceQuarterly * 0.6),2);
      $next_plan = $hustler;
      $user_count = $hustler_count;

    } else if ($alladdons_plan == $hustler && $mainSubscription->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE) {
      $getProratedAmount = $this->getProratedAmount($guruidQuarterly,$stripe_subs, $subscriptions);
      $difference =   number_format(($guruPriceQuarterly * 0.6)-$getProratedAmount,2);
      $difference_extra10 = number_format(($guruPriceQuarterly * 0.5)-$getProratedAmount,2);
      $savings = number_format($guruPriceQuarterly - ($guruPriceQuarterly * 0.6),2);
      $savings_extra10 = number_format($guruPriceQuarterly - ($guruPriceQuarterly * 0.5),2);
      $next_plan = $guru;
      $user_count = $master_count;
    }
  } else if ($sub_plan != 'Yearly') {
    $first_month_or_year = "month";

    if ($alladdons_plan == $starter && $mainSubscription->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE) {
      $getProratedAmount = $this->getProratedAmount($hustleridMonthly,$stripe_subs, $subscriptions);
      $difference =   number_format(($hustlerPriceMonthly * 0.7)-$getProratedAmount,2);
      $difference_extra10 = number_format(($hustlerPriceMonthly * 0.6)-$getProratedAmount,2);
      $savings = number_format($hustlerPriceMonthly - ($hustlerPriceMonthly * 0.7),2);
      $savings_extra10 = number_format($hustlerPriceMonthly - ($hustlerPriceMonthly * 0.6),2);
      $next_plan = $hustler;
      $user_count = $hustler_count;

    } else if ($alladdons_plan == $hustler && $mainSubscription->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE) {
      $getProratedAmount = $this->getProratedAmount($guruidMonthly,$stripe_subs, $subscriptions);
      $difference =   number_format(($guruPriceMonthly * 0.6)-$getProratedAmount,2);
      $difference_extra10 = number_format(($guruPriceMonthly * 0.5)-$getProratedAmount,2);
      $savings = number_format($guruPriceMonthly - ($guruPriceMonthly * 0.6),2);
      $savings_extra10 = number_format($guruPriceMonthly - ($guruPriceMonthly * 0.5),2);
      $next_plan = $guru;
      $user_count = $master_count;
    }
  } else {
    $first_month_or_year = "year";

    if ($alladdons_plan == $starter && $mainSubscription->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE) {
      $getProratedAmount = $this->getProratedAmount($hustleridAnnually,$stripe_subs, $subscriptions);
      $difference =   number_format(($hustlerPriceAnnually * 0.7)- $getProratedAmount,2);
      $difference_extra10 = number_format(($hustlerPriceAnnually * 0.6)-$getProratedAmount,2);
      $savings = number_format($hustlerPriceAnnually - ($hustlerPriceAnnually * 0.7),2);
      $savings_extra10 = number_format($hustlerPriceAnnually - ($hustlerPriceAnnually * 0.6),2);
      $next_plan = $hustler;
      $user_count = $hustler_count;
    } else if ($alladdons_plan == $hustler && $mainSubscription->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE) {
      $getProratedAmount = $this->getProratedAmount($guruidAnnually,$stripe_subs, $subscriptions);
      $difference =   number_format(($guruPriceAnnually * 0.6)- $getProratedAmount ,2);
      $difference_extra10 = number_format(($guruPriceAnnually * 0.5)-$getProratedAmount,2);
      $savings = number_format($guruPriceAnnually - ($guruPriceAnnually * 0.6),2);
      $savings_extra10 = number_format($guruPriceAnnually - ($guruPriceAnnually * 0.5),2);
      $next_plan = $guru;
      $user_count = $master_count;
    }
  }

  $finalAmount = ($data['amount'] > 0) ? $data['amount']/100 : 0;

  $taxFinal = ($data['tax'] > 0) ? $data['tax']/100 : 0;

  $revenueFinal = ($data['revenue'] > 0) ? $data['revenue']/100 : 0;


  return view('thank-you', [
    'first_month_or_year' =>$first_month_or_year,
    'difference' =>  $difference,
    'difference_extra10' => $difference_extra10,
    'savings' =>    $savings,
    'savings_extra10' =>  $savings_extra10,
    'next_plan' =>$next_plan,
    'user_count' =>$user_count,
    'hide_side_bar'=>1,
    'tracking'  => $data['tracking'],
    'amount'    => $finalAmount,
    'subscription_id' => $data['subscription_id'],
    'starterPriceAnnually' => $starterPriceAnnually,
    'starterPriceQuarterly' => $starterPriceQuarterly,
    'starterPriceMonthly' => $starterPriceMonthly,
    'hustlerPriceAnnually' => $hustlerPriceAnnually,
    'hustlerPriceQuarterly' => $hustlerPriceQuarterly,
    'hustlerPriceMonthly' => $hustlerPriceMonthly,
    'guruPriceAnnually' => $guruPriceAnnually,
    'guruPriceQuarterly' => $guruPriceQuarterly,
    'guruPriceMonthly' => $guruPriceMonthly,
    'starteridAnnually' => $starteridAnnually,
    'starteridQuarterly' => $starteridQuarterly,
    'starteridMonthly' => $starteridMonthly,
    'hustleridAnnually' => $hustleridAnnually,
    'hustleridQuarterly' => $hustleridQuarterly,
    'hustleridMonthly' => $hustleridMonthly,
    'guruidAnnually' => $guruidAnnually,
    'guruidQuarterly' => $guruidQuarterly,
    'guruidMonthly' => $guruidMonthly,
    'plan' => $plan,
    'free_addons'=> $free_addons,
    'exit_code' => $exit_code,
    'new_code' => $new_code,
    'coupon_name' => $coupon_name,
    'percent_off' =>$percent_off,
    'coupon_duration' =>$coupon_duration,
    'coupon_duration_months' =>$coupon_duration_months,
    'discount' => $discount,
    'previous_plan' => $previous_plan,
    'next_invoice_total' => $next_invoice_total,
    'card_expire' => $card_expire,
    'card_number' => $card_number,
    'card_brand' => $card_brand,
    'card_data' => $card_data,
    'all_addons' => $shop->all_addons,
    'alladdons_plan'=> $shop->alladdons_plan,
    'sub_plan' => $shop->sub_plan,
    'current_plan' => $current_plan,
    'current_cost' => $current_cost,
    'applyTaxes' => $applyTaxes,
    'hustler_count' => $hustler_count,
    'master_count' =>$master_count,
    'plan_id' => $data['plan_id'],
    'revenue' => $revenueFinal,
    'customer_id' => $shop->id,
    'customer_email_sha1' => sha1($shop->email),
    'tax' => $taxFinal,
    'coupon' => $data['coupon'],
    'payment_method'=>MainSubscription::PAYMENT_PLATFORM_STRIPE

  ]);
        }
        else
        {
          return redirect()->route('home');
        }
    }

    // good bye view
    public function good_bye(){
        $shop = Auth::user();
        $this->fetchInitialData();
        $store_count = ChildStore::where('user_id', $shop->id)->count();
        $discount_price = $plan_name = "";
        $StripePlans = StripePlan::all();

          $starterPriceAnnually = $hustlerPriceAnnually = $guruPriceAnnually = 0;
          $starterPriceQuarterly = $hustlerPriceQuarterly = $guruPriceQuarterly = 0;

              foreach ($StripePlans as $StripePlan) {
                  if($StripePlan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY){
                      $starterPriceAnnually = $StripePlan->cost;
                  }
                  if($StripePlan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY){
                      $hustlerPriceAnnually = $StripePlan->cost;
                  }
                  if($StripePlan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY){
                      $guruPriceAnnually = $StripePlan->cost;
                  }
                  if($StripePlan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY){
                      $starterPriceQuarterly = $StripePlan->cost;
                  }
                  if($StripePlan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY){
                      $hustlerPriceQuarterly = $StripePlan->cost;
                  }
                  if($StripePlan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY){
                      $guruPriceQuarterly = $StripePlan->cost;
                  }
              }

              if($shop->is_paused == true){
                $pause_plan_data = unserialize($shop->pause_subscription);
                if(isset($pause_plan_data['plan_name']) && !empty($pause_plan_data['plan_name'])){
                  $plan_name = $pause_plan_data['plan_name'];
                }
              }else{
                 $plan_name = $shop->alladdons_plan;
              }


              if($shop->sub_plan == 'Yearly'){
                if($plan_name == 'Starter'){
                    $discount_price = number_format(($starterPriceAnnually*20)/100, 2);
                }elseif ($plan_name == 'Hustler') {
                    $discount_price = number_format(($hustlerPriceAnnually*20)/100, 2);
                }elseif ($plan_name == 'Master') {
                    $discount_price = number_format(($guruPriceAnnually*20)/100, 2);
                }
              }

              if($shop->sub_plan == 'Quarterly'){
                if($plan_name == 'Starter'){
                    $discount_price = number_format(($starterPriceQuarterly*20)/100, 2);
                }elseif ($plan_name == 'Hustler') {
                    $discount_price = number_format(($hustlerPriceQuarterly*20)/100, 2);
                }elseif ($plan_name == 'Master') {
                    $discount_price = number_format(($guruPriceQuarterly*20)/100, 2);
                }
              }

          return view('good-bye', [
              'hide_side_bar' => 1,
              'store_count' => $store_count,
              'pause_subscription' => $shop->is_paused,
              'starterPriceAnnually' => $starterPriceAnnually,
              'hustlerPriceAnnually' => $hustlerPriceAnnually,
              'guruPriceAnnually' => $guruPriceAnnually,
              'starterPriceQuarterly' => $starterPriceQuarterly,
              'hustlerPriceQuarterly' => $hustlerPriceQuarterly,
              'guruPriceQuarterly' => $guruPriceQuarterly,
              'yearly_discount_price' => $discount_price,
          ]);

    }

    // activate addon function
    public function active_addons($addon_id, $themes_id, $update_addon, $key){
        $shop = Auth::user();
        $this->fetchInitialData();
        $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $themes_id)->where('status', 1)->where('version', '2.0.2')->get();
        $delivery_addon_activated = AddOns::where('user_id',$shop->id)->where('global_id', 4)->where('status',1)->count();
        $addon_count = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
        $StoreThemes=[];

        foreach ($StoreTheme as $theme) {
            try{
                $get_theme = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
                )['body']['theme'];
                $StoreThemes[] = $theme;
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on live view addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on live view addon throws exception');
            }
        }


        if($StoreThemes){
            // add dbtfy scripts (function in helper.php)
            if($key == 0){
              add_debutify_JS($StoreThemes, $shop);
              sleep(2);
              addScriptTag($shop);
              if($shop->script_tags) {
                sleep(2);
                removeServerJS($StoreThemes, $shop);
              }
            }

            // activate add-ons
            switch ($addon_id) {
                case 1:
                    activate_trustbadge_addon($StoreThemes, $shop);
                    break;
                case 2:
                    activate_liveview_addon($StoreThemes, $shop, $delivery_addon_activated);
                    break;
                case 3:
                    activate_cookibox_addon($StoreThemes, $shop);
                    break;
                case 4:
                    activate_deliverytime_addon($StoreThemes, $shop);
                    break;
                case 5:
                    activate_addtocart_animation_addon($StoreThemes, $shop);
                    break;
                case 6:
                    activate_salespop_addon($StoreThemes, $shop);
                    break;
                // case 7:
                //     activate_instagramfeed_addon($StoreThemes, $shop);
                //     break;
                case 8:
                    if($update_addon == 1){
                      activate_producttab_addon_js($StoreThemes, $shop);
                    }
                    else{
                      activate_producttab_addon($StoreThemes, $shop);
                    }
                    break;
                case 9:
                    activate_chatbox_addon($StoreThemes, $shop);
                    break;
                case 10:
                    if($update_addon == 1){
                      activate_faqepage_addon_js($StoreThemes, $shop);
                    }
                    else{
                      activate_faqepage_addon($StoreThemes, $shop);
                    }
                    break;
                case 11:
                    activate_sticky_addtocart_addon($StoreThemes, $shop);
                    break;
                case 12:
                    activate_product_video_addon($StoreThemes, $shop);
                    break;
                case 13:
                    activate_shop_protect_addon($StoreThemes, $shop);
                    break;
                case 14:
                    if($update_addon == 1){
                      activate_mega_menu_addon_js($StoreThemes, $shop);
                    }
                    else{
                      activate_mega_menu_addon($StoreThemes, $shop);
                    }
                    break;
                case 15:
                    activate_newsletter_popup_addon($StoreThemes, $shop);
                    break;
                case 16:
                    activate_collection_addtocart_addon($StoreThemes, $shop);
                    break;
                case 17:
                    activate_upsell_popup_addon($StoreThemes, $shop);
                    break;
                case 18:
                    activate_discount_saved_addon($StoreThemes, $shop);
                    break;
                case 19:
                    activate_sales_countdown_addon($StoreThemes, $shop);
                    break;
                case 20:
                    activate_inventory_quantity_addon($StoreThemes, $shop);
                    break;
                case 21:
                    activate_linked_options_addon($StoreThemes, $shop);
                    break;
                case 22:
                    activate_cart_countdown_addon($StoreThemes, $shop);
                    break;
                case 23:
                    activate_colorswatches_addon($StoreThemes, $shop);
                    break;
                case 24:
                    activate_cart_discount_addon($StoreThemes, $shop);
                    break;
                case 25:
                    activate_upsell_bundles_addon($StoreThemes, $shop);
                    break;
                case 26:
                    activate_skip_cart_addon($StoreThemes, $shop);
                    break;
                case 27:
                    activate_smart_search_addon($StoreThemes, $shop);
                    break;
                case 28:
                    activate_quick_view_addon($StoreThemes, $shop);
                    break;
                case 29:
                    activate_cart_goal_addon($StoreThemes, $shop);
                    break;
                case 30:
                    activate_pricing_table_addon($StoreThemes, $shop);
                    break;
                case 31:
                    activate_wish_list_addon($StoreThemes, $shop);
                    break;
                case 32:
                    activate_quantity_breaks_addon($StoreThemes, $shop);
                    break;
                case 33:
                    activate_ageCheck_addon($StoreThemes, $shop);
                    break;
                case 34:
                    activate_pageTransition_addon($StoreThemes, $shop);
                    break;
            }
        }
    }

    // deactivate addon function
    public function deactive_addons($shop,$StoreThemes,$addon_id,$checkaddon,$update_addon){
        if($StoreThemes){

            $tempThemes = array();
            foreach($StoreThemes as $t)
            {
                if($t->version == '2.0.2')
                {
                    $tempThemes[] = $t;
                }
            }
            if(!empty($tempThemes))
            {
                $StoreThemes = $tempThemes;
            }
            else
            {
                return true;
            }

            $this->fetchInitialData();
            // remove dbtfy scripts (function in helper.php)
            if($checkaddon == 1){
              no_addon_activate($StoreThemes, $shop);
            }

            // uninstall add-ons
            switch ($addon_id) {
                case 1:
                    deactivate_trustbadge_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 2:
                    deactivate_liveview_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 3:
                    deactivate_cookibox_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 4:
                    deactivate_deliverytime_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 5:
                    deactivate_addtocart_animation_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 6:
                    deactivate_salespop_addon($StoreThemes, $shop, $checkaddon);
                    break;
                // case 7:
                //     deactivate_instagramfeed_addon($StoreThemes, $shop, $checkaddon);
                //     break;
                case 8:
                    deactivate_producttabs_addon($StoreThemes, $shop, $checkaddon, $update_addon);
                    break;
                case 9:
                    deactivate_chatbox_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 10:
                    deactivate_faqepage_addon($StoreThemes, $shop, $checkaddon, $update_addon);
                    break;
                case 11:
                    deactivate_sticky_addtocart_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 12:
                    deactivate_product_video_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 13:
                    deactivate_shop_protect_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 14:
                    deactivate_mega_menu_addon($StoreThemes, $shop, $checkaddon, $update_addon);
                    break;
                case 15:
                    deactivate_newsletter_popup_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 16:
                    deactivate_collection_addtocart_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 17:
                    deactivate_upsell_popup_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 18:
                    deactivate_discount_saved_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 19:
                    deactivate_sales_countdown_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 20:
                    deactivate_inventory_quantity_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 21:
                    deactivate_linked_options_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 22:
                    deactivate_cart_countdown_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 23:
                    deactivate_colorswatches_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 24:
                    deactivate_cart_discount_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 25:
                    deactivate_upsell_bundles_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 26:
                    deactivate_skip_cart_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 27:
                    deactivate_smart_search_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 28:
                    deactivate_quick_view_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 29:
                    deactivate_cart_goal_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 30:
                    deactivate_pricing_table_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 31:
                    deactivate_wish_list_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 32:
                    deactivate_quantity_breaks_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 33:
                    deactivate_ageCheck_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 34:
                    deactivate_pageTransition_addon($StoreThemes, $shop, $checkaddon);
                    break;
            }
        }
    }

    // downlod theme function
    public function download_theme(Request $request){
      logger("Download theme");
      $shop = Auth::user();
      $this->fetchInitialData();

            if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
                if(!isset($latest_theme) || empty($latest_theme)){
                      $latest_theme = Themes::orderBy('id', 'desc')->first();
                }
                $count_themes = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_name', 'Debutify '.$latest_theme->version)->where('status', 1)->count();
                $last_themes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('id', 'desc')->first();
            }else{
                $latest_theme = Themes::where('is_beta_theme', '!=', 1)->orderBy('id', 'desc')->first();
                if(!isset($latest_theme) || empty($latest_theme)){
                      $latest_theme = Themes::orderBy('id', 'desc')->first();
                }
                $count_themes = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_name', 'Debutify '.$latest_theme->version)->where('status', 1)->where('is_beta_theme','!=',1)->count();
                $last_themes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orderBy('id', 'desc')->first();
            }

            if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }

            logger("here is the latest_theme: " . json_encode($latest_theme));
        // $latest_theme = Themes::orderBy('id', 'desc')->first();

        $theme_name = $request->get('Theme-Name');

        // name theme
        if(empty($theme_name)) {
          if ($count_themes > 0) {
            $theme_name = 'Copy of '.$last_themes->shopify_theme_name;
          }
          else{
              $theme_name = 'Debutify '.$latest_theme->version;
          }
        }

       // $shop->save();

        $theme = array('theme' =>array(
                          'name' => $theme_name,
                          'src' => $latest_theme->url,
                          )
                      );
        try{
            $upload_theme_response  = $shop->api()->request(
                'POST',
                '/admin/api/themes.json',
                $theme
            )['body']['theme'];
        }
        catch (\Exception $e) {
            $upload_theme_response = $e->getMessage();
        }

        // theme downloaded successfully
        if (isset($upload_theme_response['id'])) {

            $shop->theme_id = $latest_theme->id;
            $shop->theme_url = $latest_theme->url;
            $shop->lastactivity = new DateTime();
            $shop->shopify_theme_id = $upload_theme_response['id'];
            $shop->theme_check = 1;
            $shop->save();


            if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                  $theme_count = StoreThemes::where('shopify_theme_id', $upload_theme_response['id'])->where('status',1)->count();
            }else{
                 $theme_count = StoreThemes::where('shopify_theme_id', $upload_theme_response['id'])->where('status',1)->where('is_beta_theme','!=',1)->count();
            }

            if($theme_count == 0){
                $StoreTheme = new StoreThemes;
                $StoreTheme->shopify_theme_id = $upload_theme_response['id'];
                $StoreTheme->shopify_theme_name = $upload_theme_response['name'];
                $StoreTheme->role = 0;
                $StoreTheme->status = 1;
                $StoreTheme->user_id = $shop->id;
                $StoreTheme->version = $latest_theme->version;

                if(isset($latest_theme->is_beta_theme) && $latest_theme->is_beta_theme == 1 ){
                    $StoreTheme->is_beta_theme = 1;
                }else{
                    $StoreTheme->is_beta_theme = 0;
                }

                $StoreTheme->save();
            }

            sleep(5);

            // install active add-ons on new theme
            $activated_addons = AddOns::where('user_id', $shop->id)->where('status', 1)->get();
            $delivery_addon_activated = 0;
            $update_addon = 0;

            if($latest_theme->version == '2.0.2'){
                foreach ($activated_addons as $key=>$addon) {
                    $this->active_addons($addon->global_id, $upload_theme_response['id'], $update_addon, $key);
                }
            }
            if( $request->get('CopyOldSettings') && $request->get('theme_id')){
              sleep(3);
              logger("Update the theme started");
              $schemas = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$request->get('theme_id').'/assets.json',
                  ['asset' => ['key' => 'config/settings_data.json'] ]
              )['body']['asset']['value'];
                sleep(3);

              $themeCheck = StoreThemes::where('shopify_theme_id', $request->get('theme_id'))->first();

              if($latest_theme->version != '2.0.2' && $themeCheck->version == '2.0.2')
                {
                    logger('data updating for theme 3.0');
                    $json = json_decode($schemas, true);

                    $remove = '';
                    foreach($json['current']['sections']['footer']['blocks'] as $b => $v) {
                      if($v['type'] == 'social_medias') {
                        $remove = $b;
                      }
                    }

                    if($remove) {
                      unset($json['current']['sections']['footer']['blocks'][$remove]);
                    }

                    $tempArr = array();
                    $jsonTemp = $json;
                    $needsUpdate = false;

                    foreach($json['current']['sections'] as $k => $s)
                    {
                        if(is_numeric($k))
                        {
                            if(isset($s['blocks']))
                            {
                                $tempBlocks = array();
                                foreach($s['blocks'] as $kb => $b)
                                {
                                    if(isset($b['settings']))
                                    {
                                        if(empty($b['settings']))
                                        {
                                            $b['settings'] = (object)array();
                                            $tempBlocks[$kb] = $b;
                                            $needsUpdate = true;
                                        }
                                    }
                                }
                                if(!empty($tempBlocks))
                                {
                                    $s['blocks'] = $tempBlocks;
                                    $jsonTemp['current']['sections'][$k] = $s;
                                }
                            }
                        }
                    }

                    if($needsUpdate)
                    {
                        $json = $jsonTemp;
                    }

                    $schemas = json_encode($json);
                    //logger($schemas);
                }

              $original_schemas = $schemas;
              $update_schema_settings = $shop->api()->request(
                'PUT',
                '/admin/api/themes/'.$upload_theme_response['id'].'/assets.json',
                ['asset' => ['key' => 'config/settings_data.json', 'value' => $original_schemas] ]
              );
              //logger("Here is duplicate response: " . json_encode($update_schema_settings));

              if($latest_theme->version != '2.0.2' && $themeCheck->version == '2.0.2'){
                sleep(5);
                //logger("Here is the retrieved schema");
                $schemas = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$upload_theme_response['id'].'/assets.json',
                  ['asset' => ['key' => 'config/settings_data.json'] ]
                )['body']['asset']['value'];

                //logger($schemas);
              }
            }

            if($request->get('CopyNewFiles') && $request->get('theme_id')) {
              logger("Came in to copy content");
              $copyFilesFrom = StoreThemes::where('shopify_theme_id', $request->get('theme_id'))->first();
              $userThemeFileNames = getAllThemeFileNames($shop, $request->get('theme_id'));
              logger("Fetched all theme files");
              if($copyFilesFrom['version'] == '2.0.2') {
                $themeFileNames = versionTwoThemeFiles();
              }
              elseif($copyFilesFrom['version'] == '3.0.0') {
                $themeFileNames = versionThreeThemeFiles();
              }
              elseif($copyFilesFrom['version'] == '3.0.1') {
                $themeFileNames = versionThreePointOneThemeFiles();
              }
              elseif($copyFilesFrom['version'] == '3.0.2') {
                $themeFileNames = versionThreePointTwoThemeFiles();
              }
              else {
                $themeFileNames = versionThreePointThreeThemeFiles();
              }

              logger("Starting loop on files");
              foreach($userThemeFileNames as $userThemeFileName) {

                if(($userThemeFileName == 'snippets/review-badge.liquid' || $userThemeFileName == 'snippets/review-widget.liquid') && ($latest_theme->version != '2.0.2')) {
                  continue;
                }

                if(in_array($userThemeFileName, $themeFileNames)) {
                  logger("Compairing: " . $userThemeFileName);
                  compairUpdateCommonFilesDiff($shop, $userThemeFileName, $upload_theme_response['id'], $request->get('theme_id'), $copyFilesFrom['version']);
                }
                else {
                  logger("Adding new file: " . $userThemeFileName);
                  putMissingThemeFile($shop, $userThemeFileName, $upload_theme_response['id'], $request->get('theme_id'));
                }
              }
              logger("Looping complete");
            }

            $redirectThemes = 0;
            if($latest_theme->is_beta_theme == 1 || $latest_theme->version != '2.0.2')
            {
              $redirectThemes = 1;
            }

            $is_theme_processing = $upload_theme_response['processing'];
            if( !$is_theme_processing ){

                if($latest_theme->version != '2.0.2' && !empty($original_schemas)){
                  logger("updating the data again");
                  $update_schema_settings = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$upload_theme_response['id'].'/assets.json',
                    ['asset' => ['key' => 'config/settings_data.json', 'value' => $original_schemas] ]
                  );
                }

                return response()->json([
                    'status' => 'ok',
                    'message' => 'Theme added',
                    'is_beta_theme' => $redirectThemes
                ]);
            }else{
                do {
                    $is_theme_processing = $this->getThemeProcessing($upload_theme_response['id']);
                    sleep(3);   //wait for 5 sec for next function call
                    if( !$is_theme_processing ){

                      if($latest_theme->version != '2.0.2' && !empty($original_schemas)){
                        logger("updating the data again");
                        $update_schema_settings = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$upload_theme_response['id'].'/assets.json',
                          ['asset' => ['key' => 'config/settings_data.json', 'value' => $original_schemas] ]
                        );
                      }

                        return response()->json([
                            'status' => 'ok',
                            'message' => 'Theme added',
                            'is_beta_theme' => $redirectThemes
                        ]);
                    }

                } while($is_theme_processing === TRUE);
            }
        }

        // theme download error
        else{
            try{
                $message = "";
                $shopify_themes = $shop->api()->request(
                      'GET',
                      '/admin/api/themes.json'
                )['body']['themes'];
                $theme_count = count($shopify_themes);
               // logger($theme_count);
                if($theme_count >= 20){
                    $message = 'Your online store has a maximum of 20 themes. Remove unused themes to add more.';
                } else{
                    $message = 'Error Occurred. Please try again';
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('getting themes throws client exception');
            }
            catch(\Exception $e){
                logger('getting themes throws exception');
            }
            return response()->json([
                'status' => 'error',
                'message' => $message
            ]);
        }
    }

    // ajax download theme function
    public function theme_download_post(Request $request){

      logger("theme_download_post");
        $shop = Auth::user();
        $this->fetchInitialData();


        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
            $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
            if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }
            $count_themes = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_name', 'Debutify '.$latest_theme->version)->where('status', 1)->count();

        }else{
            $latest_theme = Themes::where('is_beta_theme', NULL)->orWhere('is_beta_theme','0')->orderBy('id', 'desc')->first();
            if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }
            $count_themes = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_name', 'Debutify '.$latest_theme->version)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();

        }
         if(!isset($latest_theme) || empty($latest_theme)){
                  $latest_theme = Themes::orderBy('id', 'desc')->first();
            }

        // $latest_theme = Themes::orderBy('id', 'desc')->first();
        // $count_themes = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_name', 'Debutify '.$latest_theme->version)->where('status', 1)->count();

        $theme_name = '';
        if ($count_themes > 0) {
            $theme_name = 'Copy of Debutify '.$latest_theme->version;
        }
        else{
            $theme_name = 'Debutify '.$latest_theme->version;
        }

        $shop->theme_id = $latest_theme->id;
        $shop->theme_url = $latest_theme->url;
        $shop->save();

        $theme = array('theme' =>array(
            'name' => $theme_name,
            'src' => $latest_theme->url,
        ));

        try{
            $upload_theme_response  = $shop->api()->request(
                'POST',
                '/admin/api/themes.json',
                $theme
            )['body']['theme'];
        }
        catch (\Exception $e) {
            $upload_theme_response = $e->getMessage();
        }
        if (isset($upload_theme_response['id'])) {
            $shop->lastactivity = new DateTime();
            $shop->shopify_theme_id = $upload_theme_response['id'];
            $shop->theme_check = 1;
            $shop->save();
            if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                  $theme_count = StoreThemes::where('shopify_theme_id', $upload_theme_response['id'])->where('status',1)->count();
            }else{
                 $theme_count = StoreThemes::where('shopify_theme_id', $upload_theme_response['id'])->where('status',1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();
            }
            if($theme_count == 0){
                $StoreTheme = new StoreThemes;
                $StoreTheme->shopify_theme_id = $upload_theme_response['id'];
                $StoreTheme->shopify_theme_name = $upload_theme_response['name'];
                $StoreTheme->role = 0;
                $StoreTheme->status = 1;
                $StoreTheme->user_id = $shop->id;
                $StoreTheme->version = $latest_theme->version;
                if(isset($latest_theme->is_beta_theme) && $latest_theme->is_beta_theme == 1 ){
                    $StoreTheme->is_beta_theme = 1;
                }else{
                    $StoreTheme->is_beta_theme = 0;
                }
                $StoreTheme->save();
            }

            $redirectThemes = 0;

            if($latest_theme->is_beta_theme == 1 || $latest_theme->version != '2.0.2')
            {
              $redirectThemes = 1;
            }

            $is_theme_processing = $upload_theme_response['processing'];
            if( !$is_theme_processing ){
                return response()->json([
                    'status' => 'ok',
                    'message' => 'Theme added',
                    'is_beta_theme' => $redirectThemes
                ]);
            }else{
                do {
                    $is_theme_processing = $this->getThemeProcessing($upload_theme_response['id']);
                    sleep(2);   //wait for 5 sec for next function call
                    if( !$is_theme_processing ){
                        return response()->json([
                            'status' => 'ok',
                            'message' => 'Theme added',
                            'is_beta_theme' => $redirectThemes
                        ]);
                    }

                } while($is_theme_processing === TRUE);
            }
        }
        else{
            try{
                $message = "";
                $shopify_themes = $shop->api()->request(
                      'GET',
                      '/admin/api/themes.json'
                )['body']['themes'];
                $theme_count = count($shopify_themes);
                if($theme_count >= 20){
                    $message = 'Your online store has a maximum of 20 themes. Remove unused themes to add more.';
                }else{
                    $message = 'Error Occurred. Please try again';
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('getting themes throws client exception');
            }
            catch(\Exception $e){
                    logger('getting themes throws exception');
            }

            $request->session()->flash('error', $message);
            return response()->json([
                'status' => 'error',
                'message' => $message
            ]);
        }
    }

    // is theme completely download or procesing
    public function getThemeProcessing($theme_id){
        $shop = Auth::user();
        $this->fetchInitialData();
        $endPoint = '/admin/api/themes/'. $theme_id .'.json';
        try{
            $is_theme_processing  = $shop->api()->request('GET', $endPoint )['body']['theme'];
        }
        catch (\Exception $e) {
            $is_theme_processing = $e->getMessage();
        }
        return $is_theme_processing['processing'];
    }

    // get license key function
    public function getLicenseKey(Request $request){
        $this->fetchInitialData();
        $shopDomain = $request->shopDomain;
        if(empty($shopDomain)){
            return response()->json([
                    'status' => 'shop domain empty',
                    'license_key' => 'empty'
            ]);
        } else {
            $shop = User::whereNotNull('password')->where('name', $shopDomain)->first();
            if(empty($shop)){
                 return response()->json([
                    'status' => 'uninstalled',
                    'license_key' => 'empty'
                ]);
            }
            else{
                //logger('its here='.$shop->license_key);
                return response()->json([
                    'status' => 'ok',
                    'license_key' => $shop->license_key
                ]);
            }
        }
    }

    // free subscription
    public function free_subscription(Request $request){
      // die("here");
        $data =[];
        $newdate_anchor = "";
        $next_month_date = strtotime("next Month");
        $shop = Auth::user();
        $plan_name = $shop->alladdons_plan;
        $sub_plan = $shop->sub_plan;
        $this->fetchInitialData();
        $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
        $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

        if ($sub_plan == 'month') {
          $discount = 100;
          $coupon_id = "ONEMONTHFREECANCEl";
        } else if($sub_plan == 'Quarterly') {
          $discount = 20;
          $coupon_id = "ONEQUARTERFREECANCEl";
        } else {
          $discount = 20;
          $coupon_id = "20OFFNEXTYEARCANCEl";
        }

        $coupon = \Stripe\Coupon::create([
          'duration' => 'once',
          'percent_off' => $discount,
          'max_redemptions'=>1,
          'id' => $coupon_id.Str::random(12),
        ]);
        if(isset($coupon->id)){
          $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                    'coupon' => $coupon->id,
                  ]);
        }
        $upcoming_invoice = \Stripe\Invoice::upcoming(["customer" => $shop->stripe_id]);

        if(isset($upcoming_invoice->date) && !empty($upcoming_invoice->date)){
            $newdate_anchor = strtotime ( '+30 days' , $upcoming_invoice->date );

        }

        $newdate = strtotime (date("Y-m-d", strtotime("+30 days")));

        if(isset($sub->id) && !empty($sub->id) && isset($sub->billing_cycle_anchor)){
          $shop->has_taken_free_subscription = 1;
          $shop->save();
          $contact = $this->activeCampaign->sync([
            'email' => $shop->email,
            'fieldValues' => [
              ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $plan_name]
            ]
          ]);
          $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_MONTH_FREE);
        }
         return redirect()->route('goodbye',['subscription' => 'free','billing_cycle' => $newdate_anchor]);
    }

    //pause subscription
    public function pause_subscription(Request $request){
          $shop = Auth::user();
          $plan_name = $shop->alladdons_plan;
          $sub_plan = $shop->sub_plan;
          $data =[];
          $next_month_date = strtotime("next Month");
          $this->fetchInitialData();

          if($shop->is_paused != true){
              $mainSub = $shop->mainSubscription;
              if($mainSub->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE){
                  $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
                  $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);
                  if(isset($subscription->stripe_id) && !empty($subscription->stripe_id)){
                      $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                          'pause_collection' => [
                              'behavior' => 'mark_uncollectible',
                          ],
                      ]);
                      if(isset($sub->id) && !empty($sub->id) && isset($sub->billing_cycle_anchor)){

                          $shop->is_paused = 1;
                          $data_pause = ['plan_name' => $plan_name, 'sub_plan' => $sub_plan];
                          $shop->pause_subscription =  serialize($data_pause);
                          $shop->alladdons_plan = "Freemium";
                          $shop->save();
                          if($shop->script_tags){
                              //logger('deleteScriptTagCurl called on cancel subscription');
                              deleteScriptTagCurl($shop);
                          }


                          $this->pause_all_addon($shop, 'master');
                          $contact = $this->activeCampaign->sync([
                              'email' => $shop->email,
                              'fieldValues' => [
                                  ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $plan_name]
                              ]
                          ]);
                          $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);

                      }
                  }
              }
              if($mainSub->payment_platform==MainSubscription::PAYMENT_PLATFORM_PAYPAL){
                  $subscription = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_status','ACTIVE')->orderBy('id', 'desc')->first();
                  $subsription_paypal_id = $subscription->paypal_id;
                  $subscription_paypal = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subsription_paypal_id}"))->json();
//                  if(isset($subscription->paypal_id) && !empty($subscription->paypal_id)){
                  if($subscription_paypal['status']=='ACTIVE'){
                      $pauseSubscriptionResponse = getPaypalHttpClient()
                          ->withBody('{"reason":"Customer Requested Pausing Current Subscription"}','application/json')
                          ->post(getPaypalUrl("v1/billing/subscriptions/${subsription_paypal_id}/suspend"))->status();
                      if($pauseSubscriptionResponse==204){


                          SubscriptionPaypal::where('paypal_id',$subsription_paypal_id)->update(['paypal_status' => 'SUSPENDED']);
                          $shop->is_paused = 1;
                          $data_pause = ['plan_name' => $plan_name, 'sub_plan' => $sub_plan];
                          $shop->pause_subscription =  serialize($data_pause);
                          $shop->alladdons_plan = "Freemium";
                          $shop->save();

                          if($shop->script_tags){
                              //logger('deleteScriptTagCurl called on cancel subscription');
                              deleteScriptTagCurl($shop);
                          }

                          $this->pause_all_addon($shop, 'master');

                          $contact = $this->activeCampaign->sync([
                              'email' => $shop->email,
                              'fieldValues' => [
                                  ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $plan_name]
                              ]
                          ]);
                          $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);
                       }
                  }
          }
              return redirect()->route('goodbye',['subscription' => 'paused','alladdons_plan' => $plan_name]);

          }else{
              return redirect()->route('home');

          }
    }

    public function unpause_subscription(Request $request){
                $shop = Auth::user();
                $plan = unserialize($shop->pause_subscription);
                $this->fetchInitialData();
                $mainSub = $shop->mainSubscription;
                if($mainSub->payment_platform==MainSubscription::PAYMENT_PLATFORM_STRIPE){
                    $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
                    if(isset($subscription->stripe_id) && !empty($subscription->stripe_id)){
                        $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                            'pause_collection' => '',
                        ]);
                        if(isset($sub->id) && !empty($sub->id)){

                            $shop->all_addons = 1;
                            $shop->alladdons_plan = $plan['plan_name'];
                            $license_key = Hash::make(Str::random(12));
                            $shop->license_key = $license_key;
                            $shop->is_paused = 0;
                            $shop->pause_subscription = null;
                            $shop->save();
                            $this->unpause_all_addon($shop, 'master');

                            $contact = $this->activeCampaign->sync([
                                'email' => $shop->email,
                                'fieldValues' => [
                                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $plan['plan_name']]
                                ]
                            ]);
                            $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);

                            if ($contactTag) {
                                $untag = $this->activeCampaign->untag($contactTag['id']);
                            }

                        }
                }

                Session::flash('unpause_subscription', 'Thank you! Your '.$plan['plan_name'].' Plan has been unpaused.');

                }
                if($mainSub->payment_platform==MainSubscription::PAYMENT_PLATFORM_PAYPAL){
                    logger('paypal subscription resume started');
                    $subscription = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_status','SUSPENDED')->orderBy('id', 'desc')->first();
                    $subscription_paypal_id = $subscription->paypal_id;
                    logger('subscription_paypal_id is '.$subscription_paypal_id);
                    $subscription_paypal = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subscription_paypal_id}"))->json();
                    logger('subscription_paypal is '.json_encode($subscription_paypal));

                    if($subscription_paypal['status']=='SUSPENDED'){
                        $pauseSubscriptionResponse = getPaypalHttpClient()
                            ->withBody('{"reason":"Customer Requested Reactivating Subscription"}','application/json')
                            ->post(getPaypalUrl("v1/billing/subscriptions/${subscription_paypal_id}/activate"))->status();
                        logger('pauseSubscriptionResponse is '.json_encode($pauseSubscriptionResponse));

                        if($pauseSubscriptionResponse==204){
                            SubscriptionPaypal::where('paypal_id',$subscription_paypal_id)->update(['paypal_status'=>'ACTIVE']);

                            $shop->all_addons = 1;
                            $shop->alladdons_plan = $plan['plan_name'];
                            $license_key = Hash::make(Str::random(12));
                            $shop->license_key = $license_key;
                            $shop->is_paused = 0;
                            $shop->pause_subscription = null;
                            $shop->save();
                            $this->unpause_all_addon($shop, 'master');
                            $contact = $this->activeCampaign->sync([
                                'email' => $shop->email,
                                'fieldValues' => [
                                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $plan['plan_name']]
                                ]
                            ]);
                            $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);

                            if ($contactTag) {
                                $untag = $this->activeCampaign->untag($contactTag['id']);
                            }
                        }
                        Session::flash('unpause_subscription', 'Thank you! Your '.$plan['plan_name'].' Plan has been unpaused.');
                    }
                }
                return redirect()->route('plans');


    }

    // subscription function
    public function all_subscription(Request $request, StripePlan $plan){

        $thank_you_data = array(
            'tracking' => '',
            'amount' => '',
            'subscription_id' => '',
            'plan_id' => '',
            'revenue' => '',
            'tax' => '',
            'alladdons_plan' => '',
            'sub_plan' => '',
            'coupon' => '',
        );
        $shop = Auth::user();
        $this->fetchInitialData();
        logger('all subscription shop='.$shop->name);
        Session::put('tax_user_id', $shop->id);
        // die();
        $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
        )['body']['shop'];
        $tax_rates = array();
        if($shopData['country_name'] == 'Canada'){
          logger('domain='.$shop->name.', province='.$shopData['province']);
          // $tax_id = getTaxId($shopData->province);
          $tax = Taxes::where('region',$shopData['province'])->first();
          if($tax){
            $tax_id = $tax->stripe_taxid;
          }else{
            $tax = Taxes::where('region','New-Brunswick')->first();
            $tax_id = $tax->stripe_taxid;
          }
          logger('returning tax='.$tax_id);
          $tax_rates[] = $tax_id;
        }

        // address for stripe
        $address = array('line1' => $shopData['address1'], 'city' => $shopData['city'], 'country' => $shopData['country_name'], 'line2' => $shopData['address2'], 'postal_code' => $shopData['zip'], 'state' => $shopData['province']);
        $theme_count = StoreThemes::where('user_id', $shop->id)->where('status',1)->count();
        $isBrandNewSubscription = false;

            try{
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                // cancel a subscription if already Created
                if($shop->all_addons == 1){

                    // Remove Child Store onchange master store plans
                    if($shop->alladdons_plan == 'Master' && $request->get('payment_cycle') != 'Master'){
                        $shop->master_account = null;
                        $store_count = ChildStore::where('user_id', $shop->id)->count();
                        if($store_count > 0){
                            $child_stores = ChildStore::where('user_id', $shop->id)->get();
                            foreach ($child_stores as $key => $child_store) {
                                $shops = User::where('name', $child_store->store)->first();
                                if($shops){
                                    $this->delete_all_addon($shops, 'child');
                                }
                            }
                            $child_store_d = ChildStore::where('user_id', $shop->id)->delete();
                        }
                    }
                    // subscription update
                    $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
                  $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                            'trial_end' => 'now',
                          ]);

                    // Delete Discount code on upgrade/downgrade
                    $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);
                    if($sub->discount){
                        $deleteDiscount = $sub->deleteDiscount();
                    }
                    $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

                    // See what the next invoice would look like with a plan switch
                    // upgrade/downgrade subscription

                    if( $coupon = $request->get('new_coupon')) {
                        $update_subscription = \Stripe\Subscription::update($subscription->stripe_id, [
                            'coupon' => $request->get('new_coupon'),
                            'cancel_at_period_end' => null,
                            'proration_behavior' => "always_invoice",
                            'items' => [
                                [
                                    'id' => $subscription_stripe->items->data[0]->id,
                                    'plan' => $request->get('plan_id'),
                                ],
                            ],
                            'default_tax_rates' => $tax_rates,
                        ]);
                    }else{
                        $update_subscription = \Stripe\Subscription::update($subscription->stripe_id, [
                            'cancel_at_period_end' => false,
                            'proration_behavior' => "always_invoice",
                            'items' => [
                                [
                                    'id' => $subscription_stripe->items->data[0]->id,
                                    'plan' => $request->get('plan_id'),
                                ],
                            ],
                            'default_tax_rates' => $tax_rates,
                        ]);
                    }

                    $sub = \Stripe\Invoice::retrieve($update_subscription->latest_invoice);
                    $total_bill = $sub->total;
                    $total_tax = empty($sub->tax) ? 0 : $sub->tax;
                    $total_amount = $total_bill - $total_tax;
                    $revenue = $total_bill + $total_tax;

                    $thank_you_data = array(
                        'tracking' => $update_subscription->latest_invoice,
                        'amount' => $total_amount,
                        'subscription_id' => $subscription->stripe_id,
                        'plan_id' => $request->get('plan_id'),
                        'revenue' => $revenue,
                        'tax' => $total_tax,
                        'alladdons_plan' => $request->get('payment_cycle'),
                        'sub_plan' => $request->sub_plan,
                        'coupon' => $request->get('new_coupon'),
                    );
                    MainSubscription::where('user_id',$shop->id)->update(['payment_platform'=>'stripe','stripe_customer_id'=>$update_subscription->customer]);
                    logger('subscription updated='.json_encode($update_subscription));
                }
                else{
                    $isBrandNewSubscription = true;
                    if($shop->stripe_id == '' || $shop->stripe_id == null){
                        logger('create new customer on stripe, email='.$request->get('email'));
                        $customer = \Stripe\Customer::create([
                            'source' => $request->stripeToken,
                            'email' => $request->get('email'),
                            'description' => $shop->name,
                            'name' => $shopData['shop_owner'],
                            'address' => $address,
                            'phone' => $shopData['phone'],
                        ]);
                    }else{
                        logger('update existing customer on stripe');
                        $customer = \Stripe\Customer::update(
                            $shop->stripe_id,
                            [
                                'email' => $request->get('email'),
                                'description' => $shop->name,
                                'name' => $shopData['shop_owner'],
                                'address' => $address,
                                'phone' => $shopData['phone'],
                            ]
                        );
                    }
//                logger('customer created='.json_encode($customer));
                    $shop->stripe_id = $customer->id;
                    if( $coupon = $request->get('new_coupon') ) {
                        $subscription_created = \Stripe\Subscription::create([
                            'customer' => $shop->stripe_id,
                            'coupon' => $coupon,
                            'items' => [['plan' => $request->get('plan_id')]],
                            'metadata' => ['lm_data' => $request->linkminkRef],
                            'default_tax_rates' => $tax_rates,
                        ]);
                    }
                    else{
                        $subscription_created = \Stripe\Subscription::create([
                            'customer' => $shop->stripe_id,
                            'items' => [['plan' => $request->get('plan_id')]],
                            'metadata' => ['lm_data' => $request->linkminkRef],
                            'default_tax_rates' => $tax_rates,
                        ]);
                    }


                    $sub = \Stripe\Invoice::retrieve($subscription_created->latest_invoice);
                    $total_bill = $sub->total;
                    $total_tax = empty($sub->tax) ? 0 : $sub->tax;
                    $total_amount = $total_bill - $total_tax;
                    $revenue = $total_bill + $total_tax;

                    $thank_you_data = array(
                        'tracking' => $subscription_created->latest_invoice,
                        'amount' => $total_amount,
                        'subscription_id' => $subscription_created->id,
                        'plan_id' => $request->get('plan_id'),
                        'revenue' => $revenue,
                        'tax' => $total_tax,
                        'alladdons_plan' => $request->get('payment_cycle'),
                        'sub_plan' => $request->sub_plan,
                        'coupon' => $request->get('new_coupon'),
                    );

                    logger('subscription created='.json_encode($subscription_created));
                    $subscription = new SubscriptionStripe;
                    $subscription->user_id = $shop->id;
                    $subscription->name = 'main';
                    $subscription->stripe_id = $subscription_created->id;
                    $subscription->stripe_plan = $request->get('plan_id');
                    $subscription->stripe_status = $subscription_created->status;
                    $subscription->quantity = 1;
                    $subscription->save();

//                    MainSubscription::where('user_id',$shop->id)->update(['payment_platform'=>'stripe','stripe_customer_id'=>$subscription_created->customer]);
                    MainSubscription::updateOrCreate(['user_id'=>$shop->id],['payment_platform'=>'stripe','stripe_customer_id'=>$subscription_created->customer]);
                    logger('subscription saved');
                }

            // Create new subscription
            $shop->sub_trial_ends_at = 0;
            $shop->trial_days = 0;
            $shop_owner = $shopData['shop_owner'];
            $shop_owner_name = explode(" ", $shop_owner);
            // Active campain
            try {
                $contact = $this->activeCampaign->sync([
                  'email' => $shop->email,
                  'fieldValues' => [
                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $request->get('payment_cycle')]
                  ]
                ]);
                $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);

                if ($contactTag) {
                  $untag = $this->activeCampaign->untag($contactTag['id']);
                }
            } catch(Exception $e) {
                $e->getMessage();
            }

            $this->setPlanActionTag($shop, $request);
        }
        catch(\Stripe\Exception\CardException $e) {
            logger("Since it's a decline, \Stripe\Error\Card will be caught");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $request->session()->flash('error', $err['message']);
            return redirect()->route('theme_addons');
        } catch (\Stripe\Exception\RateLimitException $e) {
            logger("Too many requests made to the API too quickly");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $request->session()->flash('error', $err['message']);
            return redirect()->route('theme_addons');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            logger("Invalid parameters were supplied to Stripe's API, error=".$err['message']);
            $request->session()->flash('error', $err['message']);
            return redirect()->route('theme_addons');
        } catch (\Stripe\Exception\AuthenticationException $e) {
            logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $request->session()->flash('error', $err['message']);
            return redirect()->route('theme_addons');
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            logger("Network communication with Stripe failed");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $request->session()->flash('error', $err['message']);
            return redirect()->route('theme_addons');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            logger("Display a very generic error to the user, and maybe send yourself an email");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            $request->session()->flash('error', $err['message']);
            return redirect()->route('theme_addons');
        } catch (Exception $e) {
            $body = $e->getMessage();
            logger("Something else happened, completely unrelated to Stripe: " . $body);

            $request->session()->flash('error', $body);
            return redirect()->route('plans');
        }

        // echo "sub_plan=".$request->get('sub_plan');
        $shop->all_addons = 1;
        $shop->alladdons_plan = $request->get('payment_cycle');
        $shop->sub_plan = $request->get('sub_plan');
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

        $contact = $this->activeCampaign->sync([
          'email' => $shop->email,
          'fieldValues' => [
            ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $shop->alladdons_plan]
          ]
        ]);
        $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_MONTH_FREE);

        if ($contactTag) {
          $untag = $this->activeCampaign->untag($contactTag['id']);
        }

        if ($isBrandNewSubscription) {
            $request->session()->flash('isBrandNewSubscription', $isBrandNewSubscription);
        }

        if($request->get('payment_cycle') == 'master'){
            $request->session()->flash('subscription', 'Master');
        }
        elseif($request->get('payment_cycle') == 'hustler'){
            $request->session()->flash('subscription', 'Hustler');
        }
        else{
            $request->session()->flash('subscription', 'Starter');
        }

        $request->session()->flash('status', 'Subscription activated');

        $request->session()->flash('thank_you_data', $thank_you_data);

        // if($theme_count <= 0){
        //   $urls = 'theme_view';
        // } else{
          $urls = 'thankyou';
        // }

        \Cookie::forget('discount-code');

        return redirect()->route($urls);
    }

    // update credit card function
    public function updateCreditCard(Request $request, StripePlan $plan){
        $shop = Auth::user();
        $this->fetchInitialData();

        $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
        )['body']['shop'];

        $address = array('line1' => $shopData['address1'], 'city' => $shopData['city'], 'country' => $shopData['country_name'], 'line2' => $shopData['address2'], 'postal_code' => $shopData['zip'], 'state' => $shopData['province']);
        if(MainSubscription::PAYMENT_PLATFORM_STRIPE){
            try{
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                if($shop->stripe_id == '' || $shop->stripe_id == null){
                    logger('create new customer on stripe, email='.$request->get('email'));
                    $customer = \Stripe\Customer::create([
                        'source' => $request->stripeToken,
                        'email' => $request->get('email'),
                        'description' => $shop->name,
                        'name' => $shopData['shop_owner'],
                        'address' => $address,
                        'phone' => $shopData['phone'],
                    ]);

                    $shop->stripe_id = $customer->id;
                    $shop->save();
                }else{
                    $customer = \Stripe\Customer::update(
                        $shop->stripe_id,
                        ["source" => $request->stripeToken]
                    );
                }
                return response(['message' => "Payment Method Updated Successfully."]);
            }
            catch(\Stripe\Exception\CardException $e) {
                logger("Since it's a decline, \Stripe\Error\Card will be caught");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return response(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\RateLimitException $e) {
                logger("Too many requests made to the API too quickly");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return response(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                logger("Invalid parameters were supplied to Stripe's API");
                $body = $e->getJsonBody();
                $err  = $body['error'];

                $request->session()->flash('error', $err['message']);
                return response(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\AuthenticationException $e) {
                logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                $body = $e->getJsonBody();
                $err  = $body['error'];

                $request->session()->flash('error', $err['message']);
                return response(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                logger("Network communication with Stripe failed");
                $body = $e->getJsonBody();
                $err  = $body['error'];

                $request->session()->flash('error', $err['message']);
                return response(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                logger("Display a very generic error to the user, and maybe send yourself an email");
                $body = $e->getJsonBody();
                $err  = $body['error'];

                $request->session()->flash('error', $err['message']);
                return response(['message' =>  $err['message']]);
            } catch (\Exception $e) {
                logger("Something else happened, completely unrelated to Stripe");
                $err  = $e->getMessage();
                $request->session()->flash('error', $err);
                return response(['message' =>  $err]);
            }
        }

    }

    // delete add-on function
    public function delete_addons(Request $request){
        $shop = Auth::user();
        $StoreThemes = [];
        $this->fetchInitialData();
        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }else{
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }

            if(!isset($StoreTheme) || empty($StoreTheme)){
                  $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();

            }

        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        $addon = AddOns::where('user_id', $shop->id)->where('global_id', $request->get('addon_id'))->first();
        foreach ($StoreTheme as $theme) {
            try{
            $get_theme = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
            )['body']['theme'];
               $StoreThemes[] = $theme;
            }catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on live view addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on live view addon throws exception');
            }
        }
        $addon_count = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
        $checkaddon = 0;
        if($addon_count <= 1)
        {
            $checkaddon =1;
        }else{
            $checkaddon = 0;
        }
        $addon->status = 0;
        $addon->shedule_time = 0;
        $addon->save();
        $update_addon= 0;
        $this->deactive_addons($shop,$StoreThemes,$request->get('addon_id'), $checkaddon, $update_addon);
        $request->session()->flash('status', 'Add-On uninstalled');
        return redirect()->route('theme_addons');
    }

    // install add-ons function
    public function install_addons(Request $request){
        $shop = Auth::user();
        $this->fetchInitialData();
        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        $addon_count = AddOns::where('user_id', $shop->id)->where('global_id', $request->get('addon_id'))->count();
          if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
          }else{
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->first();
          }

          if(!isset($StoreTheme) || empty($StoreTheme)){
               $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
            }

        if($addon_count==0){
            $addon = new AddOns;
            $addon->global_id = $request->get('addon_id');
            $addon->user_id = $shop->id;
            $addon->status = 1;
            $addon->shedule_time = 1;
            $addon->save();
        }else{
            $addon = AddOns::where('user_id', $shop->id)->where('global_id', $request->get('addon_id'))->first();
            $addon->status = 1;
            $addon->shedule_time = 1;
            $addon->save();
        }
        // save last activity in shop
        $shop->lastactivity = new DateTime();
        $shop->save();

        $update_addon = 0;
        $key = 0;
        $this->active_addons($request->get('addon_id'), $request->get('theme_id'),  $update_addon, $key);
        $request->session()->flash('status', 'Add-On installed');
        //****

        $global_add_ons = GlobalAddons::where('id', $request->get('addon_id'))->first();
        $request->session()->flash('message', 'You successfully installed '.$global_add_ons->title.' on '.$StoreTheme->shopify_theme_name);
        $request->session()->flash('theme_id_cstm', $request->get('theme_id'));
        //
        return redirect()->route('theme_addons');
    }

    public function cancel_all_subscription(Request $request, StripePlan $plan = null, $callFetchInitialData = true, $shop = null){
        if (!$shop) {
          $shop = Auth::user();
        }

        $plan = $shop->alladdons_plan;

        if ($callFetchInitialData) {
          $this->fetchInitialData();
        }

        if($shop && $shop->is_beta_tester == 1 ){
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }else{
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }

        if(!isset($StoreTheme) || empty($StoreTheme)){
            $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }

        if($shop->is_paused == true){
            $pause_plan_data = unserialize($shop->pause_subscription);
            if(isset($pause_plan_data['plan_name']) && !empty($pause_plan_data['plan_name'])){
              $plan = $pause_plan_data['plan_name'];
            }
        }else{
          $plan = $shop->alladdons_plan;
        }

        // Active campain
        try {
            $contact = $this->activeCampaign->sync([
              'email' => $shop->email,
              'fieldValues' => [
                ['field' => AC::FIELD_SUBSCRIPTION, 'value' => 'Freemium'],
                ['field' => AC::FIELD_THEME_BILLING, 'value' => null],
              ]
            ]);
            $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);
        } catch(Exception $e) {
            $e->getMessage();
        }


        if($plan == 'Master'){
            $shop->master_account = null;
            $store_count = ChildStore::where('user_id', $shop->id)->count();
            if($store_count > 0){
              $child_stores = ChildStore::where('user_id', $shop->id)->get();
              foreach ($child_stores as $key => $child_store) {
                $shops = User::where('name', $child_store->store)->first();
                if($shops){
                  $this->delete_all_addon($shops, 'child');
                }
              }
              $child_store_d = ChildStore::where('user_id', $shop->id)->delete();
            }
          }
        //delete shop addons from themes
        $this->delete_all_addon($shop, 'master');
        $mainSubscription = MainSubscription::where('user_id',$shop->id)->first();


        if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE){
            try{
            if($shop->script_tags){
              //logger('deleteScriptTagCurl called on cancel subscription');
              deleteScriptTagCurl($shop);
            }
                logger("cancel all stripe subscription");
                $stripeSubs = SubscriptionStripe::where('user_id',$shop->id)->where('stripe_status','active')->get();
                if($stripeSubs){
                    foreach ($stripeSubs as $singleStripeSub)
                    {
                        cancelStripeSubscription($singleStripeSub);
                    }
                }
                logger("cancel all stripe subscription completed");

                $shop->subscription('main')->cancelNow();
            }
            catch(Exception $e)
            {
                $e->getMessage();
            }

        }
        if(isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL)
        {
            logger('===Paypal sub cancellation started===');
            try{
                /*
                 * Allow active & suspended/paused subscription to cancel
                 */
                $paypalSubcription = SubscriptionPaypal::where('user_id', $shop->id)->activeOrSuspended()->first();

                if (optional($paypalSubcription)->paypal_status === SubscriptionPaypal::ACTIVE)
                {
                    if($shop->script_tags){
                      //logger('deleteScriptTagCurl called on cancel subscription');
                      deleteScriptTagCurl($shop);
                    }
                    $paypalSubcription = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_status','ACTIVE')->first();
                    logger('$paypalSubcription '.json_encode($paypalSubcription));
                    $sub_id = $paypalSubcription->paypal_id;

                    $paypalClient = "";
                    if(config('env-variables.PAYPAL_MODE')=='sandbox'){
                        $paypalClient = getPaypalAccessToken(config('env-variables.PAYPAL_SANDBOX_CLIENT_ID'),config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET'));
                    }
                    if((config('env-variables.PAYPAL_MODE')=='live')){
                        $paypalClient = getPaypalAccessToken(config('env-variables.PAYPAL_LIVE_CLIENT_ID'),config('env-variables.PAYPAL_LIVE_CLIENT_SECRET'));
                    }

                    $url = getPaypalUrl("v1/billing/subscriptions/${sub_id}/cancel");
                    logger('paypal response URL '.$url);
                    $shopcurl = curl_init();
                    curl_setopt($shopcurl, CURLOPT_URL, $url);
                    curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $paypalClient"));
                    curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
                    curl_setopt($shopcurl, CURLOPT_HEADER, 1);
                    curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($shopcurl, CURLOPT_POSTFIELDS,'{"reason": "Not satisfied with the service"}');
                    $response = curl_exec ($shopcurl);
                    $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
                    logger("Response from curl cancellation call ". json_encode($response));
                    curl_close ($shopcurl);

                    logger('paypal response status '.$paypalResponse);

                    if($paypalResponse == 204)
                    {
                        $paypalSubcription->paypal_status = 'CANCELLED';
                        $paypalSubcription->ends_at = null;
                        $paypalSubcription->save();

                        $shop->is_paused = 0;
                        $shop->pause_subscription = null;
                        $shop->save();
                        logger('$paypalSubcription '.json_encode($paypalSubcription));
                    }
                }
                elseif (optional($paypalSubcription)->paypal_status === SubscriptionPaypal::SUSPENDED)
                {
                    $paypalSubcription->paypal_status = 'CANCELLED';
                    $paypalSubcription->ends_at = null;
                    $paypalSubcription->save();

                    $shop->is_paused = 0;
                    $shop->pause_subscription = null;
                    $shop->save();
                    logger('$paypalSubcription ' . json_encode($paypalSubcription));
                }
            }
            catch(Exception $e)
            {
                logger ('error '.$e->getMessage());
                $e->getMessage();
            }
            logger('===Paypal sub cancellation ended===');

        }

        \Cookie::queue(\Cookie::forget('discount-code'));
        $request->session()->flash('status', 'Subscription canceled');
        //return redirect()->route('theme_addons');

        return redirect()->route('goodbye',['subscription' => 'cancellation','alladdons_plan' => $plan]);
    }

    // install all add-ons function
    public function install_All_addons(Request $request){
        $shop = Auth::user();
        $this->fetchInitialData();

        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
            }else{
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->first();
            }

            if(!isset($StoreTheme) || empty($StoreTheme)){
                  $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
            }
      //  $activated_addons = AddOns::where('user_id', $shop->id)->where('status', 0)->get();
       // $global_add_ons_count = GlobalAddons::count();
       // $addons_count = AddOns::where('user_id', $shop->id)->count();
       // $delivery_addon_activated = AddOns::where('user_id',$shop->id)->where('global_id', 4)->where('status',1)->count();
       // $user_id = $shop->id;
        $checkaddon = 0;
       // $global_add_ons = GlobalAddons::pluck('id')->toArray();
       // $diff_addons=array_diff($global_add_ons,$request->get('addons'));
       // logger(json_encode($diff_addons));
         $update_addon =0;
         //$addons_name = array();
            /* save in store */
            if(is_array($request->get('addons'))) {
                foreach ($request->get('addons') as $key => $mltaddons) {
                  sleep(1);
                  $this->active_addons($mltaddons, $request->get('theme_id'),  $update_addon, $key);
                }
            }
            // foreach ($diff_addons as $key => $mltaddons) {
            //   sleep(1);
            //   $this->deactive_addons($shop,$StoreTheme,$mltaddons, $checkaddon, $update_addon, $key);
            // }
            // if($addons_count== $global_add_ons_count){
            //     foreach ($activated_addons as $key=> $addon) {
            //         $this->active_addons($addon->global_id, $request->get('theme_id'),  $update_addon, $key);
            //         $addons_name = array($addon->global_id);
            //     }
            // }else{
            //     foreach ($global_add_ons as $key=> $global) {
            //         $this->active_addons($global->id, $request->get('theme_id'), $update_addon, $key);
            //         $addons_name = array($global->id);
            //     }
            // }
            /* save in database */

            $shop->lastactivity = new DateTime();
            $shop->save();
            if(is_array($request->get('addons'))) {
                foreach ($request->get('addons') as $global) {
                  $addon_count = AddOns::where('user_id', $shop->id)->where('global_id', $global)->count();
                  if($addon_count == 0){
                      $addon = new AddOns;
                      $addon->global_id = $global;
                      $addon->user_id = $shop->id;
                      $addon->status = 1;
                      $addon->shedule_time = 1;
                      $addon->invoiceitem = null;
                      $addon->save();
                  }else{
                    $addon = AddOns::where('user_id', $shop->id)->where('global_id', $global)->first();
                    $addon->status = 1;
                    $addon->shedule_time = 1;
                    $addon->invoiceitem = null;
                    $addon->save();
                  }
                }
            }
            $request->session()->flash('status', 'All Add-Ons installed');
            //$global_add_ons = GlobalAddons::where('id', $request->get('addon_id'))->first();
            $request->session()->flash('message', 'You successfully installed all Add-Ons on '.$StoreTheme->shopify_theme_name);
            $request->session()->flash('theme_id_cstm', $request->get('theme_id'));
            return redirect()->route('theme_addons');
    }

    // update add-on function
    public function update_addons(Request $request){
        $shop = Auth::user();
        $StoreThemes = [];
        $this->fetchInitialData();
        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();

        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();
        }else{
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }

            if(!isset($StoreTheme) || empty($StoreTheme)){
                 $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();
            }

        $delivery_addon_activated = AddOns::where('user_id',$shop->id)->where('global_id', 4)->where('status',1)->count();
        foreach ($StoreTheme as $theme) {
                try{
                $get_theme = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
                )['body']['theme'];
                   $StoreThemes[] = $theme;
                }catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('update schema on live view addon throws client exception');
                }
                catch(\Exception $e){
                    logger('update schema on live view addon throws exception');
                }
            }
        // save last activity in shop
        $shop->lastactivity = new DateTime();
        $shop->save();

        $checkaddon = 0;
        $update_addon = 1;
        $key = 0;
        $this->deactive_addons($shop,$StoreThemes,$request->get('addon_id'), $checkaddon, $update_addon);
        sleep(3);
        $this->active_addons($request->get('addon_id'),$request->get('theme_id'),  $update_addon, $key);
        $request->session()->flash('status', 'Add-On updated');
        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
        }else{
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->first();
        }

        if(!isset($StoreTheme) || empty($StoreTheme)){
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();
        }
        $global_add_ons = GlobalAddons::where('id', $request->get('addon_id'))->first();
      $request->session()->flash('message', 'You successfully updated '.$global_add_ons->title.' on '.$StoreTheme->shopify_theme_name);
      $request->session()->flash('theme_id_cstm', $request->get('theme_id'));
         return redirect()->route('theme_addons');
    }

    // cancel subscription function
    public function cancel_subscription(Request $request){
        $shop = Auth::user();
        $StoreThemes = [];
        $this->fetchInitialData();
        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }else{
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }
        if(!isset($StoreTheme) || empty($StoreTheme)){
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }
        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        foreach ($StoreTheme as $theme) {
                try{
                $get_theme = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
                )['body']['theme'];
                   $StoreThemes[] = $theme;
                }catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('update schema on live view addon throws client exception');
                }
                catch(\Exception $e){
                    logger('update schema on live view addon throws exception');
                }
            }
        $addon = AddOns::where('user_id', $shop->id)->where('global_id', $request->get('addon_id'))->first();
        $globaladdon = GlobalAddons::where('id', $request->get('addon_id'))->first();
        if($addon && $globaladdon){
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            //  \Stripe\Stripe::setApiVersion("2019-05-16");
            $subscription = \Stripe\Subscription::all(['limit' => 1]);
            $date = new DateTime();
            $date->setTimestamp($subscription->data[0]['billing_cycle_anchor']);
            $new_format = $date->format('d');
            $invoice_id =$addon->invoiceitem;
            logger(json_encode($invoice_id));
            $price =  $globaladdon->price/100;
            $dt = new DateTime();
            $day = $dt->format('d');
            $totaldays = '';
            if($day < $new_format)
            {
                $totaldays= $day + 7;
            }
            else{
                $totaldays = $new_format - $day;
                $totaldays = $totaldays * -1;
            }
            $checkaddon = 0;
            $total = ($price/30)*($totaldays);
            $amount1 =number_format($total, 2);
            $amount = $amount1* 100;

            $addon->status = 0;
            $addon->shedule_time = 0;
            $addon->save();

            $addon_count = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
            try{
                if($addon_count < 1)
                {
                    // Check if Last addons activated
                    $checkaddon = 1;
                    $shop->license_key = null;

                if($shop->script_tags){
                  deleteScriptTagCurl($shop);
                }

                $shop->alladdons_plan = 'Freemium';
                $shop->save();

                $contact = $this->activeCampaign->sync([
                  'email' => $shop->email,
                  'fieldValues' => [
                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => 'Freemium']
                  ]
                ]);
                $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);
            }
            else{
                // Check if more than one addons activated
                $checkaddon = 0;
           }

            }catch(\Stripe\Exception\CardException $e) {
                logger("Since it's a decline, \Stripe\Error\Card will be caught");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\RateLimitException $e) {
                logger("Too many requests made to the API too quickly");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                logger("Invalid parameters were supplied to Stripe's API");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\AuthenticationException $e) {
                logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                logger("Network communication with Stripe failed");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Stripe\Exception\ApiErrorException $e) {
                logger("Display a very generic error to the user, and maybe send yourself an email");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->session()->flash('error', $err['message']);
                return redirect()->route('theme_addons');
            } catch (\Exception $e) {
                logger("Something else happened, completely unrelated to Stripe");
                $err  = $e->getMessage();
                $request->session()->flash('error', $err);
                return redirect()->route('theme_addons');
            }
            $update_addon= 0;
            $this->deactive_addons($shop,$StoreThemes,$request->get('addon_id'), $checkaddon, $update_addon);
            $request->session()->flash('status', 'Add-On uninstalled');
        }

        return redirect()->route('theme_addons');
    }

    // mailerLite function
    public function mailerLite($shop, $subs){
      //$groupsApi = (new \MailerLiteApi\MailerLite(env('MAILERLITE_APIKEY')))->groups();
      // print($shopData->email);
      //$groupId = env('MAILERLITE_GROUP_ID');
      // if($subs == 'trial'){
      //     $subscriber = [
      //       'email' => $shop->email,
      //       'fields' => [
      //           'subscription' => $subs,
      //           'status' => 'active'
      //        ]
      //     ];
      // } else{
      //   $subscriber = [
      //      'email' => $shop->email,
      //      'fields' => [
      //          'subscription' => 'Freemium',
      //          'status' => 'active'
      //      ]
      //   ];
      // }

      // Active campain
      // if($subs == 'trial'){
      //   $subscriber ='Trial';
      // }else{
      //   $subscriber ='Freemium';
      // }
      //$addedSubscriber = $groupsApi->addSubscriber($groupId, $subscriber);
     // logger(json_encode($addedSubscriber));
    }

    // update all add-ons function
    public function update_Active_addons(Request $request){
        $shop = Auth::user();
        $this->fetchInitialData();
        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();
        if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();
        }else{
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }

            if(!isset($StoreTheme) || empty($StoreTheme)){
                $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->where('status', 1)->get();

            }
        // $StoreThemes =[];
        // foreach ($StoreTheme as $theme) {
        //     try{
        //     $get_theme = $shop->api()->request(
        //           'GET',
        //           '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
        //     )['body']['theme'];
        //        $StoreThemes[] = $theme;
        //     }catch(\GuzzleHttp\Exception\ClientException $e){
        //         logger('update schema on live view addon throws client exception');
        //     }
        //     catch(\Exception $e){
        //         logger('update schema on live view addon throws exception');
        //     }
        // }
       // $activated_addons = AddOns::where('user_id', $shop->id)->where('status', 1)->get();

        // save last activity in shop
        $shop->lastactivity = new DateTime();
        $shop->save();

        if($StoreTheme){
          $checkaddon = 0;
          $update_addon= 1;
          if(is_array($request->get('addons'))) {
              foreach ($request->get('addons') as $key => $mltaddons) {
                $this->deactive_addons($shop,$StoreTheme,$mltaddons, $checkaddon, $update_addon, $key);
              }
              sleep(1);
              foreach ($request->get('addons') as $key => $mltaddons) {
                $this->active_addons($mltaddons, $request->get('theme_id'),  $update_addon, $key);
              }
          }
        }
        // foreach ($activated_addons as $key=>$addon) {
          //    $this->deactive_addons($shop,$StoreThemes,$addon->global_id, $checkaddon, $update_addon, $key);
          // }
        //sleep(3);
        // foreach ($activated_addons as $key=>$addon) {
        //     $this->active_addons($addon->global_id, $request->get('theme_id'),  $update_addon, $key);
        //     $global_add_ons = GlobalAddons::where('id', $addon->global_id)->first();
        //     $addon_name[] = $global_add_ons->title;
        // }
        $request->session()->flash('status', 'All Add-Ons updated');

      // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $request->get('theme_id'))->first();
        //$name_string = implode(",",$addon_name);
        $request->session()->flash('theme_id_cstm', $request->get('theme_id'));
        $request->session()->flash('message', 'You successfully updated all Add-Ons on '.$StoreTheme[0]['shopify_theme_name']);

        return redirect()->route('theme_addons');
    }


    // theme refresh function
    public function get_theme_refresh(StripePlan $plan,Request $request){
        $shop = Auth::user();

        $this->get_theme_refresh_internal();

        $theme_count = StoreThemes::where('user_id', $shop->id)->where('status',1)->count();
        $request->session()->flash('status', 'Theme library refreshed');
        return redirect()->route('theme_view');
    }


    public function get_theme_refresh_internal(){
        $this->fetchInitialData();
        $shop = Auth::user();

        // $latest_theme = Themes::orderBy('id', 'desc')->first();
        $user_id = $shop->id;
        //get themes from store
        $get_all_themes = $shop->api()->request(
              'GET',
              '/admin/api/themes.json'
        )['body']['themes'];
        //logger(json_encode($get_all_themes));

        foreach ($get_all_themes as $get_all_theme) {
            $themes_count = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $get_all_theme->id)->count();
            if($themes_count == 0){
                try {
                    $schema = $shop->api()->request(
                        'GET',
                        '/admin/api/themes/'.$get_all_theme->id.'/assets.json',
                        ['asset' => ['key' => 'config/settings_schema.json'] ]
                    )['body']['asset']['value'];
                    //logger(json_encode($schema));
                    if( ( $pos = strrpos( $schema , 'debutify' ) ) !== false || ( $pos = strrpos( $schema , 'Debutify' ) ) !== false ) {

                        $json = json_decode($schema);
                        $version = isset($json[0]->theme_version) ? $json[0]->theme_version : '';

                        $StoreTheme = new StoreThemes;
                        $StoreTheme->shopify_theme_id = $get_all_theme->id;
                        $StoreTheme->shopify_theme_name = $get_all_theme->name;
                        $StoreTheme->role = ($get_all_theme->role == 'main') ? 1 : 0;
                        $StoreTheme->status = 1;
                        $StoreTheme->user_id = $shop->id;
                        if(( $pos = strrpos( $schema , '2.0.' ) ) !== false) {
                          $StoreTheme->is_beta_theme = 0;
                          $version = '2.0.2';
                        }
                        elseif(( $pos = strrpos( $schema , '3.0.' ) ) !== false)
                        {
                            $StoreTheme->is_beta_theme = 0;
                        }
                        if($version)
                        {
                            $StoreTheme->version = $version;
                        }
                        $StoreTheme->save();
                     }
                } catch(\GuzzleHttp\Exception\ClientException $e){
                  logger('theme created chron throws exception');
                }
            }
            else{
              try {
                    $schema = $shop->api()->request(
                        'GET',
                        '/admin/api/themes/'.$get_all_theme->id.'/assets.json',
                        ['asset' => ['key' => 'config/settings_schema.json'] ]
                    )['body']['asset']['value'];
                    //logger(json_encode($schema));
                    if( ( $pos = strrpos( $schema , 'debutify' ) ) !== false || ( $pos = strrpos( $schema , 'Debutify' ) ) !== false ) {

                       $json = json_decode($schema);
                        $version = isset($json[0]->theme_version) ? $json[0]->theme_version : '';

                      $debutify_theme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $get_all_theme->id)->first();
                      $debutify_theme->role = ($get_all_theme->role == 'main') ? 1 : 0;
                      $debutify_theme->status = 1;
                      $debutify_theme->shopify_theme_name = $get_all_theme->name;
                      if(( $pos = strrpos( $schema , '2.0.' ) ) !== false) {
                        $debutify_theme->is_beta_theme = 0;
                        $version = '2.0.2';
                      }
                      elseif(( $pos = strrpos( $schema , '3.0.' ) ) !== false)
                      {
                        $debutify_theme->is_beta_theme = 0;
                      }
                      if($version)
                      {
                        $debutify_theme->version = $version;
                      }
                      $debutify_theme->save();
                    }
                    else{
                      StoreThemes::where('shopify_theme_id', $get_all_theme->id)->delete();
                    }
                } catch(\GuzzleHttp\Exception\ClientException $e){
                  logger('theme created chron throws exception');
                }
            }
        }

        sleep(10);

        $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        foreach ($StoreTheme as $theme) {
            try{
                $get_theme = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
                )['body']['theme'];
               $StoreThemes[] = $theme;
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                $theme_updated = StoreThemes::where('shopify_theme_id', $theme->shopify_theme_id)->delete();
                if($shop->shopify_theme_id == $theme->id){
                    $shop->shopify_theme_id = null;
                    $shop->theme_id = null;
                    //$shop->theme_url = null;
                    $shop->save();
                }
                logger('theme not found on shopify store');
            }
            catch(\Exception $e){
                $theme_updated = StoreThemes::where('shopify_theme_id', $theme->shopify_theme_id)->delete();
                if($shop->shopify_theme_id == $theme->id){
                    $shop->shopify_theme_id = null;
                    $shop->theme_id = null;
                   // $shop->theme_url = null;
                    $shop->save();
                }
                logger('theme not found on shopify store');
            }
        }
    }

    // force update all add-ons function
    public function force_Update_Active_addons(Request $request){
        $shop = Auth::user();
        $this->fetchInitialData();

        $this->get_theme_refresh_internal();
            if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
            }else{
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
            }

            if(!isset($StoreThemes) || empty($StoreThemes)){
                $StoreThemes = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
            }

        no_addon_activate($StoreThemes, $shop);

        if( count( $StoreThemes ) > 0 ){
            // save last activity in shop
            $shop->lastactivity = new DateTime();
            $shop->save();
            $allAddons = AddOns::where('user_id', $shop->id)->where('status', 1)->get();

            foreach ( $StoreThemes as $skey=>$sval ){

                if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
                    $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $sval->shopify_theme_id)->where('status', 1)->get();

                }else{
                    $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $sval->shopify_theme_id)->where('status', 1)->where('is_beta_theme','!=',1)->get();
                }

                if($StoreTheme){
                    $checkaddon = 0;
                    $update_addon= 1;
                    foreach ($allAddons as $key => $mltaddons) {
                        $this->deactive_addons($shop,$StoreTheme,$mltaddons->global_id, $checkaddon, $update_addon);
                    }
                    sleep(5);
                    foreach ($allAddons as $key => $mltaddons) {
                      logger('add loop begins');
                      logger('$mltaddons->global_id: ' . $mltaddons->global_id);
                      logger('$sval->shopify_theme_id: ' . $sval->shopify_theme_id);
                      logger('$key: ' . $key );
                        $this->active_addons($mltaddons->global_id, $sval->shopify_theme_id,  $update_addon, $key);
                    }
                }
            }
        }

        $shop->is_updated_addon = 1;
        $shop->save();
        $request->session()->flash('status', 'Debutify Theme Manager Updated');
        $request->session()->flash('addons-updated', 'Addons Updated');

        return redirect()->route('theme_addons');
    }

    // add linked store function
    public function addchildstore(Request $request){
        $shop = Auth::user();
        $this->fetchInitialData();
        logger('Add master shop='.$shop->name);
        if($shop->name == $request->get('childstore')){
            $request->session()->flash('error', $request->get('childstore').' is a master account');
            return response()->json([
                'error' => $request->get('childstore').' is a master account',
            ]);
        }
        $shops = User::where('name', $request->get('childstore'))->first();
        if($shops){
          if($shops->alladdons_plan != 'Freemium' && $shops->alladdons_plan != null){
            $request->session()->flash('error', 'This store already has an active subscription');
              return response()->json([
                  'error' => 'This store already has an active subscription.',
              ]);
          }
        }
        $storecount = ChildStore::where('store', $request->get('childstore'))->count();
        if($storecount > 0){
          $request->session()->flash('error', 'This store is already linked');
            return response()->json([
                'error' => 'This store is already linked.',
            ]);
        }
        $shop->master_account = 1;
        $shop->save();
        $store_count = ChildStore::where('user_id', $shop->id)->count();
        if($store_count >= 2) {
            return response()->json([
                'error' => 'Already shared max licences.',
            ]);
        }

         $stores = new ChildStore;
         $stores->store = $request->get('childstore');
         $stores->user_id = $shop->id;
         $stores->save();

        $store_count = ChildStore::where('user_id', $shop->id)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Store licence shared successfully.',
            'store_count' => $store_count,
            'store' => $stores,
        ]);
    }

    // remove linked store function
    public function removechildstore(Request $request){
        $shop = Auth::user();
        $this->fetchInitialData();
        $id = $request->get('store_id');
        //$shops = User::where('name', $request->get('child_store'))->first();
        $stores = ChildStore::find($id);
        $stores->delete();
        //if($shops){
        //  $this->delete_all_addon($shops, 'child');
        //}
        $store_count = ChildStore::where('user_id', $shop->id)->count();
        $request->session()->flash('status', 'Store licence removed');
        return response()->json([
            'status' => 'success',
            'message' => 'Store licence removed successfully.',
            'store_count' => $store_count
        ]);
    }


    public function removeChildStoreAddons(Request $request){
        $this->fetchInitialData();
        $shops = User::where('name', $request->get('child_store'))->first();
        if($shops){
          $this->delete_all_addon($shops, 'child');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Store licence removed successfully.',
        ]);
    }

    // Delete all addons function
    public function delete_all_addon($shop, $action, $called_from_fetchInitialData = false)
    {
        if(!$called_from_fetchInitialData){
            $this->fetchInitialData();
        }
        if($shop && $shop->is_beta_tester == 1 ){
             $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }else{
            $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }
        if(!isset($StoreThemes) || empty($StoreThemes)){
            $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }

        $shop->all_addons = null;
        $shop->alladdons_plan = 'Freemium';
        $shop->sub_plan = null;
        $shop->license_key = null;
        $shop->pause_subscription = null;
        $shop->is_paused = null;
        $shop->save();

        $addons = AddOns::where('user_id', $shop->id)->where('status', 1)->get();
        $checkaddon = 1;

        $update_addon= 0;
        foreach ($addons as $addon) {
            sleep(2);
            $this->deactive_addons($shop,$StoreTheme,$addon->global_id, $checkaddon, $update_addon);
            //logger('Sending call to addon deactivate');
            no_addon_activate_curl($StoreTheme, $shop);
            //logger('Call to addon deactivate complete');
            $addon->status = 0;
            $addon->shedule_time = 0;
            $addon->save();
        }
    }

    public function pause_all_addon($shop, $action, $called_from_fetchInitialData = false){
        if(!$called_from_fetchInitialData){
           $this->fetchInitialData();
        }

        if($shop && $shop->is_beta_tester == 1 ){
              $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }else{
             $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->get();
        }

        if (!isset($StoreTheme) || empty($StoreTheme))
        {
            $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        }
        // $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
        $shop->license_key = null;
        $shop->save();

        $addons = AddOns::where('user_id', $shop->id)->where('status', 1)->get();
        $checkaddon = 1;
        $update_addon= 0;
        foreach ($addons as $addon)
        {
            sleep(2);
            $this->deactive_addons($shop,$StoreTheme,$addon->global_id, $checkaddon, $update_addon);
            no_addon_activate_curl($StoreTheme, $shop);
        }

        $child_stores = ChildStore::where('user_id', $shop->id)->get();
        foreach ($child_stores as $key => $child_store)
        {
            $shop = User::where('name', $child_store->store)->first();
            if ($shop)
            {
                deleteScriptTagCurl($shop); // Removing script tag as well
            }
        }
    }

    public function unpause_all_addon($shops){
        if ($shops->script_tags)
        {
            addScriptTag($shops);
        }

        $store_count = ChildStore::where('user_id', $shops->id)->count();
        if ($store_count > 0)
        {

            $child_stores = ChildStore::where('user_id', $shops->id)->get();
            // print_r($child_stores->toArray());die;
            foreach ($child_stores as $key => $child_store)
            {
                $shops = User::where('name', $child_store->store)->first();
                if($shops){
                    addScriptTagCurl($shops); // adding script tag as well
                }
            }
        }
    }

    public function add_script_js($themes_id, $key){
       $shop = Auth::user();
        $this->fetchInitialData();
        $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $themes_id)->where('status', 1)->get();
        $delivery_addon_activated = AddOns::where('user_id',$shop->id)->where('global_id', 4)->where('status',1)->count();
        $addon_count = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
        $StoreThemes=[];
        foreach ($StoreTheme as $theme) {
            try{
                $get_theme = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
                )['body']['theme'];
                $StoreThemes[] = $theme;
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on live view addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on live view addon throws exception');
            }
        }

        }

    // subscription coupon function
    public function applycoupon(Request $request){
        try{
            $shop = Auth::user();
            $this->fetchInitialData();
          $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
          )['body']['shop'];
          $tax_rates = array();
          if($shopData['country_name'] == 'Canada'){
            logger('domain='.$shop->name.', province='.$shopData['province']);
            // $tax_id = getTaxId($shopData->province);
            $tax = Taxes::where('region',$shopData['province'])->first();
            if($tax){
              $tax_id = $tax->stripe_taxid;
            }else{
              $tax = Taxes::where('region','New-Brunswick')->first();
              $tax_id = $tax->stripe_taxid;
            }
            logger('returning tax='.$tax_id);
            $tax_rates[] = $tax_id;
          }
          \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
          $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
          $done = \Stripe\Subscription::update($subscription->stripe_id, [
              'coupon' => $request->get('subscription_coupon'),
              'default_tax_rates' => $tax_rates,
          ]);
          // $request->session()->flash('status', $request->get('subscription_coupon').' coupon code applied');
          $request->session()->flash('status', 'Coupon code applied');
            return "Coupon code applied.";
        }
        catch(\Stripe\Error\Card $e) {
           // logger("Since it's a decline, \Stripe\Error\Card will be caught");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        } catch (\Stripe\Error\RateLimit $e) {
           // logger("Too many requests made to the API too quickly");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        } catch (\Stripe\Error\InvalidRequest $e) {
            //logger("Invalid parameters were supplied to Stripe's API");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        } catch (\Stripe\Error\Authentication $e) {
            //logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        } catch (\Stripe\Error\ApiConnection $e) {
            //logger("Network communication with Stripe failed");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        } catch (\Stripe\Error\Base $e) {
           logger("Display a very generic error to the user, and maybe send yourself an email");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        } catch (\Exception $e) {
            logger("Something else happened, completely unrelated to Stripe");
            $request->session()->flash('error', "Invalid coupon code");
            return "Invalid coupon code.";
        }
    }

    // new coupon functionn
    public function getcoupon(Request $request){
        try{
            $coupon = $request->get('new_coupon');

            $this->fetchInitialData();
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $valid = \Stripe\Coupon::retrieve($request->get('new_coupon'));
            if($valid->valid){
              $coupon_name = $valid->id;
              $coupon_duration = $valid->duration;
              $coupon_duration_months = $valid->duration_in_months;
                Cookie::queue('coupon', $coupon, 10000);
                if($valid->percent_off != null){
                    return response()->json([
                    'status' => 'Coupon code applied',
                    'percent_off' => $valid->percent_off,
                    'coupon_name' => $coupon_name,
                    'coupon_duration' => $coupon_duration,
                    'coupon_duration_months' => $coupon_duration_months
                  ]);
                } else{
                  return response()->json([
                    // 'status' => $request->get('new_coupon').' coupon code applied',
                    'status' => 'Coupon code applied',
                    'amount_off' => $valid->amount_off,
                    'coupon_name' => $coupon_name,
                    'coupon_duration' => $coupon_duration,
                    'coupon_duration_months' => $coupon_duration_months
                ]);
                }
            } else{
                return "invalid coupon code";
            }
        }
        catch(\Stripe\Error\Card $e) {
            logger("Since it's a decline, \Stripe\Error\Card will be caught");
            return "invalid coupon code";
        } catch (\Stripe\Error\RateLimit $e) {
            logger("Too many requests made to the API too quickly");
            return "invalid coupon code";
        } catch (\Stripe\Error\InvalidRequest $e) {
            logger("Invalid parameters were supplied to Stripe's API");
            return "invalid coupon code";
        } catch (\Stripe\Error\Authentication $e) {
            logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
             return "invalid coupon code";
        } catch (\Stripe\Error\ApiConnection $e) {
            logger("Network communication with Stripe failed");
            return "invalid coupon code";
        } catch (\Stripe\Error\Base $e) {
            logger("Display a very generic error to the user, and maybe send yourself an email");
            return "invalid coupon code";
        } catch (Exception $e) {
            logger("Something else happened, completely unrelated to Stripe");
             return "invalid coupon code";
        }
    }

    // delete multiple addons function
    function delete_multipl_addons(Request $request){
        $shop = Auth::user();
        $StoreThemes = [];
        $this->fetchInitialData();
        $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();
      foreach ($StoreTheme as $theme) {
          try{
          $get_theme = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
          )['body']['theme'];
             $StoreThemes[] = $theme;
          }catch(\GuzzleHttp\Exception\ClientException $e){
              logger('update schema on live view addon throws client exception');
          }
          catch(\Exception $e){
              logger('update schema on live view addon throws exception');
          }
      }

    if(is_array($request->get('addons'))){
      foreach ($request->get('addons') as $key => $mltaddons) {
        $addon = AddOns::where('user_id', $shop->id)->where('global_id', $mltaddons)->first();
        $addon_count = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
        $checkaddon = 0;
        if($addon_count <= 1)
        {
            $checkaddon =1;
        }else{
            $checkaddon = 0;
        }
        $addon->status = 0;
        $addon->shedule_time = 0;
        $addon->save();
        $update_addon= 0;
        $this->deactive_addons($shop,$StoreThemes,$mltaddons, $checkaddon, $update_addon);
      }
    }
      $request->session()->flash('status', 'Add-On uninstalled');
      if(!empty($request->get('referrer_url')))
      {
        return redirect()->to($request->get('referrer_url'));
      }
      return redirect()->route('plans');
    }

    //update trial function
    function update_trail(){
      try{
        $this->fetchInitialData();
        $shop = Auth::user();
        $shop->trial_check = 1;
        $shop->save();
      }
      catch(Exception $e){
        logger('update_trail: ' . $e->getMessage());
      }
    }

    //app installed check
    function update_themecheck(){
      try{
        $this->fetchInitialData();
        $shop = Auth::user();
        $shop->theme_check = 1;
        $shop->save();
      }
      catch(Exception $e){
        logger('update_themecheck: ' . $e->getMessage(). ' ' .$e->getTraceAsString());
      }
    }

    // product research saaturation filer function
    public function changeSaturation(){
      $products = WinningProduct::orderBy('id', 'desc')->get();

      foreach ($products as $key => $product) {
        if($product->saturationlevel == 'low'){
          $product->saturationlevel = 'gold';
        }elseif ($product->saturationlevel == 'medium') {
          $product->saturationlevel = 'silver';
        }elseif ($product->saturationlevel == 'high') {
          $product->saturationlevel = 'bronze';
        }
        $product->save();
      }
      echo "all products updated successfully";
    }

    // prorated stripe plan upgrade function
    public function proratedAmount(Request $request){
      $shop = Auth::user();
      $this->fetchInitialData();
        $mainSubscription = $shop->mainSubscription;
        if($mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE){
            $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $proration_date = time();
            logger($subscription->stripe_id);
            $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);
            // and proration set:
            $items = [
                [
                    'id' => $subscription_stripe->items->data[0]->id,
                    'price' => $request->get('plan_id'), # Switch to new plan
                ],
            ];

            $invoice = \Stripe\Invoice::upcoming([
                'customer' => $subscription_stripe->customer,
                'subscription' => $subscription->stripe_id,
                'subscription_items' => $items,
                'subscription_proration_date' => $proration_date,
            ]);

            logger('invoice='.json_encode($invoice));
            // Calculate the proration cost:
            $cost = 0;
            $current_prorations = [];
            $cost = $invoice->lines->data[0]->amount;
            // foreach ($invoice->lines->data as $line) {
            //   //logger($line->period->start);
            //   //logger($proration_date);
            //     if ($line->period->start - $proration_date <= 1) {
            //         array_push($current_prorations, $line);
            //         $cost += $line->amount;
            //     }
            // }
            logger('prorated amount='.json_encode($cost));
            $amount = $cost/100;
            return response()->json([
                'status' => 'success',
                'prorated_amount' => $amount
            ]);
        }
        if($mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL){
            return response()->json([
                'status' => 'success',
                'prorated_amount' => 0
            ]);
        }
        return response()->json([
            'status' => 'success',
            'prorated_amount' => 0
        ]);
      //die;
    }

    public function updateAllShopSubscriptions() {
      /*
      $shops = User::whereNotNull('shopify_token')->get();
        // logger("Updation canada shops subscriptions started from cron");
        foreach ($shops as $key => $shop) {
            try{
                $shopData = $shop->api()->request(
                    'GET',
                    '/admin/api/shop.json',
                    []
                )['body']->shop;
                $tax_rates = array();
                if($shopData->country_name == 'Canada'){
                  // $tax_id = getTaxId($shopData->province);
                  $tax = Taxes::where('region',$shopData->province)->first();
                  if($tax){
                    $tax_id = $tax->stripe_taxid;
                  }else{
                    $tax = Taxes::where('region','New-Brunswick')->first();
                    $tax_id = $tax->stripe_taxid;
                  }
                  echo 'id='.$shop->id.' ,domain='.$shop->name.', province='.$shopData->province.', returning tax='.$tax_id."<br>";
                  logger('id='.$shop->id.' ,domain='.$shop->name.', province='.$shopData->province.', returning tax='.$tax_id);
                  $tax_rates[] = $tax_id;
                  $subscription = Subscription::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
                  if($subscription){
                    try{
                      \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                      // Delete Discount code on upgrade/downgrade
                      $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);
                      if($sub->discount){
                        $deleteDiscount = $sub->deleteDiscount();
                      }
                      $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);
                      // echo "<pre>";
                      // print_r($subscription_stripe);
                      // echo "</pre>";
                      if (empty($subscription_stripe->default_tax_rates)) {
                        $update_subscription = \Stripe\Subscription::update($subscription->stripe_id, [
                          'cancel_at_period_end' => false,
                          'items' => [
                            [
                              'id' => $subscription_stripe->items->data[0]->id,
                              'plan' => $subscription_stripe->plan->id,
                            ],
                          ],
                          'default_tax_rates' => $tax_rates,
                        ]);
                        echo ' updated subscription with tax, strip id='.$subscription->stripe_id." <br>";
                        logger(' updated subscription with tax, strip id='.$subscription->stripe_id);
                      }else{
                        print_r($subscription_stripe->default_tax_rates);
                        logger('tax already exist='.json_encode($subscription_stripe->default_tax_rates));
                      }
                    }catch(\Stripe\Error\Card $e) {
                       logger("Since it's a decline, \Stripe\Error\Card will be caught, strip id=".$subscription->stripe_id);
                    } catch (\Stripe\Error\RateLimit $e) {
                       logger("Too many requests made to the API too quickly, strip id=".$subscription->stripe_id);
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        logger("Invalid parameters were supplied to Stripe's API, strip id=".$subscription->stripe_id);
                    } catch (\Stripe\Error\Authentication $e) {
                        logger("Authentication with Stripe's API failed(maybe you changed API keys recently), strip id=".$subscription->stripe_id);
                    } catch (\Stripe\Error\ApiConnection $e) {
                        logger("Network communication with Stripe failed, strip id=".$subscription->stripe_id);
                    } catch (\Stripe\Error\Base $e) {
                      logger("Display a very generic error to the user, and maybe send yourself an email, strip id=".$subscription->stripe_id);
                    } catch (Exception $e) {
                      logger("Something else happened, completely unrelated to Stripe, strip id=".$subscription->stripe_id);
                    }
                  }
                }
                // die();
              }catch(\GuzzleHttp\Exception\ClientException $e){
                logger("shop ClientException, shop id=".$shop->id);
              }catch(\GuzzleHttp\Exception\RequestException $e){
                logger("shop RequestException, shop id=".$shop->id);
              }catch (Exception $e) {
                logger("Something else happened, completely unrelated to Stripe, shop id=".$shop->id);
              }
      }
*/
      $shop = User::where('name','test-raph1.myshopify.com')->first();
      $Subscription = SubscriptionStripe::where('user_id',$shop->id)->get();
      echo "<pre>";
      print_r($Subscription);
      echo "</pre>";
  }
  public function generateVideoEmbedUrl($url){
    //This is a general function for generating an embed link of an FB/Vimeo/Youtube YoutubeVideos.
    $finalUrl = '';
    if(strpos($url, 'facebook.com/') !== false) {
        //it is FB video
        $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
    }else if(strpos($url, 'vimeo.com/') !== false) {
        //it is Vimeo video
        $videoId = explode("vimeo.com/",$url)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://player.vimeo.com/video/'.$videoId;
    }else if(strpos($url, 'youtube.com/') !== false) {
        //it is Youtube video
        $videoId = explode("v=",$url)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.youtube.com/embed/'.$videoId;
    }else if(strpos($url, 'youtu.be/') !== false){
        //it is Youtube video
        $videoId = explode("youtu.be/",$url)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.youtube.com/embed/'.$videoId;
    }else{
        //Enter valid video URL
    }
    return $finalUrl;
}


//auto update subscription
    public function upsell_subscription(Request $request, StripePlan $plan){
      $shop = Auth::user();
      $this->fetchInitialData();
      logger('all subscription shop='.$shop->name);
      Session::put('tax_user_id', $shop->id);
        // die();
      $shopData = $shop->api()->request(
        'GET',
        '/admin/api/shop.json',
        []
      )['body']['shop'];
      $tax_rates = $thank_you_data = array();
      if($shopData['country_name'] == 'Canada'){
        logger('domain='.$shop->name.', province='.$shopData['province']);
          // $tax_id = getTaxId($shopData->province);
        $tax = Taxes::where('region',$shopData['province'])->first();
        if($tax){
          $tax_id = $tax->stripe_taxid;
        }else{
          $tax = Taxes::where('region','New-Brunswick')->first();
          $tax_id = $tax->stripe_taxid;
        }
        logger('returning tax='.$tax_id);
        $tax_rates[] = $tax_id;
      }

        // address for stripe
      $address = array('line1' => $shopData['address1'], 'city' => $shopData['city'], 'country' => $shopData['country_name'], 'line2' => $shopData['address2'], 'postal_code' => $shopData['zip'], 'state' => $shopData['province']);
      $theme_count = StoreThemes::where('user_id', $shop->id)->where('status',1)->count();

      $isBrandNewSubscription = false;
      try{
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            // cancel a subscription if already Created
        if($shop->all_addons == 1){

                // subscription update
          $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();

                // Delete Discount code on upgrade/downgrade
          $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);
          if($sub->discount){
            $deleteDiscount = $sub->deleteDiscount();
          }
          $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

                // See what the next invoice would look like with a plan switch
                // upgrade/downgrade subscription
          // if( $coupon = $request->get('new_coupon')) {
                    $coupon = $request->get('new_coupon');
                    if($coupon == '8864215630'){
                          $starter_coupons = \Stripe\Coupon::create([
                                    'percent_off' => 30,
                                    'duration' => 'repeating',
                                    'duration_in_months' => 1,
                            ]);
                          $new_coupon = $starter_coupons->id;
                    }elseif ($coupon == '4156088664') {
                          $starter_coupons = \Stripe\Coupon::create([
                                    'percent_off' => 40,
                                    'duration' => 'repeating',
                                    'duration_in_months' => 1,
                            ]);
                          $new_coupon = $starter_coupons->id;
                    }elseif ($coupon == '6037353105') {
                          $starter_coupons = \Stripe\Coupon::create([
                                    'percent_off' => 50,
                                    'duration' => 'repeating',
                                    'duration_in_months' => 1,
                            ]);
                          $new_coupon = $starter_coupons->id;
                    }

          $update_subscription = \Stripe\Subscription::update($subscription->stripe_id, [
            'coupon' => $starter_coupons ?? '',
            'cancel_at_period_end' => null,
            'proration_behavior' => "always_invoice",
            'items' => [
              [
                'id' => $subscription_stripe->items->data[0]->id,
                'plan' => $request->get('plan_id'),
              ],
            ],
            'default_tax_rates' => $tax_rates,
          ]);

          if(isset($starter_coupons) && !empty($starter_coupons)){
            $starter_coupons->delete();
          }

          $sub = \Stripe\Invoice::retrieve($update_subscription->latest_invoice);
          $total_bill = $sub->total;
          $total_tax = empty($sub->tax) ? 0 : $sub->tax;
          $total_amount = $total_bill - $total_tax;
          $revenue = $total_bill + $total_tax;
              $thank_you_data = array(
                  'tracking' => $update_subscription->latest_invoice,
                  'amount' => $total_amount,
                  'subscription_id' => $subscription->stripe_id,
                  'plan_id' => $request->get('plan_id'),
                  'revenue' => $revenue,
                  'tax' => $total_tax,
                  'alladdons_plan' => $request->get('payment_cycle'),
                  'sub_plan' => $request->sub_plan,
                  'coupon' => $request->get('new_coupon'),
                );
          logger('subscription updated='.json_encode($update_subscription));
        }
      }
      catch(\Stripe\Exception\CardException $e) {
        logger("Since it's a decline, \Stripe\Error\Card will be caught");
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $request->session()->flash('error', $err['message']);
        return redirect()->route('theme_addons');
      } catch (\Stripe\Exception\RateLimitException $e) {
        logger("Too many requests made to the API too quickly");
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $request->session()->flash('error', $err['message']);
        return redirect()->route('theme_addons');
      } catch (\Stripe\Exception\InvalidRequestException $e) {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        logger("Invalid parameters were supplied to Stripe's API, error=".$err['message']);
        $request->session()->flash('error', $err['message']);
        return redirect()->route('theme_addons');
      } catch (\Stripe\Exception\AuthenticationException $e) {
        logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $request->session()->flash('error', $err['message']);
        return redirect()->route('theme_addons');
      } catch (\Stripe\Exception\ApiConnectionException $e) {
        logger("Network communication with Stripe failed");
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $request->session()->flash('error', $err['message']);
        return redirect()->route('theme_addons');
      } catch (\Stripe\Exception\ApiErrorException $e) {
        logger("Display a very generic error to the user, and maybe send yourself an email");
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $request->session()->flash('error', $err['message']);
        return redirect()->route('theme_addons');
       } catch (\Exception $e) {
        logger("Something else happened, completely unrelated to Stripe");
        $err = $e->getMessage();
        $request->session()->flash('error', $err);
        return redirect()->route('theme_addons');
      }
      $this->setPlanActionTag($shop, $request);

      //      // Create new subscription
      // $shop->sub_trial_ends_at = 0;
      // $shop->trial_days = 0;
      // $shop_owner = $shopData['shop_owner'];
      // $shop_owner_name = explode(" ", $shop_owner);

      $shop->all_addons = 1;
      $shop->alladdons_plan = $request->get('payment_cycle');
      $shop->sub_plan = $request->get('sub_plan');
      //   // license key created
      $license_key = Hash::make(Str::random(12));
      $shop->license_key = $license_key;
      $shop->custom_domain = $shopData['domain'];
      $shop->save();

      if ($isBrandNewSubscription) {
        $request->session()->flash('isBrandNewSubscription', $isBrandNewSubscription);
      }

      if($request->get('payment_cycle') == 'master'){
        $request->session()->flash('subscription_upsell', 'Master');
      }
      elseif($request->get('payment_cycle') == 'hustler'){
        $request->session()->flash('subscription_upsell', 'Hustler');
      }
      else{
        $request->session()->flash('subscription_upsell', 'Starter');
      }

      $request->session()->flash('status', 'Subscription plan upgraded');

      $request->session()->flash('thank_you_data', $thank_you_data);
      $urls = 'thankyou';

      try {
        $contact = $this->activeCampaign->sync([
          'email' => $shop->email,
          'fieldValues' => [
            ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $request->get('payment_cycle')]
          ]
        ]);
        $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);

        if ($contactTag) {
          $untag = $this->activeCampaign->untag($contactTag['id']);
        }
      } catch (Exception $e) {
        $e->getMessage();
      }

      return redirect()->route($urls);
    }

    public function contactTagAdd() {
      $shop = Auth::user();
			$contact = $this->activeCampaign->sync([
				'email' => $shop->email
			]);
      $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_KAMIL_SATTAR_MENTORING);

      return response()->json([
        'status' => 'success'
      ]);
    }

    //expired free trial
    function free_trial_expired(Request $request){
        // if ($request->session()->has('status')) {
          $shop = Auth::user();
          if(empty($shop) ){
                return redirect()->route('login');
          }

          if($shop->trial_days != 0 && $shop->alladdons_plan != "" && $shop->alladdons_plan != "Freemium"){

                return redirect()->route('home');
          }
          $this->fetchInitialData();
          $exit_code = '50OFF3MONTHS';
          $new_code = 'DEBUTIFY20';
          $coupon_name = '';
          $percent_off = '';
          $coupon_duration = '';
          $coupon_duration_months = '';
          $previous_plan = '';
          $discount = $plan = '';
          $StripePlan = StripePlan:: all();

          $starterPriceAnnually = $starterPriceQuarterly = $starterPriceMonthly = 0;
          $hustlerPriceAnnually = $hustlerPriceQuarterly = $hustlerPriceMonthly = 0;
          $guruPriceAnnually = $guruPriceQuarterly = $guruPriceMonthly = 0;

          $starteridAnnually = $starteridQuarterly = $starteridMonthly = "";
          $hustleridAnnually = $hustleridQuarterly = $hustleridMonthly = "";
          $guruidAnnually = $guruidQuarterly = $guruidMonthly = "";

          // get active plan price and ID
          foreach ($StripePlan as $plan) {
            if ($plan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY) {
              $starterPriceAnnually = $plan->cost;
              $starteridAnnually = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::STARTER_PRICE_QUARTERLY) {
              $starterPriceQuarterly = $plan->cost;
              $starteridQuarterly = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY) {
              $starterPriceMonthly = $plan->cost;
              $starteridMonthly = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY) {
              $hustlerPriceAnnually = $plan->cost;
              $hustleridAnnually = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_QUARTERLY) {
              $hustlerPriceQuarterly = $plan->cost;
              $hustleridQuarterly = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY) {
              $hustlerPriceMonthly = $plan->cost;
              $hustleridMonthly = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY) {
              $guruPriceAnnually = $plan->cost;
              $guruidAnnually = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::MASTER_PRICE_QUARTERLY) {
              $guruPriceQuarterly = $plan->cost;
              $guruidQuarterly = $plan->stripe_plan;
            }
            if ($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY) {
              $guruPriceMonthly = $plan->cost;
              $guruidMonthly = $plan->stripe_plan;
            }
          }

        $applyTaxes = false;
        $shopData = $shop->api()->request(
          'GET',
          '/admin/api/shop.json',
          []
        )['body']['shop'];

        if($shopData['country_name'] == 'Canada'){
          $applyTaxes = true;
        }

        $billingCycle = 'yearly';

        if ($shop->sub_plan == 'month') {
            $billingCycle = 'monthly';
        }

        if ($shop->sub_plan == 'Quarterly') {
          $billingCycle = 'quarterly';
        }

        $hustler_count = ((int) User::where('alladdons_plan', 'Hustler')->count());
        $master_count  = ((int) User::where('alladdons_plan', 'Guru')->orWhere('alladdons_plan', 'Master')->count());
        return view('free_trial', [
          'hide_side_bar'=>1,
          'starterPriceAnnually' => $starterPriceAnnually,
          'starterPriceQuarterly' => $starterPriceQuarterly,
          'starterPriceMonthly' => $starterPriceMonthly,
          'hustlerPriceAnnually' => $hustlerPriceAnnually,
          'hustlerPriceQuarterly' => $hustlerPriceQuarterly,
          'hustlerPriceMonthly' => $hustlerPriceMonthly,
          'guruPriceAnnually' => $guruPriceAnnually,
          'guruPriceQuarterly' => $guruPriceQuarterly,
          'guruPriceMonthly' => $guruPriceMonthly,
          'starteridAnnually' => $starteridAnnually,
          'starteridQuarterly' => $starteridQuarterly,
          'starteridMonthly' => $starteridMonthly,
          'hustleridAnnually' => $hustleridAnnually,
          'hustleridQuarterly' => $hustleridQuarterly,
          'hustleridMonthly' => $hustleridMonthly,
          'guruidAnnually' => $guruidAnnually,
          'guruidQuarterly' => $guruidQuarterly,
          'guruidMonthly' => $guruidMonthly,
          'plan' => $plan,
          'all_addons' => $shop->all_addons,
          'alladdons_plan'=> $shop->alladdons_plan,
          'sub_plan' => $shop->sub_plan,
          'billingCycle' => $billingCycle,
        ]);

    }
    public function generate10coupon(){
          if(config('env-variables.TRIAL_COUPON') != ''){
            $trial_coupon = config('env-variables.TRIAL_COUPON');
          }else{
            $trial_coupon = 'DEBUTIFYTRIAL10';
          }
          return response()->json([
                    'status' => 'success',
                    'coupon_code' => $trial_coupon,
          ]);

      }

      public function internal_server_error(){
          if(Session::has('error_message')){
            return view('errors.500');
          }else{
              return redirect()->route('home');
          }
      }

      public function refreshScriptTags(Request $request)
      {
        $shop = Auth::user();
        addScriptTag($shop);
        return redirect()->route('home');
      }

      private function setPlanActionTag($shop, $request) {
        try {
          $upgradePlanList = [
            'Starter' => 0,
            'Hustler' => 1,
            'Master' => 2
          ];

          $contact = $this->activeCampaign->sync([
            'email' => $shop->email
          ]);

          if (!array_key_exists($shop->alladdons_plan, $upgradePlanList) || (array_key_exists($shop->alladdons_plan, $upgradePlanList) && $upgradePlanList[$shop->alladdons_plan] <= $upgradePlanList[$request->get('payment_cycle')])) {
            $tagUpgraded = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_UPGRADED);
            $tagDowngraded = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_DOWNGRADED);

            if ($tagDowngraded) {
              $untag = $this->activeCampaign->untag($tagDowngraded['id']);
            }
          }  else {
            $tagDowngraded = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_DOWNGRADED);
            $tagUpgraded = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_UPGRADED);

            if ($tagUpgraded) {
              $untag = $this->activeCampaign->untag($tagUpgraded['id']);
            }
          }
        } catch (Exception $e) {
            $e->getMessage();
        }
      }


      public function install_beta_theme_plan(){
            // echo "sub_plan=".$request->get('sub_plan');
        $shop = Auth::user();
        $shopData = $shop->api()->request(
            'GET',
            '/admin/api/shop.json',
            []
        )['body']['shop'];

        $license_key = Hash::make(Str::random(12));
        $trial_days = 30;

        $current_date = new DateTime();
        $formatted_current_date = $current_date->format('Y-m-d');
        $trial_ends_at = date('Y-m-d', strtotime($formatted_current_date.' + '.$trial_days.' days'));
        $shop->trial_ends_at = $trial_ends_at;
        $shop->license_key = $license_key;
        $shop->alladdons_plan = "";

        if($shop->all_addons == 1){
            $shop->sub_trial_ends_at = 1;
            $shop->sub_plan = $shop->sub_plan;
        }else{
          $shop->all_addons = 1;
          $shop_owner = $shopData['shop_owner'];
          $shop_owner_name = explode(" ", $shop_owner);
          $shop->sub_trial_ends_at = 1;
          $shop->sub_plan = "month";
          $shop->custom_domain = $shopData['domain'];

        }

        $shop->save();
      }

      // app view show all feature
      public function extended_trial(Request $request){
         $shop = Auth::user();
         if(!$shop){
          return redirect()->route('login');
         }
        $this->fetchInitialData();

        if( ($shop->trial_days > 0 || $shop->alladdons_plan == "Freemium" || $shop->alladdons_plan == "") && $shop->is_beta_tester == false && $shop->is_paused != 1 && $shop->is_beta_tester != 1 && $shop->is_paused != 1){

                $extend_features = ExtendTrial::orderby('id','desc')->get();
                $extend_feature_request = [];
                  foreach ($extend_features as $key => $extend_feature) {
                        $extend_trial_status = "";
                        $request_feature = UserExtendTrialRequest::where('extend_trials_id', $extend_feature->id)->where('user_id',$shop->id)->select('extend_trial_status')->first();

                        if($request_feature) {
                          $extend_trial_status = $request_feature->extend_trial_status ?? "";
                        }
                        $extend_feature['extend_trial_status'] = $extend_trial_status;
                        $extend_feature_request[] = $extend_feature;
                  }
              return view('extended-trial', [
                'extend_features' => $extend_feature_request,
                'user_id' => $shop->id,
                'extend_trial_feature_count' => count($extend_features)
              ]);

        }else{
              return redirect()->route('home');
        }
      }

      public function upload_image(Request $request){
          if ($request->has('p_logo'))
          {
              $file = $request->file('p_logo');
              $file = is_array($file) ? $file[0] : $file;
              $filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();
              $path = $file->storeAs('extend_feature_request', $filename, 'public');
              $url = config('app.url') . '/storage/' . $path;
              return response()->json(['success' => true, 'url' => $url]);
          }
          return response()->json(['success' => false, 'url' => ""]);
      }

      // user request from app
      public function user_feature_submit(Request $request){
                $shop = Auth::user();
                if(!$shop){
                  return redirect()->route('login');
                }
                if ($request->has('extend_feature_id') && $request->has('feature_proof_image'))
                {
                    $extendtrial_feature = UserExtendTrialRequest::extend_user_request($request, $shop->id);
                    $request->session()->flash('extend_request', 'ok');
                }
              return redirect()->route('extended_trial');
      }


  }

