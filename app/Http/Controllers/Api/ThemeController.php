<?php

namespace App\Http\Controllers\Api;

use URL;
use Storage;
use App\User;
use DateTime;
use App\Taxes;
use Exception;
use App\AddOns;
use App\Course;
use App\Themes;
use App\Partner;
use App\Updates;
use App\AddOnInfo;
use App\FreeAddon;
use App\Themefile;
use Carbon\Carbon;
use App\ChildStore;
use App\StripePlan;
use App\ExtendTrial;
use App\StoreThemes;
use App\GlobalAddons;
use App\Subscription;
use \Firebase\JWT\JWT;
use App\MentoringCall;
use GuzzleHttp\Client;
use App\WinningProduct;
use App\MainSubscription;
use App\ThemefileContent;
use App\SubscriptionPaypal;
use App\SubscriptionStripe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\UserExtendTrialRequest;
use App\FrequentlyAskedQuestion;
use App\Jobs\ActiveCampaignJobV3;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PaypalController;
use App\Constants\ActiveCampaignConstants as AC;
use Mediatoolkit\ActiveCampaign\Client as ACClient;
use Intercom\IntercomClient;
use Illuminate\Support\Arr;

class ThemeController extends Controller
{
    public $subscription_status;
    public $trial_check;
    public $trial_plan;
    public $allAddons;
    public $stripe_key;
    public $storeLimit;
    public $activeCampaign;

    public function __construct()
    {
        $this->trial_check = true; # The trial is activated by default so hardcoding it for now
        $this->trial_plan = 'Master';
        $this->stripe_key = config('services.stripe.secret');
        $this->store_limit = 2;
        $this->activeCampaign = new ActiveCampaignJobV3();
        }

    /**
     * Check whether the user is a beta tester.
     *
     * @param   boolean       $status         Attach the status to association on the condition. Default is 1.
     * @return  boolean       The status of user for being a beta tester
     */

    public function isBetaTester()
    {
        $shop = auth()->user();

        return isset($shop->is_beta_tester) && $shop->is_beta_tester == 1;
    }

    # General / global data
    public function currentShopData(StripePlan $plan, Request $request)
    {
        try {
            $shop = Auth::user();
            $name = request()->headers->get('referer');
            $shopData = $shop->shop_api;
            $progressCounts = $this->progressCounts($shop);
            $mainSub = $shop->mainSubscription;
            $masterShopName = $this->checkMasterStore($shop);
            $shopPlansData = $this->shopPlansData($shop);
            $shopSubscription = $this->shopSubscription();
            $stripePlans = $this->stripePlans($shop);
            $courses = Course::orderBy('id', 'desc')->get();
            $addOnsCounts = $this->addOnsCounts($shop);
            $allAddOnsPlan = $this->getAddonsPlan($shop);
            $mentoringWinnerCount = $shop->mentoringcalls()->where('days', '>', 0)->count();
            $themesData = $this->getThemesData();
            $extendTrialRequestData = $this->extendTrialRequestData();

            $progressCounts['completed'] = (int) $progressCounts['completed'] + (int) $extendTrialRequestData['steps_completed'];
            $progressCounts['total'] = (int) $progressCounts['total'] + (int) $extendTrialRequestData['progress'];

            $showGeneralBanners = !Str::contains($name, ['goodbye', 'free_trial_expired']);
            $showTrialOver = !Str::contains($name, ['plans', 'free_trial_expired', 'goodbye']);
            $viewPans = Str::contains($name, ['plans', 'checkout']);

            $pausedPlanData = $shop->is_paused ? unserialize($shop->pause_subscription) : [];

            $priorBetaTheme = $shop->storethemes()->active()->isBetaTheme(false)->count();
            $checkoutPlan = StripePlan::where('plan_name', Str::ucfirst('starter'))->orderBy('cost')->pluck('paypal_plan');
            $paypal_os_balance = check_user_outstanding_balance($shop);

            $data = [
                'success' => true,
                'data' => [
                    'addons_counts' => $addOnsCounts,
                    'all_addons_plan' => $allAddOnsPlan,
                    'courses' => $courses,
                    'dashboard_progress' => $progressCounts,
                    'general_banners' => $showGeneralBanners,
                    'master_shop_name' => $masterShopName,
                    'mentoring_winner_count' => $mentoringWinnerCount,
                    'paused_plan_data' => $pausedPlanData,
                    'plan' => $plan,
                    'main_sub' => $mainSub,
                    'shop' => $shop,
                    'shop_data' => $shopData,
                    'shop_plans_data' => $shopPlansData,
                    'show_trial_over' => $showTrialOver,
                    'stripe_plans' => $stripePlans,
                    'subscription_status' => $shopSubscription['subscription_status'] ?? null,
                    'subscription' => $shopSubscription['subscription']  ?? null,
                    'view_plans' => $viewPans,
                    'prior_beta_theme' => $priorBetaTheme,
                    'themes_data' => $themesData,
                    'extend_trial' => $shop->extend_trial,
                    'extend_all_step' => $extendTrialRequestData['extend_all_step'],
                    'trial_extend_step_progress' => $extendTrialRequestData['trial_extend_step_progress'],
                    'checkout_plan' => $checkoutPlan,
                    'paypal_os_balance' => $paypal_os_balance
                ]
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . $e->getTraceAsString()
            ]);
        }
    }

    #TRIAL


    # Fetch Shopify shop data using the shop api request
    // Currently included as attribute on the User model
    public function getShopData($shop)
    {
        return $shop->api()->request(
            'GET',
            "/admin/api/shop.json",
            []
        )['body']['shop'] ?? false;
    }

    public function getShopThemes($shop)
    {
        return $shop->api()->request(
            'GET',
            '/admin/api/themes.json'
        )['body']['themes'] ?? false;
    }

    public function shopApiUploadTheme($shop, $args)
    {
        return $shop->api()->request(
            'POST',
            '/admin/api/themes.json',
            $args
        )['body']['theme'];
    }

    public function shopApiUpdateSchemaSettings($shop, $themeId, $schemas)
    {
        return $shop->api()->request(
            'PUT',
            "/admin/api/themes/$themeId/assets.json",
            [
                'asset' => [
                    'key' => 'config/settings_data.json',
                    'value' => $schemas
                ]
            ]
        );
    }

    public function shopApiUpdateSettingsSchema($shop, $themeId, $schemas)
    {
        return $shop->api()->request(
            'PUT',
            "/admin/api/themes/$themeId/assets.json",
            [
                'asset' => [
                    'key' => 'config/settings_schema.json',
                    'value' => $schemas
                ]
            ]
        );
    }

    public function shopApiGetSettingsSchema($shop, $themeId)
    {
        return $shop->api()->request(
            'GET',
            "/admin/api/themes/$themeId/assets.json",
            ['asset' => ['key' => 'config/settings_schema.json']]
        )['body']['asset']['value'] ?? false;
    }

    public function shopApiGetTheme($shop, $theme_id)
    {
        return $shop->api()->request(
            'GET',
            '/admin/api/themes/' . $theme_id . '.json'
        )['body']['theme'] ?? false;
    }

    public function dashboard(Request $request)
    {
        $shop = auth()->user();
        $update_popup = $this->updates();
        $latestupload = $shop->storethemes()->active()->orderBy('id', 'desc')->first();
        $allExtendFeature = ExtendTrial::count();
        $trial_extended = UserExtendTrialRequest::where('extend_trial_status', 'approved')
                            ->where('user_id', $shop->id)
                            ->count();

        $data = [
            'current_progress' => [
                'review_given' => $shop->review_given,
                'latestupload' => $latestupload,
                'trial_check' => $this->trial_check,
                'trial_extended' => $trial_extended === $allExtendFeature,
            ],
            'updates' => $update_popup,
            'is_update_addons' => $this->isUpdatePending($shop),
            'script_tags_url' => scriptTagPermissionRedirectURL($shop),
            'script_tags' => $shop->script_tags,
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function updates()
    {
        $shop = auth()->user();
        $update_popup = Updates::orderBy('id', 'desc')->first();

        if ($update_popup != null)
        {
            $update_popup->video = $this->generateVideoEmbedUrl($update_popup->video);
        } else {
            $update_popup = false;
        }

        return $update_popup;
    }

    public function progressCounts($shop)
    {
        $latestupload = $shop->storethemes()->orderBy('id', 'desc')->first();
        $totalActiveAddons = $shop->addons()->active()->count();
        $allExtendFeature = ExtendTrial::count();
        $trial_extended = UserExtendTrialRequest::where('extend_trial_status', 'approved')
                            ->where('user_id', $shop->id)
                            ->count();

        # Dashboard progress
        $progress = 0;
        $stepsCompleted = 0;
        $trial_check = $this->trial_check;

        if (isset($trial_check) && $trial_check) {
            $progress += 25;
            $stepsCompleted += 1;
        }

        if (isset($latestupload) && $latestupload) {
            $progress += 25;
            $stepsCompleted += 1;
        }

        if (isset($totalActiveAddons) && $totalActiveAddons > 0) {
            $progress += 25;
            $stepsCompleted += 1;
        }

        if (isset($shop->review_given) && $shop->review_given) {
            $progress += 25;
            $stepsCompleted += 1;
        }

        if ($trial_extended === $allExtendFeature) {
            $progress += 25;
            $stepsCompleted += 1;
        }

        return [
            'total' => $progress,
            'completed' => $stepsCompleted
        ];
    }

    public function trial()
    {
        $shop = Auth::user();
        $trialEndDate = null;
        $showEndAt = null;
        $data = [];
        $getStripeSub = null;
        $getPaypalSub = null;
        $billingDate = null;
        $date = new DateTime();
        $mainSubscription = $shop->mainSubscription;

        if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE)
        {
            $subscription = $shop->stripeSubscription()->sortByDesc('id')->first();

            if ($subscription && isset($subscription->stripe_id))
            {

                $getStripeSub = \Stripe\Subscription::retrieve($subscription->stripe_id);
                //                    $date = new DateTime();
                $date->setTimestamp($getStripeSub->current_period_end);
                $new_format = $date->format('Y-m-d');
                $billingDate = $new_format;
                if (isset($subscription->trial_ends_at) && $subscription->trial_ends_at != null) {
                    $dates = new DateTime();
                    $new_formats = $dates->format('Y-m-d');
                    $dates = new DateTime($subscription->trial_ends_at);
                    $end_at = $dates->format('Y-m-d');
                    if ($end_at >= $new_formats) {
                        $showEndAt = $dates->format('M. d, Y');
                        $diff = strtotime($new_formats) - strtotime($end_at);
                        $days = abs(round($diff / 86400));
                        $trialEndDate = $days;
                    }
                }


            } else
            {
                $showEndAt = Carbon::now()->addWeek()->format('M. d, Y');
                $trialEndDate = "7";
            }


            $data = [
                'mainSubscription' => $mainSubscription,
                'getStripeSub' => $getStripeSub,
                'billingDate' => $billingDate,
                'showEndAt' => $showEndAt,
                'trialEndDate' => $trialEndDate,
            ];
        }
        if (isset($mainSubscription) && $mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL)
        {
            $subscription = $shop->paypalSubscription()->active()->first();

            if ($subscription && isset($subscription->paypal_id))
            {
                $paypalSubId = $subscription->paypal_id;
                $getPaypalSub = fetchPaypalSubscriptionStatus($paypalSubId);

                if (@$getPaypalSub['statusCode'] == 200)
                {
                    if (@$getPaypalSub['response']['status'] == 'ACTIVE')
                    {
                        $new_format = Carbon::parse(@$getPaypalSub['response']['billing_info']['next_billing_time'])->toDateString();
                        $billingDate = $new_format;
                        if (isset($subscription->trial_ends_at) && $subscription->trial_ends_at != null)
                        {
                            $dates = new DateTime();
                            $new_formats = $dates->format('Y-m-d');
                            $dates = new DateTime($subscription->trial_ends_at);
                            $end_at = $dates->format('Y-m-d');
                            if ($end_at >= $new_formats)
                            {
                                $showEndAt = $dates->format('M. d, Y');
                                $diff = strtotime($new_formats) - strtotime($end_at);
                                $days = abs(round($diff / 86400));
                                $trialEndDate = $days;
                            }
                        }
                    }
                    if (@$getPaypalSub['response']['status'] == 'APPROVAL_PENDING')
                    {
                        $links = $getPaypalSub['response']['links'];
                        $approve_link = array_filter($links, function ($link) {
                            return $link['rel'] == "approve";
                        });
                        return redirect(array_values($approve_link)[0]['href']);
                    }
                }

            } else {
                $showEndAt = Carbon::now()->addWeek()->format('M. d, Y');
                $trialEndDate = "7";
            }
            $data = [
                'mainSubscription' => $mainSubscription,
                'getPaypalSub' => $getPaypalSub,
                'billingDate' => $billingDate,
                'showEndAt' => $showEndAt,
                'trialEndDate' => $trialEndDate,

            ];
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function extendTrialRequestData()
    {
        // get extend trial days , step and complete all
        $shop = Auth::user();
        $extendTrialRequests = $shop->extendTrialRequests()->status('approved')->count();
        $extend_trial_requests = UserExtendTrialRequest::where('extend_trial_status', 'approved')->where('user_id', $shop->id)->count();
        $allExtendFeature = ExtendTrial::count();
        $trialExtendStep = $extend_trial_requests . '/' . $allExtendFeature;
        $extendAllStep = "";
        $progress = 0;
        $stepsCompleted = 0;

        if ($extendTrialRequests == $allExtendFeature)
        {
            $extendAllStep = 1;
            $progress = 25;
            $stepsCompleted = 1;
        }

        return [
            'extend_all_step' => $extendAllStep,
            'progress' => $progress,
            'steps_completed' => $stepsCompleted,
            'trial_extend_step_progress' => $trialExtendStep,
        ];
    }

    public function mentoringWinners(Request $request)
    {

        $mentoringWinners = MentoringCall::setlimit($request)
            ->orderBy('id', 'desc')
            ->get();

            if($request->limit !== '' && $request->limit > 0)
            {
                $newMentoringWinner = [];
                foreach($mentoringWinners as $winner)
                {
                    $winner->url = 'mentoring';
                    $newMentoringWinner[] = $winner;
                }
                $mentoringWinners = $newMentoringWinner;
            }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => [
                'mentoring_winners' => $mentoringWinners
            ]
        ]);
    }

    public function shopPlansData($shop)
    {
        $addOnsCounts = $this->addOnsCounts($shop);
        $addons_count = $addOnsCounts['total'];

        // plans
        $freemium = 'Freemium';
        $starter = 'Starter';
        $hustler = 'Hustler';
        $guru = 'Master';
        $starterLimit = 5;
        $hustlerLimit = 30;
        $guruLimit = 41;

        $plan = $shop->alladdons_plan;
        $allAddonsPlan = $this->getAddonsPlan($shop);
        $add_ons_limit = $plan == $starter ? $starterLimit : ($plan == $hustler ?
            $hustlerLimit : ($plan == $guru ?
                $guruLimit : 0));

        $trial_days = $shop->trial_days;
        $trial_check = $shop->trial_check;
        $trial_plan = $guru;

        // if trial is over
        if ($trial_days == 0 || $trial_days == null)
        {
            $trial_days = null;
            $allAddons = $shop->all_addons;
            $subPlan = $shop->sub_plan;
        }
        // else fake hustler subscription for trial
        else {
            $allAddons = 1;
            $subPlan = 'Monthly';
            $add_ons_limit = $hustlerLimit;
        }

        return
            [
                'freemium' => $freemium,
                'starter' => $starter,
                'hustler' => $hustler,
                'guru' => $guru,
                'starter_limit' => $starterLimit,
                'hustler_limit' => $hustlerLimit,
                'guru_limit' => $guruLimit,
                'add_ons_limit' => $add_ons_limit,
                'all_addons' => $allAddons,
                'all_addons_plan' => $allAddonsPlan,
                'sub_plan' => $subPlan,
                'trial_days' => $trial_days,
                'add_ons_count_data' => $addOnsCounts,
                'shop_domain' => $shop->name,
                'trial_plan' => $trial_plan,
                'has_taken_free_subscription' => $shop->has_taken_free_subscription,
            ];
    }

    public function getShopAddOns($orderBy = null)
    {
        $shop = auth()->user();
        $userId = $shop->id;
        // Get the global addons and with the addons details from a user
        return GlobalAddons::with(['addons' => function ($query) use (&$userId) {
            $query->where('user_id', $userId);
        }])->orderBy('title')->get();
    }

    public function addOns(Request $request)
    {
        $shop = auth()->user();

        if (!$shop)
        {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ]);
        }

        $isUpdateBannerAddon = $this->isUpdatePending($shop);

        # AddOns leftJoin GlobalAddons
        $user_id = $shop->id;

        # Get the global addons and with the addons details from a user
        $globalAddOns = $this->getShopAddOns($request->get('orderBy'));

        # Get shop Themes Data
        $themesData = $this->getThemesData();

        $data = [
            'add_ons' => $globalAddOns,
            'themes' => $themesData,
            'is_update_banner_addon' => $isUpdateBannerAddon
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function addOnsInfo()
    {
        $addOnsInfo = AddOnInfo::orderBy('name')->get();
        $addOnsInfoCount = AddOnInfo::count();

        return [
            'data' => $addOnsInfo,
            'count' => $addOnsInfoCount
        ];
    }

    public function shopAddOns()
    {
        $shop = auth()->user();

        if (!$shop)
        {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ]);
        }

        $user_id = $shop->id;

        # Global AddOns with AddOns, filtered by user_id
        return GlobalAddons::with(['addons' => function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        }])->orderBy('title')->get();
    }

    public function addOnsCounts($shop)
    {
        # Add Ons
        $globalAddonsCount = AddOnInfo::count();
        $activeAddonsCount = $shop->addons()->active()->count();

        return [
            'total' => $globalAddonsCount,
            'active' => $activeAddonsCount
        ];
    }

    public function isUpdatePending($shop)
    {
        $isUpdatedAddons = false;

        if ($shop->is_updated_addon == 0)
        {

            $accessScopeData = $shop->api()->request(
                'GET',
                '/admin/oauth/access_scopes.json',
                []
            )['body']['access_scopes'] ?? '';

            $accessScopeData = (@$accessScopeData->container) ? $accessScopeData->container : false;

            if ($accessScopeData)
            {
                if (is_array($accessScopeData)) {
                    foreach ($accessScopeData as $key => $val)
                    {
                        $scopes[] = $val['handle'];
                    }
                    if (in_array("read_script_tags", $scopes) && in_array("write_script_tags", $scopes))
                    {

                        $cnt_addons = $shop->addons()->active()->count();

                        if ($cnt_addons > 0) {
                            $isUpdatedAddons = true;
                        } else {
                            $shop->is_updated_addon = 1;
                            $shop->save();
                        }
                    }
                }
            }
        }
        return $isUpdatedAddons;
    }

    public function winningProducts(Request $request)
    {
        $shop = auth()->user();

        $alladdons_plan = $this->getAddonsPlan($shop);
        $isBetaTester = $this->isBetaTester();

        $products = WinningProduct::GetByAddOnsPlan($alladdons_plan, $request, $isBetaTester); # Limit or paginate the request

        $this->formatWinningProducts($products);

        return response()->json([
            'success' => true,
            'message' => 'Fetch success',
            'data' => $products
        ]);
    }

    public function filterWinningProducts(StripePlan $plan, Request $request)
    {
        $shop = auth()->user();
        if (empty($shop)) return false;

        try {
            \Stripe\Stripe::setApiKey($this->stripe_key);

            $category = $request->get('profit') == 'all' ? '' : $request->get('profit');

            $shopSubscription = $this->shopSubscription();

            if ($shopSubscription && $shopSubscription['subscription_status'] == 'unpaid') {
                return response()->json([
                    'unpaid' => true,
                    'route' => route('plans')
                ]);
            }
            $allAddonsPlan = $this->getAddonsPlan($shop);

            $products = WinningProduct::filter($allAddonsPlan, $request, $shop);

            $this->formatWinningProducts($products);

            return response()->json([
                'success' => true,
                'message' => 'Fetched success!',
                'data' => [
                    'plan' => $plan,
                    'winning_products' => $products
                ]
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . $e->getTraceAsString(),
                'data' => []
            ]);
        }
    }

    public function formatWinningProducts($products)
    {
        if (!$products) return null;

        $winningProducts = [];

        foreach ($products as $key => $product)
        {
            $created_at = Carbon::parse($product->created_at);
            $days = $created_at->diffInDays(Carbon::now());

            $product->days = $days;
            $product->new_product = $days <= 7;
            $product->opinion = $this->formatContent($product->opinion);
            $product->description = $this->formatContent($product->description);
        }
    }

    public function courses(Request $request)
    {
        $paginate = isset($request->limit) && !empty($request->limit) ? $request->limit : 24;
        $courses = Course::orderBy('id', 'asc')->paginate($paginate);

        $data = [
            'courses' => $courses
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function viewCourse($id)
    {
        $shop = auth()->user();
        $course = Course::where('courses.id', $id)
            ->with(['modules.steps' => function ($query) {
                $query->orderBy('position', 'asc');
            }])->first();

        $course->sub_plans = explode(",", $course->plans);
        $course = json_decode($course);

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function generateVideoEmbedUrl($url)
    {
        //This is a general function for generating an embed link of an FB/Vimeo/Youtube Video.
        $finalUrl = '';

        if (strpos($url, 'facebook.com/') !== false)
        {

            //it is FB video
            $finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' .  rawurlencode($url) . '&show_text=1&width=200';
        } else if (strpos($url, 'vimeo.com/') !== false)
        {

            //it is Vimeo video
            $videoId = explode("vimeo.com/", $url)[1];
            if (strpos($videoId, '&') !== false)
            {
                $videoId = explode("&", $videoId)[0];
            }

            $finalUrl = 'https://player.vimeo.com/video/' . $videoId;
        }
        else if (strpos($url, 'youtube.com/') !== false)
        {

            //it is Youtube video
            $videoId = explode("v=", $url)[1];
            if (strpos($videoId, '&') !== false)
            {
                $videoId = explode("&", $videoId)[0];
            }

            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
        } else if (strpos($url, 'youtu.be/') !== false)
        {

            //it is Youtube video
            $videoId = explode("youtu.be/", $url)[1];
            if (strpos($videoId, '&') !== false)
            {
                $videoId = explode("&", $videoId)[0];
            }

            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
        }

        return $finalUrl;
    }

    public function getThemesData()
    {
        $shop = auth()->user();

        $themeCurrentVersion = '';
        $newVersion = false;

        $isBetaTester = $this->isBetaTester();
        $latestTheme = Themes::isBetaTheme($isBetaTester, true)->where('is_beta_theme', '1')
            ->orderBy('id', 'desc')
            ->first();

        if (empty($latestTheme)) {
            $latestTheme = Themes::orderBy('id', 'desc')
                ->where('is_beta_theme', '!=', '1')
                ->orWhereNull('is_beta_theme')
                ->first();
        }

        $newUpdateTheme = $shop->storeThemes()
            ->active()
            ->where('version', $latestTheme->version)
            ->count();

        $storeThemes = $shop->storeThemes()
            ->isBetaTheme($isBetaTester)->where('is_beta_theme', '1')
            ->active()
            ->orderByRoleAndLatest()
            ->get();

        $latestUploadedTheme = $shop->storeThemes()
            ->active()
            ->last();

        if (empty($storeThemes) || count($storeThemes) == 0) {
            $storeThemes = $shop->storeThemes()->active()->orderByRoleAndLatest()->get();
        }

        $themeCount = $shop->storeThemes()->isBetaTheme($isBetaTester)->count();

        if ($themeCount <= 0) {
            $themeCount = $shop->storeThemes()->active()->count();
        }


        if ($themeCount > 0) {
            if (!empty($shop->theme_id) &&  !empty($shop->shopify_theme_id)) {
                if ($latestTheme->id > $shop->theme_id) {
                    $newThemeUrl = $latestTheme->url;
                    $newVersion = true;
                }
            }
        }

        $prior_beta_theme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->where('is_beta_theme', '!=', 1)->orderBy('role', 'desc')->orderBy('id', 'desc')->count();

        $data = [
            'latest_theme' => $latestTheme,
            'store_themes' => $storeThemes,
            'store_themes_count' => count($storeThemes),
            'latest_uploaded_theme' => $latestUploadedTheme,
            'new_update_theme' => $newUpdateTheme,
            'new_version' => $newVersion,
            'prior_beta_theme' => $prior_beta_theme
        ];

        return $data;
    }

    public function themesData(Request $request)
    {
        $shop = Auth::user();
        $data = $this->getThemesData();

        $data['is_update_addons'] = $this->isUpdatePending($shop);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function refreshThemes(StripePlan $plan, Request $request)
    {
        $shop = auth()->user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ]);
        }

        $themes = $this->refreshThemeInternal($shop);
        $data = $this->getThemesData();
        $data['themes'] = $themes;

        return response()->json([
            'success' => true,
            'message' => __('messages.theme_refreshed_success_response'),
            'data' => $data,
        ]);
    }

    public function refreshThemeInternal($shop)
    {
        // $latest_theme = Themes::orderBy('id', 'desc')->first();
        $userId = $shop->id;
        $retries = 0;

        do {
            //get themes from store
            $shopThemes = $this->getShopThemes($shop);
            logger('retrying getShopThemes '. $retries);
            $retries ++ ;
            sleep(5);
        } while ($shopThemes == false && $retries < 5);

        if ($shopThemes) {
            foreach ($shopThemes as $shopTheme) {
                $themesCount = $shop->storethemes()->theme($shopTheme->id)->count();

                if ($themesCount == 0) {
                    try {
                        $schema = $this->shopApiGetSettingsSchema($shop, $shopTheme->id);

                        if ((strrpos($schema, 'debutify')) !== false || (strrpos($schema, 'Debutify')) !== false) {
                            # StoreThemes
                            $json = json_decode($schema);
                            $version = isset($json[0]->theme_version) ? $json[0]->theme_version : '';
                            $theme = Themes::where('version', $version)->orderBy('id', 'desc')->first();
                            $storeTheme = new StoreThemes;
                            $storeTheme->shopify_theme_id = $shopTheme->id;
                            $storeTheme->shopify_theme_name = $shopTheme->name;
                            $storeTheme->role = ($shopTheme->role == 'main') ? 1 : 0;
                            $storeTheme->status = 1;
                            $storeTheme->user_id = $shop->id;
                            $storeTheme->theme_id = $theme->id ?? null;
                            if (strrpos($schema, '2.0.') !== false) {
                                $storeTheme->is_beta_theme = 0;
                                $version = '2.0.2';
                            }
                            elseif(strrpos($schema , '3.0.') !== false)
                            {
                                $storeTheme->is_beta_theme = 0;
                            }
                            if($version)
                            {
                                $storeTheme->version = $version;
                            }
                            $storeTheme->save();
                        }
                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                        logger('theme created chron throws exception');
                    }
                } else {
                    try {
                        $schema = $this->shopApiGetSettingsSchema($shop, $shopTheme->id);

                        if ((strrpos($schema, 'debutify')) !== false || (strrpos($schema, 'Debutify')) !== false) {
                            # StoreThemes
                            $json = json_decode($schema);
                            $version = isset($json[0]->theme_version) ? $json[0]->theme_version : '';
                            $theme = Themes::where('version', $version)->orderBy('id', 'desc')->first();
                            $debutifyTheme = $shop->storethemes()->theme($shopTheme->id)->first();
                            $debutifyTheme->role = ($shopTheme->role == 'main') ? 1 : 0;
                            $debutifyTheme->status = 1;
                            $debutifyTheme->shopify_theme_name = $shopTheme->name;
                            $debutifyTheme->theme_id = $theme->id ?? null;
                            if (strrpos($schema, '2.0.') !== false) {
                                $debutifyTheme->is_beta_theme = 0;
                                $version = '2.0.2';
                            }
                            elseif(strrpos($schema , '3.0.') !== false)
                            {
                                $debutifyTheme->is_beta_theme = 0;
                            }
                            if($version)
                            {
                                $debutifyTheme->version = $version;
                            }
    
                            $debutifyTheme->save();
                        } else {
                            StoreThemes::deleteTheme($shopTheme->id);
                        }
                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                        logger('theme created chron throws exception');
                    }
                }
            }
        }

        sleep(2);

        try {
            $storeThemesRole = $shop->storeThemes()->where('role', 1)->first();
            if($storeThemesRole) {
                $activeThemeVersion = $storeThemesRole->version;
                $shopifyId = '';
                if($shop->shopify_raw) {
                    $shopifyId = json_decode($shop->shopify_raw)->id;
                } 
                else {
                    $shopData = getShopCurl($shop);
                    if (!$shopData) {
                        throw new Exception("Cannot fetch shop data (Domain {$shop->name})\n");
                    }
                    $shopifyId = $shopData['id'];
                }

                $storeThemes = $shop->storeThemes()->get();
                if (count($storeThemes) > 0) {
                    $isThemeInstalled = true;
                }

                $activeTheme = $storeThemes->where('role', '1')->first();
                if($activeTheme) {
                    $activeThemeVersion = $activeTheme->version;
                }

                $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopifyId];
                $contact = $client->contacts->search([
                    'pagination' => ['per_page' => 1],
                    'query' => $query,
                    'sort' => ['field' => 'name', 'order' => 'ascending'],
                ]);
                if ($contact->total_count) {
                    $client->contacts->update($contact->data[0]->id, [
                        'custom_attributes' => [
                            'debutify_theme_installed' => $isThemeInstalled,
                            'active_theme_version' => $activeThemeVersion
                        ],
                    ]);
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        $storeThemes = $shop->storeThemes()->active()->orderByRole()->get();

        foreach ($storeThemes as $storeTheme) {
            $themeId = $storeTheme->shopify_theme_id;

            try {
                $theme = $this->shopApiGetTheme($shop, $themeId);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $themeUpdated = StoreThemes::deletetheme($storeTheme->shopify_theme_id);

                if ($shop->shopify_theme_id == $storeTheme->id) {
                    # Shop
                    $shop->shopify_theme_id = null;
                    $shop->theme_id = null;
                    $shop->save();
                }
                logger('theme not found on shopify store');
            } catch (\Exception $e) {
                $themeUpdated = StoreThemes::deletetheme($storeTheme->shopify_theme_id);

                if ($shop->shopify_theme_id == $storeTheme->id) {
                    # Shop
                    $shop->shopify_theme_id = null;
                    $shop->theme_id = null;
                    $shop->save();
                }
                logger('theme not found on shopify store');
            }
        }
    }
    # Downlod theme function, used when user has an existing theme
    public function downloadTheme(Request $request)
    {
        $shop = Auth::user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ], 401);
        }
        //logger("Download theme by $shop->name");

        $isBetaTester = $this->isBetaTester();

        $latestTheme = Themes::isBetaTheme($isBetaTester, false)->where('is_beta_theme', '1')
            ->orderBy('id', 'desc')
            ->first();

        if (!isset($latestTheme) || empty($latestTheme)) {
            $latestTheme = Themes::orderBy('id', 'desc')
                ->where('is_beta_theme', '!=', '1')
                ->orWhereNull('is_beta_theme')->first();
        }

        $defaultThemeName = "Debutify $latestTheme->version";

        $countThemes = $shop->storeThemes()->themeName($defaultThemeName)->isBetaTheme($isBetaTester)->active()->count();

        // last() == orderBy('id', 'desc')->first()
        $lastTheme = $shop->storeThemes()->active()->isBetaTheme($isBetaTester)->last();

        //logger("here is the latestTheme: " . json_encode($latestTheme));
        // $latestTheme = Themes::orderBy('id', 'desc')->first();

        $themeName = $request->get('theme_name');

        // name theme
        if (empty($themeName)) {
            $themeName = $countThemes > 0 ?
                "Copy of $lastTheme->shopify_theme_name" :
                "Debutify $latestTheme->version";
        }

        $theme = [
            'theme' => [
                'name' => $themeName,
                'src' => $latestTheme->url
            ]
        ];
        try {
            $uploadThemeResponse = $this->shopApiUploadTheme($shop, $theme);
        } catch (\Exception $e) {
            $uploadThemeResponse = $e->getMessage();
        }

        // theme downloaded successfully
        if (isset($uploadThemeResponse['id'])) {
            # Shop
            $shop->theme_id = $latestTheme->id;
            $shop->theme_url = $latestTheme->url;
            $shop->lastactivity = new DateTime();
            $shop->shopify_theme_id = $uploadThemeResponse['id'];
            $shop->theme_check = 1;
            $shop->save();

            $themeCount = StoreThemes::theme($uploadThemeResponse['id'])
                ->active()
                ->isBetaTheme($isBetaTester)
                ->count();

            if ($themeCount == 0) {
                # Store Theme
                $storeTheme = new StoreThemes;
                $storeTheme->shopify_theme_id = $uploadThemeResponse['id'];
                $storeTheme->shopify_theme_name = $uploadThemeResponse['name'];
                $storeTheme->role = 0;
                $storeTheme->status = 1;
                $storeTheme->user_id = $shop->id;
                $storeTheme->version = $latestTheme->version;
                $storeTheme->theme_id = $latestTheme->id;

                if (isset($latestTheme->is_beta_theme) && $latestTheme->is_beta_theme == 1) {
                    $storeTheme->is_beta_theme = 1;
                } else {
                    $storeTheme->is_beta_theme = 0;
                }

                $storeTheme->save();
            }

            sleep(5);

            // install active add-ons on new theme
            $activatedAddons = AddOns::shop($shop->id)->active()->get();

            $updateAddOn = 0;

            if ($latestTheme->version == '2.0.2') {
                foreach ($activatedAddons as $key => $addon) {
                    $this->activateAddOns(
                        $addon->global_id,
                        $uploadThemeResponse['id'],
                        $updateAddOn,
                        $key
                    );
                }
            }

            if ($request->get('copy_old_settings') && $request->get('theme_id')) {
                logger("Update the theme started");

                $schemas = '';
                $retries = 0;

                // Try up to 10 times X 5 sec
                while (!$schemas && $retries <= 10) {
                    logger("Retrying: {$retries}");
                    $tempSchema = $shop->api()->request(
                        'GET',
                        '/admin/api/themes/' . $request->get('theme_id') . '/assets.json',
                        ['asset' => ['key' => 'config/settings_data.json']]
                    )['body']['asset']['value'] ?? '';
                    logger($tempSchema);
                    $decodedTempSchema = json_decode($tempSchema, true);

                    if (isset($decodedTempSchema['current']) && $decodedTempSchema['current']) {
                        $schemas = $tempSchema;
                        break;
                    }

                    $retries++;
                    sleep(5);
                }

                $themeCheck = StoreThemes::theme($request->get('theme_id'))->first();

                if (optional($latestTheme)->version != '2.0.2' && optional($themeCheck)->version == '2.0.2') {
                    logger('data updating for theme 3.0');
                    $json = json_decode($schemas, true);

                    $remove = '';
                    foreach ($json['current']['sections']['footer']['blocks'] as $b => $v) {
                        if ($v['type'] == 'social_medias') {
                            $remove = $b;
                        }
                    }
                    if ($remove) {
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
                }

                if (optional($latestTheme)->version != '3.0.4' && optional($themeCheck)->version == '3.0.4') {
                    logger('data updating for theme 3.0.5');

                    $json = json_decode($schemas, true);
                    if(Arr::has($json, ['current.sections.dbtfy-quantity-breaks.blocks'])) {
                        $json = Arr::except($json, ['current.sections.dbtfy-quantity-breaks.blocks']);
                        if(isset($json['current']['sections']['dbtfy-color-swatches']['settings'])) {
                            $json['current']['sections']['dbtfy-color-swatches']['settings'] = (object)array();
                        }
                        $schemas = json_encode($json);
                    }
                }

                $getOldSettingsSchema = $this->shopApiGetSettingsSchema($shop, $request->get('theme_id'));
                $updateNewSettingsSchema = $this->shopApiUpdateSettingsSchema($shop, $uploadThemeResponse['id'], $getOldSettingsSchema);
                sleep(5);
                $originalSchemas = $schemas;

                $updateSchemaSettings = $this->shopApiUpdateSchemaSettings(
                    $shop,
                    $uploadThemeResponse['id'],
                    $originalSchemas
                );

                if (optional($latestTheme)->version != '2.0.2' && optional($themeCheck)->version == '2.0.2') {
                    sleep(5);

                    //logger("Here is the retrieved schema");

                    $schemas = $shop->api()->request(
                        'GET',
                        '/admin/api/themes/' . $uploadThemeResponse['id'] . '/assets.json',
                        ['asset' => ['key' => 'config/settings_data.json']]
                    )['body']['asset']['value'];
                }
            }

            if ($request->get('copy_new_files') && $request->get('theme_id')) {
                logger("Came in to copy content");

                $copyFilesFrom = StoreThemes::theme($request->get('theme_id'))->first();

                $userThemeFileNames = getAllThemeFileNames($shop, $request->get('theme_id'));

                logger("Fetched all theme files");
                $themeFileNames = Themefile::where('theme_id', $copyFilesFrom->theme_id)->first();

                $themeFileContent = ThemefileContent::where('themefile_id', $themeFileNames->id)->first();
                $themeFileContent = json_decode($themeFileContent->themefile_content, true);
                $themeFileNames = json_decode($themeFileNames->file_names);

                logger("Starting loop on files");

                foreach ($userThemeFileNames as $userThemeFileName) {

                    if (
                        ($userThemeFileName == 'snippets/review-badge.liquid' ||
                            $userThemeFileName == 'snippets/review-widget.liquid') &&
                        $latestTheme->version != '2.0.2'
                    ) {
                        continue;
                    }

                    if (in_array($userThemeFileName, $themeFileNames)) {
                        //logger("Compairing: " . $userThemeFileName);
                        compairUpdateCommonFilesDiff(
                            $shop,
                            $userThemeFileName,
                            $uploadThemeResponse['id'],
                            $request->get('theme_id'),
                            $copyFilesFrom['version'],
                            $themeFileContent
                        );
                    } else {
                        //logger("Adding new file: " . $userThemeFileName);
                        putMissingThemeFile(
                            $shop,
                            $userThemeFileName,
                            $uploadThemeResponse['id'],
                            $request->get('theme_id')
                        );
                    }
                }
                logger("Looping complete");
            }


            # Success response
            $data = [
                'success' => true,
                'messages' => [
                    'toast' => __('messages.theme_download_success'),
                    'banner' => __('messages.theme_added_success', ['theme' => $themeName])
                ],
                'data' => [
                    'route' => route('theme_addons'),
                    'is_beta_theme' => $latestTheme->is_beta_theme
                ]
            ];

            $isThemeProcessing = $uploadThemeResponse['processing'];

            do {
                $isThemeProcessing = $this->getThemeProcessing($uploadThemeResponse['id']);
                $getNewSettingsSchema = $this->shopApiGetSettingsSchema($shop, $uploadThemeResponse['id']);
                sleep(1);
            } while ($isThemeProcessing === TRUE);

            if (!$isThemeProcessing) {
                $getOldSettingsSchema = $this->shopApiGetSettingsSchema($shop, $request->get('theme_id'));
                $updateNewSettingsSchema = $this->shopApiUpdateSettingsSchema($shop, $uploadThemeResponse['id'], $getOldSettingsSchema);
                sleep(5);
                if ($latestTheme->version != '2.0.2' && !empty($originalSchemas)) {
                    //logger("updating the data again");
                    $updateSchemaSettings = $this->shopApiUpdateSchemaSettings(
                        $shop,
                        $uploadThemeResponse['id'],
                        $originalSchemas
                    );
                    //logger($updateSchemaSettings);
                }
                $revertSettingsSchema = $this->shopApiUpdateSettingsSchema($shop, $uploadThemeResponse['id'], $getNewSettingsSchema);
                return response()->json($data);
            } else {
                do {
                    $isThemeProcessing = $this->getThemeProcessing($uploadThemeResponse['id']);
                    $getOldSettingsSchema = $this->shopApiGetSettingsSchema($shop, $request->get('theme_id'));
                    $updateNewSettingsSchema = $this->shopApiUpdateSettingsSchema($shop, $uploadThemeResponse['id'], $getOldSettingsSchema);
                    sleep(5);

                    if (!$isThemeProcessing) {
                        if ($latestTheme->version != '2.0.2' && !empty($originalSchemas)) {
                            //logger("updating the data again");
                            $updateSchemaSettings = $this->shopApiUpdateSchemaSettings(
                                $shop,
                                $uploadThemeResponse['id'],
                                $originalSchemas
                            );
                            //logger($updateSchemaSettings);
                        }
                    $revertSettingsSchema = $this->shopApiUpdateSettingsSchema($shop, $uploadThemeResponse['id'], $getNewSettingsSchema);
                    return response()->json($data);
                    }
                } while ($isThemeProcessing === TRUE);
            }
        } else {
            // theme download error
            $response = $this->themeDownloadError($shop); // with return response
            return response()->json($response);
        }
    }

    public function initialDownloadTheme(Request $request)
    {
        logger("theme_download_post");

        $shop = Auth::user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ], 401);
        }

        $isBetaTester = $this->isBetaTester();

        $latestTheme = Themes::isBetaTheme($isBetaTester, false)->orderBy('id', 'desc')->first();

        if (!isset($latestTheme) || empty($latestTheme)) {
            $latestTheme = Themes::orderBy('id', 'desc')->first();
        }

        $defaultThemeName = "Debutify $latestTheme->version";
        $countThemes = $shop->storeThemes()
            ->themeName($defaultThemeName)
            ->isBetaTheme($isBetaTester)
            ->active()
            ->count();

        $themeName = '';
        $themeName = $countThemes > 0 ?
            "Copy of Debutify $latestTheme->version" :
            "Debutify $latestTheme->version";

        $shop->theme_id = $latestTheme->id;
        $shop->theme_url = $latestTheme->url;
        $shop->save();

        $theme = array('theme' => array(
            'name' => $themeName,
            'src' => $latestTheme->url,
        ));

        try {
            $uploadThemeResponse  = $shop->api()->request(
                'POST',
                '/admin/api/themes.json',
                $theme
            )['body']['theme'];
        } catch (\Exception $e) {
            $uploadThemeResponse = $e->getMessage();
        }

        if (isset($uploadThemeResponse['id'])) {
            $shop->lastactivity = new DateTime();
            $shop->shopify_theme_id = $uploadThemeResponse['id'];
            $shop->theme_check = 1;
            $shop->save();

            $themeCount = $shop->storeThemes()
                ->theme($uploadThemeResponse['id'])
                ->isBetaTheme($isBetaTester)
                ->active()
                ->count();

            if ($themeCount == 0) {
                $storeTheme = new StoreThemes;
                $storeTheme->shopify_theme_id = $uploadThemeResponse['id'];
                $storeTheme->shopify_theme_name = $uploadThemeResponse['name'];
                $storeTheme->role = 0;
                $storeTheme->status = 1;
                $storeTheme->user_id = $shop->id;
                $storeTheme->version = $latestTheme->version;
                $storeTheme->theme_id = $latestTheme->id;

                if (isset($latestTheme->is_beta_theme) && $latestTheme->is_beta_theme == 1) {
                    $storeTheme->is_beta_theme = 1;
                } else {
                    $storeTheme->is_beta_theme = 0;
                }
                $storeTheme->save();

                try {
                    $shopifyId = '';
                    if($shop->shopify_raw) {
                        $shopifyId = json_decode($shop->shopify_raw)->id;
                    } 
                    else {
                        $shopData = getShopCurl($shop);
                        if (!$shopData) {
                            throw new Exception("Cannot fetch shop data (Domain {$shop->name})\n");
                        }
                        $shopifyId = $shopData['id'];
                    }

                    $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                    $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopifyId];
                    $contact = $client->contacts->search([
                        'pagination' => ['per_page' => 1],
                        'query' => $query,
                        'sort' => ['field' => 'name', 'order' => 'ascending'],
                    ]);

                    if ($contact->total_count) {
                        $client->contacts->update($contact->data[0]->id, [
                            'custom_attributes' => [
                                'debutify_theme_installed' => true,
                            ],
                        ]);
                    }
                } catch (\Exception $e) {
                    logger($e->getMessage());
                }
                
            }

            # Success response
            $data = [
                'success' => true,
                'messages' => [
                    'toast' => __('messages.theme_download_success'),
                    'banner' => __('messages.theme_added_success', ['theme' => $themeName])
                ],
                'data' => [
                    'route' => route('theme_view'),
                    'is_beta_theme' => $latestTheme->is_beta_theme
                ]
            ];

            $isThemeProcessing = $uploadThemeResponse['processing'];

            if (!$isThemeProcessing) {
                return response()->json($data);
            } else {
                do {
                    $isThemeProcessing = $this->getThemeProcessing($uploadThemeResponse['id']);

                    sleep(1);   //wait for 1 sec for next function call

                    if (!$isThemeProcessing) {
                        return response()->json($data);
                    }
                } while ($isThemeProcessing === TRUE);
            }
        } else {
            // theme download error
            $response = $this->themeDownloadError($shop);
            return response()->json($response);
        }
    }

    public function themeDownloadError($shop)
    {
        try {

            $shopifyThemes = $this->getShopThemes($shop);
            $themeCount = count($shopifyThemes);
            $message = $themeCount >= 20 ?
                __('messages.theme_reached_maximum') :
                __('messages.error_response');

            return [
                'status' => false,
                'message' => $message
            ];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            logger('getting themes throws client exception');
            logger($e->getMessage() . $e->getTraceAsString());

            return [
                'status' => false,
                'message' => __('messages.error_response')
            ];
        } catch (\Exception $e) {
            logger('getting themes throws exception');
            logger($e->getMessage() . $e->getTraceAsString());

            return [
                'status' => false,
                'message' => __('messages.error_response')
            ];
        }
    }

    public function activateAddOns($addon_id, $themes_id, $updateAddon, $key)
    {
        $shop = auth()->user();
        $StoreTheme = $shop->storethemes()->theme($themes_id)->active()->get();
        $delivery_addon_activated = $shop->addons()->active()->global(4)->count();
        $addon_count = $shop->addons()->active()->count();
        $StoreThemes = [];

        foreach ($StoreTheme as $theme) {
            try {
                $get_theme = $this->shopApiGetTheme($shop, $theme->shopify_theme_id);
                $StoreThemes[] = $theme;
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                logger('update schema on live view addon throws client exception');
            } catch (\Exception $e) {
                logger('update schema on live view addon throws exception');
            }
        }


        if ($StoreThemes) {
            // add dbtfy scripts (function in helper.php)
            if ($key == 0) {
                add_debutify_JS($StoreThemes, $shop);
                sleep(2);
                addScriptTag($shop);
                if ($shop->script_tags) {
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
                    if ($updateAddon == 1) {
                        activate_producttab_addon_js($StoreThemes, $shop);
                    } else {
                        activate_producttab_addon($StoreThemes, $shop);
                    }
                    break;
                case 9:
                    activate_chatbox_addon($StoreThemes, $shop);
                    break;
                case 10:
                    if ($updateAddon == 1) {
                        activate_faqepage_addon_js($StoreThemes, $shop);
                    } else {
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
                    if ($updateAddon == 1) {
                        activate_mega_menu_addon_js($StoreThemes, $shop);
                    } else {
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

    public function deactivateAddOns($shop, $StoreThemes, $addon_id, $checkaddon, $updateAddon)
    {
        if ($StoreThemes) {

            $tempThemes = array();
            foreach ($StoreThemes as $t) {
                if ($t->version == '2.0.2') {
                    $tempThemes[] = $t;
                }
            }
            if (!empty($tempThemes)) {
                $StoreThemes = $tempThemes;
            } else {
                return true;
            }

            // remove dbtfy scripts (function in helper.php)
            if ($checkaddon == 1) {
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
                    deactivate_producttabs_addon($StoreThemes, $shop, $checkaddon, $updateAddon);
                    break;
                case 9:
                    deactivate_chatbox_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 10:
                    deactivate_faqepage_addon($StoreThemes, $shop, $checkaddon, $updateAddon);
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
                    deactivate_mega_menu_addon($StoreThemes, $shop, $checkaddon, $updateAddon);
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
    public function shopSubscription()
    {
        $shop = auth()->user();
        // trial
        $getStripeSubscription = null;
        $getPaypalSubscription = null;
        $billingDate = null;
        $date = new DateTime();
        $mainSubscription = $shop->mainSubscription;
        $subscriptionStatus = '';
        $showEndAt = Carbon::now()->addWeek()->format('M. d, Y');
        $trialEndDate = 7;
        $approveLink = [];

        try {
            if (isset($mainSubscription))
            {
                $paymentPlatform = $mainSubscription->payment_platform;


                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE)
                {
                    \Stripe\Stripe::setApiKey($this->stripe_key);
                    $subscription = $shop->stripeSubscription()->latest()->first();

                    if ($subscription && isset($subscription->stripe_id))
                    {
                        $getStripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_id);
                        $date->setTimestamp($getStripeSubscription->current_period_end);
                        $newFormat = $date->format('Y-m-d');
                        $billingDate = $newFormat;

                        if (isset($subscription->trial_ends_at) && $subscription->trial_ends_at != null)
                        {
                            $dates = new DateTime();
                            $newFormats = $dates->format('Y-m-d');
                            $dates = new DateTime($subscription->trial_ends_at);
                            $endAt = $dates->format('Y-m-d');
                            if ($endAt >= $newFormats)
                            {
                                $showEndAt = $dates->format('M. d, Y');
                                $diff = strtotime($newFormats) - strtotime($endAt);
                                $days = abs(round($diff / 86400));
                                $trialEndDate = $days;
                            }
                        }

                        ## Assign the current subscription status
                        if ($getStripeSubscription->status == 'past_due') {
                            $subscriptionStatus = 'past_due';
                        } else if ($getStripeSubscription->status == 'unpaid') {
                            $subscriptionStatus = 'unpaid';
                            $shop->license_key = null;

                            if ($shop->script_tags) {
                                deleteScriptTagCurl($shop);
                            }
                        } else if ($getStripeSubscription->status == 'active') {
                            $subscriptionStatus = 'active';
                            $licenseKey = Hash::make(Str::random(12));
                            $shop->license_key = $licenseKey;

                            if ($shop->script_tags) {
                                addScriptTag($shop);
                            }
                        }

                        $shop->save();
                    }
                }

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL)
                {
                    $subscription = $shop->paypalSubscription()->active()->first();

                    if ($subscription && isset($subscription->paypal_id))
                    {
                        $paypalSubId = $subscription->paypal_id;
                        $getPaypalSubscription = fetchPaypalSubscriptionStatus($paypalSubId);

                        if (@$getPaypalSubscription['statusCode'] == 200)
                        {
                            if (@$getPaypalSubscription['response']['status'] == 'ACTIVE')
                            {
                                $newFormat = Carbon::parse(@$getPaypalSubscription['response']['billing_info']['next_billing_time'])->toDateString();
                                $billingDate = $newFormat;
                                if (isset($subscription->trial_ends_at) && $subscription->trial_ends_at != null) {
                                    $dates = new DateTime();
                                    $newFormats = $dates->format('Y-m-d');
                                    $dates = new DateTime($subscription->trial_ends_at);
                                    $endAt = $dates->format('Y-m-d');

                                    if ($endAt >= $newFormats)
                                    {
                                        $showEndAt = $dates->format('M. d, Y');
                                        $diff = strtotime($newFormats) - strtotime($endAt);
                                        $days = abs(round($diff / 86400));
                                        $trialEndDate = $days;
                                    }
                                }
                            }

                            if (@$getPaypalSubscription['response']['status'] == 'EXPIRED') {
                                $subscriptionStatus = 'past_due';
                            } else if (
                                @$getPaypalSubscription['response']['status'] == 'CANCELLED'||
                                @$getPaypalSubscription['response']['status'] == 'SUSPENDED'
                            ) {
                                $subscriptionStatus = 'unpaid';
                                $shop->license_key = null;

                                if ($shop->script_tags) {
                                    deleteScriptTagCurl($shop);
                                }
                            } else if (@$getPaypalSubscription['response']['status'] == 'ACTIVE') {
                                $subscriptionStatus = 'active';
                                $license_key = Hash::make(Str::random(12));
                                $shop->license_key = $license_key;

                                if ($shop->script_tags) {
                                    addScriptTag($shop);
                                }
                            }

                            $shop->save();
                        }
                    } else {
                        $showEndAt = Carbon::now()->addWeek()->format('M. d, Y');
                        $trialEndDate = "7";
                    }
                }
            }

            return [
                'show_end_at' => $showEndAt,
                'trial_end_date' => $trialEndDate,
                'subscription' => $subscription ?? null,
                'subscription_status' => $subscriptionStatus,
                'paypal_subscription' => $getPaypalSubscription,
                'stripe_subscription' => $getStripeSubscription
            ];

        } catch (\Exception $e) {
            logger("Shop Subscription error = " . $e->getMessage());
        }
    }

    public function partners(StripePlan $plan, Request $request)
    {
        $query = Partner::orderBy('created_at', 'desc');

        if ($request->has('category') && !empty($request->category) ){
            $query->whereJsonContains('categories', $request->category);
        }

        $partners = $query->get();

        //Logic to add a tag "New" for integrations added in the last month & sort partners by New -> Popular -> Newest to oldest
        $lastMonthDate = Carbon::now()->subMonth(1)->format('Y-m-d');

        $partners->each(function ($item, $key) use($lastMonthDate) {

            $item->newTag=null;

            if ($item->created_at >= $lastMonthDate) {
                $item->order = 1;
                $item->newTag= 1;
            }
            else if($item->popular == 1) {
                $item->order = 2;
            }
            else {
                $item->order = 3;
            }
        });

       $newCollection =  $partners->sortBy('order');

        return response()->json([
            'success' => true,
            'data' => $newCollection->values()->all()
        ]);
    }

    public function checkMasterStore($shop)
    {
        $masterShopName = '';
        $shopSubscription = $this->shopSubscription();
        $childStore = ChildStore::where('store', $shop->name)->first();
        if(isset($childStore->user_id) && !empty($childStore->user_id)){
            $masterShop = User::where('id', $childStore->user_id)->first();

            if($masterShop){
                $shop->all_addons = 1;
                $shop->alladdons_plan = $masterShop->alladdons_plan;
                $shop->sub_plan = $masterShop->sub_plan;
                $shop->is_paused = $masterShop->is_paused;

                if($shop->is_paused == true){
                    $pause_plan_data = unserialize($masterShop->pause_subscription);
                    if(isset($pause_plan_data['plan_name']) && !empty($pause_plan_data['plan_name'])){
                      $paused_plan_name = $pause_plan_data['plan_name'];
                    }
                }

                // license key created
                $license_key = Hash::make(Str::random(12));
                $shop->license_key = $license_key;
                $shop->save();
                return $masterShop->name;
            }
        }

        if ( ! isset($shopSubscription['subscription']) || empty($shopSubscription['subscription']) ) {
            return $masterShopName;
        }

        $date = new DateTime();
        $mainSubscription = $shop->mainSubscription;
        $getStripeSubscription = $shopSubscription['stripe_subscription'];
        $getPaypalSubscription = $shopSubscription['paypal_subscription'];
        $subscription = $shopSubscription['subscription'];

        if ($shop->master_account != 1) {
            # Subscription
            \Stripe\Stripe::setApiKey($this->stripe_key);

            $childStore = ChildStore::firststore($shop->name);
            if (isset($childStore->user_id)) {
                $masterShop = User::where('id', $childStore->user_id)->get();

                if ($masterShop) {
                    $masterShopName = $masterShop->name;

                    // guru plan of child store
                    $shop->all_addons = 1;
                    $shop->alladdons_plan = $masterShop->alladdons_plan;
                    $shop->sub_plan = $masterShop->sub_plan;
                    $shop->is_paused = $masterShop->is_paused;

                    if ($shop->is_paused) {
                        $pausedPlanData = unserialize($masterShop->pause_subscription);
                        if (isset($pausedPlanData['plan_name']) && !empty($pausedPlanData['plan_name'])) {
                            $pausedPlanName = $pausedPlanData['plan_name'];
                        }
                    }

                    // license key created
                    $licenseKey = Hash::make(Str::random(12));
                    $shop->license_key = $licenseKey;
                    $shop->save();

                    if ($shop->script_tags) {
                        addScriptTag($shop);
                    }
                }
            } else {
                if ($subscription && $subscription->stripe_id) {
                    if ($getStripeSubscription->status == "canceled") {
                        if ($shop->all_addons == 1) {
                            $this->deleteAllAddOns($shop, 'child', 1);
                            $subscription->ends_at = $date;
                            $subscription->save();
                        }
                    }
                }

                if ($subscription && $subscription->paypal_id && isset($getPaypalSubscription['response']['status'])) {
                    if ($getPaypalSubscription['response']['status'] == "CANCELLED") {
                        if ($shop->all_addons == 1) {
                            $this->deleteAllAddOns($shop, 'child', 1);
                            $subscription->ends_at = $date;
                            $subscription->save();
                        }
                    }
                }
            }
        } else {
            if ($subscription && $subscription->stripe_id) {
                if ($getStripeSubscription->status == "canceled") {
                    if ($shop->all_addons == 1) {
                        $this->deleteAllAddOns($shop, 'master', 1);
                        $subscription->ends_at = $date;
                        $subscription->save();
                    }
                }
                if (isset($getPaypalSubscription) && $getPaypalSubscription['response']['status'] == "CANCELLED") {
                    if ($shop->all_addons == 1) {
                        $this->deleteAllAddOns($shop, 'child', 1);
                        $subscription->ends_at = $date;
                        $subscription->save();
                    }
                }
            }
        }

        return $masterShopName;
    }

    public function childStores($shop)
    {
        $childStores = [];
        if ($shop->master_account != 1) return $childStores;

        $childStores = $shop->childstores()->get();

        return $childStores;
    }

    // install add-on function
    public function installAddOn(Request $request)
    {
        $shop = auth()->user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ], 401);
        }

        if (!$shop->modified_all_addons) {
            return response()->json([
                'success' => false,
                'message' => __('messages.plan_unauthorized_response')
            ], 403);
        }

        try {
            \DB::beginTransaction();

            #AddOns
            $addon_count = $shop->addons()->global($request->addon_id)->count();
            $totalActiveAddons = $shop->addons()->active()->count();

            $shopPlansData = $this->shopPlansData($shop);

            $maximum_addon_limit = $shopPlansData['add_ons_limit'];

            if ($totalActiveAddons < $maximum_addon_limit) {
                if ($addon_count == 0) {
                    # AddOns
                    $addon = new AddOns;
                    $addon->global_id       = $request->addon_id;
                    $addon->user_id         = $shop->id;
                    $addon->status          = 1;
                    $addon->shedule_time    = 1;
                    $addon->save();
                } else {
                    # AddOns
                    $addon = $shop->addons()->global($request->addon_id)->first();
                    $addon->status = 1;
                    $addon->shedule_time = 1;
                    $addon->save();
                }

                // save last activity in shop
                $shop->lastactivity = new DateTime();
                $shop->save();

                $updateAddon = 0;
                $key = 0;

                $this->activateAddOns($request->addon_id, $request->theme_id, $updateAddon, $key);

                # StoreThemes
                $storeTheme = $shop->storethemes()->theme($request->theme_id)->first();

                # GlobalAddons
                $globalAddOns = GlobalAddons::find($request->addon_id);

                $message = "You successfully installed {$globalAddOns->title} on {$storeTheme->shopify_theme_name}";

                # Global AddOns with AddOns, filtered by Id
                $add_ons = $this->shopAddOns();

                \DB::commit();

                return response()->json([
                    'success' => true,
                    'data' => [
                        'theme_id' => $request->get('theme_id'),
                        'action' => 'installed',
                        'add_ons' => $add_ons
                    ],
                    'messages' => [
                        'banner' => $message,
                        'toast' => 'Add-On installed'
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'messages' => [
                        'banner' => false,
                        'toast' => 'You\'ve reached the maximum allowed number of installed Add-Ons.'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            \DB::rollback();

            return response()->json([
                'success' => false,
                'messages' => [
                    'banner' => false,
                    'toast' => $e->getMessage()
                ]
            ]);
        }
    }

    // Delete all addons function
    public function deleteAllAddOns($shops, $action)
    {
        $storeTheme = $shops->storethemes()->active()->get();
        $shops->all_addons = null;
        $shops->alladdons_plan = 'Freemium';
        $shops->sub_plan = null;
        $shops->license_key = null;
        $shops->pause_subscription = null;
        $shops->is_paused = null;

        $shops->save();

        $addons = $shops->addons()->active()->get();

        $checkaddon = 1;

        $updateAddon = 0;

        if(count($addons) > 0) {
            foreach ($addons as $addon) {
                $this->deactivateAddOns($shops, $storeTheme, $addon->global_id, $checkaddon, $updateAddon);

                sleep(2);

                no_addon_activate_curl($storeTheme, $shops);

                $addon->status = 0;
                $addon->shedule_time = 0;
                $addon->save();
            }
        }
        else {

            //if no addons present then  just delete script tags
            deleteScriptTagCurl($shops);
        }
    }

    // delete or uninstall add-on function
    public function deleteAddon(Request $request)
    {
        $shop = auth()->user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ], 401);
        }

        $shopStoreThemes = [];
        $isBetaTester = $this->isBetaTester();

        # StoreThemes
        $storeThemes = $shop->storeThemes()->isBetaTheme($isBetaTester)->active()->get();

        if (!count($storeThemes)) {
            $storeThemes = $shop->storethemes()->active()->get();
        }

        try {
            # AddOns
            $addon = $shop->addons()->global($request->get('addon_id'))->first();

            foreach ($storeThemes as $theme) {
                try {
                    $getTheme = $this->shopApiGetTheme($shop, $theme->shopify_theme_id);

                    $shopStoreThemes[] = $theme;
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    logger('update schema on live view addon throws client exception');
                } catch (\Exception $e) {
                    logger('update schema on live view addon throws exception');
                }
            }

            # AddOns
            $addon_count = $shop->addons()->active()->count();

            $checkaddon = $addon_count <= 1 ? 1 : 0;
            $updateAddon = 0;

            $addon->status = 0;
            $addon->shedule_time = 0;
            $addon->save();

            $this->deactivateAddOns($shop, $shopStoreThemes, $request->get('addon_id'), $checkaddon, $updateAddon);

            $add_ons = $this->shopAddOns();

            return response()->json([
                'success' => true,
                'data' => [
                    'action' => 'uninstalled',
                    'add_ons' => $add_ons
                ],
                'messages' => [
                    'banner' => null,
                    'toast' => 'Add-On uninstalled',
                ]
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . $e->getTraceAsString()
            ], 500);
        }
    }

    // update add-on function
    public function updateAddon(Request $request)
    {
        $shop = auth()->user();

        $isBetaTester = $this->isBetaTester();
        // return response()->json($shop->storeThemes()->theme($request->get('theme_id'))->isBetaTheme($isBetaTester)->get());

        # StoreThemes - get theme by theme_id
        $storeTheme = $shop->storeThemes()->theme($request->get('theme_id'))->isBetaTheme($isBetaTester)->get();
        $storeThemes = [];

        if (!count($storeTheme)) {
            $storeTheme = $shop->storeThemes()->theme($request->get('theme_id'))->active()->get();
        }

        # AddOns - count active filtered by global id
        $deliveryAddOnActivated = $shop->addons()->active()->global(4)->count();

        foreach ($storeTheme as $storeTheme) {
            try {
                $get_theme = $this->shopApiGetTheme($shop, $storeTheme->shopify_theme_id);
                $storeThemes[] = $storeTheme;
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                logger('update schema on live view addon throws client exception');
            } catch (\Exception $e) {
                logger('update schema on live view addon throws exception');
            }
        }

        // save last activity in shop
        $shop->lastactivity = new DateTime();
        $shop->save();

        $checkaddon = 0;
        $updateAddon = 1;
        $key = 0;

        $this->deactivateAddOns($shop, $storeThemes, $request->get('addon_id'), $checkaddon, $updateAddon);

        sleep(3);

        $this->activateAddOns($request->get('addon_id'), $request->get('theme_id'),  $updateAddon, $key);

        # StoreThemes
        $storeTheme = $shop->storethemes()->theme($request->get('theme_id'))->first();

        # GlobalAddons
        $globalAddOns = GlobalAddons::find($request->addon_id);

        return response()->json([
            'success' => true,
            'data' => [
                'theme_id' => $request->get('theme_id')
            ],
            'messages' => [
                'banner' => "You successfully updated {$globalAddOns->title} on {$storeTheme->shopify_theme_name}",
                'toast' => 'Add-On updated',
            ]
        ]);
    }

    // install all addons
    public function installAllAddOns(Request $request)
    {
        $shop = auth()->user();

        $shopPlansData = $this->shopPlansData($shop);

        if ($shopPlansData['all_addons'] != 1) {
            return response()->json([
                'success' => false,
                'data' => [],
                'messages' => [
                    'banner' => null,
                    'toast' => __('messages.plan_unauthorized_response')
                ]
            ]);
        }

        $isBetaTester = $this->isBetaTester();
        $storeTheme = $shop->storeThemes()->theme($request->get('theme_id'))->IsBetaTheme($isBetaTester)->first();
        $checkaddon = 0;
        $updateAddOn = 0;

        if (!$storeTheme) {
            $storeTheme = $shop->storeThemes()->theme($request->get('theme_id'))->active()->first();
        }

        try {
            /* save in store */

            if(is_array($request->get('addons'))) {
                foreach ($request->get('addons') as $key => $addon) {
                    sleep(1);
                    $this->activateAddOns($addon, $request->get('theme_id'),  $updateAddOn, $key);
                }
            }

            $shop->lastactivity = new DateTime();

            $shop->save();

            if(is_array($request->get('addons'))) {
                foreach ($request->get('addons') as $global) {
                    $addOnCount = $shop->addons()->global($global)->count();

                    if ($addOnCount == 0) {
                        #AddOns
                        $addon = new AddOns;
                        $addon->global_id = $global;
                        $addon->user_id = $shop->id;
                        $addon->status = 1;
                        $addon->shedule_time = 1;
                        $addon->invoiceitem = null;
                        $addon->save();
                    } else {
                        #AddOns
                        $addon = $shop->addons()->global($global)->first();
                        $addon->status = 1;
                        $addon->shedule_time = 1;
                        $addon->invoiceitem = null;
                        $addon->save();
                    }
                }
            }

            # GlobalAddons with addons, filtered by id
            $addOns = $this->shopAddOns();

            return response()->json([
                'success' => true,
                'data' => [
                    'add_ons' => $addOns
                ],
                'messages' => [
                    'banner' => "You successfully installed all selected Add-Ons on {$storeTheme->shopify_theme_name}",
                    'toast' => 'All selected Add-Ons installed'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => __('messages.error_response')
            ]);
        }
    }

    public function updateActiveAddOns(Request $request)
    {
        $shop = auth()->user();
        $isBetaTester = $this->isBetaTester();

        # StoreThemes
        $storeTheme = $shop->storethemes()
            ->theme($request->get('theme_id'))
            ->isBetaTheme($isBetaTester)
            ->active()
            ->get();

        // save last activity in shop
        $shop->lastactivity = new DateTime();
        $shop->save();

        if ($storeTheme) {
            $checkaddon = 0;
            $updateAddOn = 1;

            if(is_array($request->get('addons'))) {
                foreach ($request->get('addons') as $key => $addon) {
                    $this->deactivateAddOns($shop, $storeTheme, $addon, $checkaddon, $updateAddOn, $key);
                }

                sleep(1);

                foreach ($request->get('addons') as $key => $addon) {
                    $this->activateAddOns($addon, $request->get('theme_id'), $updateAddOn, $key);
                }
            }
        }

        # Global AddOns with AddOns, filtered by Id
        $add_ons = $this->shopAddOns();

        return response()->json([
            'success' => true,
            'data' => [
                'addons' => $add_ons
            ],
            'messages' => [
                'banner' => __('messages.addon_selected_update_success_response', [
                    'theme' => $storeTheme[0]['shopify_theme_name'] ?? ''
                ]),
                'toast' => __('messages.addon_selected_update_success_toast_response')
            ]
        ]);
    }

    // force update all add-ons function
    public function forceUpdateAllActiveAddOns(Request $request)
    {
        $shop = auth()->user();
        if (!$shop) return false;

        $this->refreshThemeInternal($shop);

        $isBetaTester = $this->isBetaTester();

        # StoreThemes
        $storeThemes = $shop->storethemes()
            ->theme($request->get('theme_id'))
            ->isBetaTheme($isBetaTester)
            ->active()
            ->get();

        if (!count($storeThemes)) {
            $storeThemes = $shop->storeThemes()->active()->get();
        }


        no_addon_activate($storeThemes, $shop);

        if (count($storeThemes) > 0) {
            // save last activity in shop
            $shop->lastactivity = new DateTime();
            $shop->save();

            $allAddons = $shop->addons()->active()->get();

            foreach ($storeThemes as $skey => $theme) {

                # StoreThemes
                $storeTheme = $shop->storethemes()
                    ->theme($theme->shopify_theme_id)
                    ->isBetaTheme($isBetaTester)
                    ->active()
                    ->get();

                if ($storeTheme) {
                    $checkaddon = 0;
                    $updateAddon = 1;

                    foreach ($allAddons as $key => $addOn) {
                        $this->deactivateAddOns($shop, $storeTheme, $addOn->global_id, $checkaddon, $updateAddon);
                    }

                    sleep(2);

                    foreach ($allAddons as $key => $addOn) {
                        logger('add loop begins');
                        logger('$addOn->global_id: ' . $addOn->global_id);
                        logger('$theme->shopify_theme_id: ' . $theme->shopify_theme_id);
                        logger('$key: ' . $key);

                        $this->activateAddOns(
                            $addOn->global_id,
                            $theme->shopify_theme_id,
                            $updateAddon,
                            $key
                        );
                    }
                }
            }
        }

        $shop->is_updated_addon = 1;
        $shop->save();

        // $request->session()->flash('status', 'Debutify Theme Manager Updated');
        // $request->session()->flash('addons-updated', 'Addons Updated');

        # Global AddOns with AddOns, filtered by Id
        $add_ons = $this->shopAddOns();

        return response()->json([
            'success' => true,
            'data' => [
                'add_ons' => $add_ons,
                'route' => route('theme_addons')
            ],
            'messages' => [
                'banner' => null,
                'toast' => 'Addons Updated'
            ]
        ]);
    }

    # Delete multiple addons
    public function deleteMultipleAddOns(Request $request)
    {
        try {
            $shop = Auth::user();

            $storeThemes = $shop->storeThemes()->active()->get();
            $shopThemes = [];

            foreach ($storeThemes as $storeTheme) {
                try {
                    $getTheme = $this->shopApiGetTheme($shop, $storeTheme->shopify_theme_id);
                    $shopThemes[] = $storeTheme;
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    logger('update schema on live view addon throws client exception');
                } catch (\Exception $e) {
                    logger('update schema on live view addon throws exception');
                }
            }

            if(is_array($request->get('addons'))) {
                foreach ($request->get('addons') as $key => $addOn) {
                    $selectedAddOn = $shop->addons()->global($addOn)->first();
                    $selectedAddOnsCount = $shop->addons()->active()->count();

                    if (isset($selectedAddOn)) {
                        $checkAddOn = $selectedAddOnsCount <= 1 ? 1 : 0;
                        $selectedAddOn->status = 0;
                        $selectedAddOn->shedule_time = 0;
                        $selectedAddOn->save();
                        $updateAddon = 0;
                        $this->deactivateAddOns($shop, $shopThemes, $addOn, $checkAddOn, $updateAddon);
                    }
                }
            }

            $shopAddOns = $this->getShopAddOns();

            $request->session()->flash('status', 'Add-On uninstalled');

            $route = !empty($request->get('referrer_url')) ? $request->get('referrer_url') : route('plans');

            $data = [
                'redirect_url' => $route,
                'add_ons' => $shopAddOns
            ];

            return response()->json([
                'success' => true,
                'messages' => __('messages.addons_uninstalled'),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('messages.error_response')
            ]);
        }
    }

    public function billing()
    {
        $shop = auth()->user();

        try {
            \Stripe\Stripe::setApiKey($this->stripe_key);
            $cardExpire = '';
            $cardNumber = '';
            $cardBrand = '';
            $upcomingInvoice = '';
            $recentInvoice = '';
            $stripeSubs = '';
            $currentPaypalBilling = '';
            $previousPaypalSubscriptions = [];

            $cardData = $this->stripeCardData();

            if (!empty($cardData)) {
                $cardExpireMonth = $cardData->exp_month;
                $cardExpireYear = $cardData->exp_year;

                if ($cardExpireMonth < 10) {
                    $cardExpireMonth = '0' . $cardExpireMonth;
                }

                $cardExpire = "{$cardExpireMonth}/{$cardExpireYear}";
                $cardNumber = $cardData->last4;
                $cardBrand = $cardData->brand;
            }

            # ChildStore count
            $storeCount = $shop->childstores()->count();
            $storeLimit = 2;
            $prevSubscriptionsInvoice = '';
            $accountBalance = '';

            $mainSubscription = $shop->mainSubscription;

            if (isset($mainSubscription)) {
                $paymentPlatform = $mainSubscription->payment_platform;

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                    // subscription active
                    $subscription = $shop->stripeSubscription()->active()->first();

                    try {
                        if ($subscription) {
                            $stripeSubs = \Stripe\Subscription::retrieve($subscription->stripe_id);
                            try {
                                $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $shop->stripe_id]);
                            } catch (\Exception $e) {
                                logger('No upcoming invoice for ' . $shop);
                                $upcomingInvoice = '';
                            }
                        }

                        // all previous invoices
                        $prevSubscriptionsInvoice = \Stripe\Invoice::all(["customer" => $shop->stripe_id]);

                        // account balance
                        $accountBalance = \Stripe\Customer::retrieve($shop->stripe_id);
                    } catch (\Stripe\Exception\CardException $e) {
                        logger("Since it's a decline, \Stripe\Error\Card will be caught");
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        return response()->json([
                            'success' => false,
                            'message' => $err['message'],
                            'data' => [
                                'route' => route('theme_addons')
                            ]
                        ]);
                    } catch (\Stripe\Exception\RateLimitException $e) {
                        logger("Too many requests made to the API too quickly");
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        return response()->json([
                            'success' => false,
                            'message' => $err['message'],
                            'data' => [
                                'route' => route('theme_addons')
                            ]
                        ]);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        logger("Invalid parameters were supplied to Stripe's API, error=" . $err['message']);
                        return response()->json([
                            'success' => false,
                            'message' => $err['message'],
                            'data' => [
                                'route' => route('theme_addons')
                            ]
                        ]);
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                        logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        return response()->json([
                            'success' => false,
                            'message' => $err['message'],
                            'data' => [
                                'route' => route('theme_addons')
                            ]
                        ]);
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                        logger("Network communication with Stripe failed");
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        return response()->json([
                            'success' => false,
                            'message' => $err['message'],
                            'data' => [
                                'route' => route('theme_addons')
                            ]
                        ]);
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        logger("Display a very generic error to the user, and maybe send yourself an email");
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        return response()->json([
                            'success' => false,
                            'message' => $err['message'],
                            'data' => [
                                'route' => route('theme_addons')
                            ]
                        ]);
                    } catch (\Exception $e) {
                        $body = $e->getMessage();
                        logger("Something else happened, completely unrelated to Stripe: " . $body);
                        return response()->json([
                            'success' => false,
                            'message' => $body,
                            'data' => [
                                'route' => route('plans')
                            ]
                        ]);
                    }
                }

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                    // subscription active
                    $subscriptions = $shop->paypalSubscription()->activeOrSuspended()->first();
                    $last_sixmonth_date = Carbon::now()->subMonth(6)->format('Y-m-d');
                    $end_date = Carbon::now()->addDay(2)->format('Y-m-d');

                    if ($subscriptions) {
                        $subId = $subscriptions->paypal_id;
                        $activePaypalBilling = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}"))->json();
                        $activePaypalBilling['billing_info']['id'] = $activePaypalBilling['id'];

                        if ($activePaypalBilling['status'] != 'CANCELLED') {
                            $currentPaypalBilling = $activePaypalBilling['billing_info'];
                        }
                        logger("My debug");
                        logger(getPaypalUrl("v1/billing/subscriptions/${subId}/transactions?start_time=${last_sixmonth_date}T00:00:00.940Z&end_time=${end_date}T00:00:00.940Z"));
                        logger(getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}/transactions?start_time=${last_sixmonth_date}T00:00:00.940Z&end_time=${end_date}T00:00:00.940Z"))->json());
                        logger("End of debug");

                        // all previous invoices
                        $prevSubscriptionsInvoice = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}/transactions?start_time=${last_sixmonth_date}T00:00:00.940Z&end_time=${end_date}T00:00:00.940Z"))->json();

                        // account balance
                        $accountBalance = '';

                        $recent_subscriptions = [];
                        $all_subscriptions = SubscriptionPaypal::where('user_id',$shop->id)->where('paypal_id', '!=', $subId)
                                ->orderBy('id', 'desc')->select('id', 'paypal_id', 'paypal_status', 'created_at')
                                ->take(3)->get()->toArray();

                        if(count($all_subscriptions)) {
                            foreach ($all_subscriptions as $key => $subscription) {
                                $subs_transactions = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subscription['paypal_id']}/transactions?start_time=${last_sixmonth_date}T00:00:00.940Z&end_time=${end_date}T00:00:00.940Z"))->json();
                                $recent_subscriptions[$key]['id'] = $subscription['id'];
                                $recent_subscriptions[$key]['paypal_id'] = $subscription['paypal_id'];
                                $recent_subscriptions[$key]['subscription_status'] = $subscription['paypal_status'];
                                $recent_subscriptions[$key]['subscription_create_time'] = $subscription['created_at'];
                                $recent_subscriptions[$key]['transactions_info'] = $subs_transactions;
                            }

                            $previousPaypalSubscriptions = $recent_subscriptions;
                        }
                    }
                }

                // From ThemeController
                $billingCycle = 'Yearly';

                if ($shop->sub_plan == 'Monthly') {
                    $billingCycle = 'Monthly';
                }

                if ($shop->sub_plan == 'Quarterly') {
                    $billingCycle = 'Quarterly';
                }

                $master_shops = ChildStore::where('store', $shop->name)->first();
                if ($master_shops) {
                    return redirect()->route('plans');
                }

                $pause_plan = unserialize($shop->pause_subscription);
                $pausePlanName = "";
                if (!empty($pause_plan)) {
                    if (isset($pause_plan['plan_name']) && !empty($pause_plan['plan_name'])) {
                        $pausePlanName = $pause_plan['plan_name'];
                    }
                }
            }
            // End From ThemeController

            # ChildStore
            $childStores = $this->childStores($shop);

            $billingCycle = 'Yearly';

            if ($shop->sub_plan == 'Monthly') {
                $billingCycle = 'Monthly';
            }

            if ($shop->sub_plan == 'Quarterly') {
                $billingCycle = 'Quarterly';
            }

            $master_shops = ChildStore::where('store', $shop->name)->first();

            if ($master_shops) {
                return response()->json([
                    'success' => false,
                    'data' => [
                        'redirect' => true,
                        'route' => route('plans')
                    ],
                    'message' => "Need to upgrade"
                ]);
            }

            $pause_plan = unserialize($shop->pause_subscription);

            $pausePlanName = "";

            if (!empty($pause_plan)) {
                if (isset($pause_plan['plan_name']) && !empty($pause_plan['plan_name'])) {
                    $pausePlanName = $pause_plan['plan_name'];
                }
            }

            // if beta user get old plan name
            $oldPlanName = "";
            // if beta user get old plan name
            $user_plan = User::where('id', $shop->id)->select('old_plan_meta')->get();

            if (isset($user_plan->old_plan_meta) && !empty($user_plan->old_plan_meta)) {
                $old_plan = json_decode($user_plan->old_plan_meta);

                if (isset($old_plan->plan_name)) {
                    $oldPlanName = $old_plan->plan_name;
                }
            }

            $isBetaTester = $this->isBetaTester();
            $is_beta_user = false;
            if ($isBetaTester) {
                $is_beta_user = true;
            }

            $addOnsInfo = $this->addOnsInfo();

            $data = [
                'user_since' => $shop->created_at->format('M d, Y'),
                'subscription_plan' => $shop->alladdons_plan,
                'card_expire' => $cardExpire,
                'card_number' => $cardNumber,
                'card_brand' => $cardBrand,
                'card_data' => $cardData,
                'all_invoices' => $prevSubscriptionsInvoice,
                'account_balance' => $accountBalance,
                'upcoming_invoice' => $upcomingInvoice,
                'store_count' => $storeCount,
                'store_limit' => $storeLimit,
                'billing_cycle' => $billingCycle,
                'recent_invoice' => $recentInvoice,
                'pause_plan_name' => $pausePlanName,
                'is_paused' => $shop->is_paused,
                'child_stores' => $childStores,
                'old_plan_name' => $oldPlanName,
                'is_beta_user' => $is_beta_user,
                'addons_info' => $addOnsInfo['data'],
                'addons_info_count' => $addOnsInfo['count'],
                'current_paypal_billing' => $currentPaypalBilling,
                'previous_paypal_subscriptions' => $previousPaypalSubscriptions
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return $e->getMessage() . $e->getTraceAsString();
        }
    }

    // update credit card function
    public function updateCreditCard(Request $request, StripePlan $plan)
    {
        $shop = auth()->user();
        $shopData = $this->getShopData($shop);
        $address = array(
            'line1' => $shopData['address1'],
            'city' => $shopData['city'],
            'country' => $shopData['country_name'],
            'line2' => $shopData['address2'],
            'postal_code' => $shopData['zip'],
            'state' => $shopData['province']
        );
        if(MainSubscription::PAYMENT_PLATFORM_STRIPE)
        {
            try {
                \Stripe\Stripe::setApiKey($this->stripe_key);
                if (empty($shop->stripe_id)) {
                    logger("create new customer on stripe, email={$request->get('email')}");
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
                } else {
                    $customer = \Stripe\Customer::update(
                        $shop->stripe_id,
                        ["source" => $request->stripeToken]
                    );
                }
                return response()->json([
                    'success' => true,
                    'message' => __('messages.payment_method_update_success_resonse'),
                    'data' => $customer
                ]);
            } catch (\Stripe\Exception\CardException $e) {
                logger("Since it's a decline, \Stripe\Exception\CardException will be caught");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\RateLimitException $e) {
                logger("Too many requests made to the API too quickly");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                logger("Invalid parameters were supplied to Stripe's API");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\AuthenticationException $e) {
                logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                logger("Network communication with Stripe failed");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json(['message' =>  $err['message']]);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                logger("Display a very generic error to the user, and maybe send yourself an email");
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json(['message' =>  $err['message']]);
            } catch (\Exception $e) {
                logger("Something else happened, completely unrelated to Stripe");
                return response()->json(['message' =>  $e->getMessage()]);
            }
        }

    }

    // add linked store function
    public function addChildStore(Request $request)
    {
        $shop = auth()->user();
        logger('Add master shop=' . $shop->name);

        try {
            \DB::beginTransaction();

            if (!preg_match("/^(?!:\/\/)([^.\s]+\.)?myshopify.com$/i", $request->get('childstore')))
            {
                return response()->json([
                    'success' => false,
                    'message' => "The shop domain is invalid.",
                ]);
            }

            if ($shop->name == $request->get('childstore'))
            {
                return response()->json([
                    'success' => false,
                    'message' => $request->get('childstore') . ' is a master account',
                ]);
            }

            $shops = User::where('name', $request->get('childstore'))->first();

            if ($shops)
            {
                if ($shops->alladdons_plan != 'Freemium' && $shops->alladdons_plan != null)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'This store already has an active subscription.',
                    ]);
                }
                elseif ($shops->is_paused)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'This store already has a paused subscription.',
                    ]);
                }
                elseif ($shops->shopify_raw &&
                       (json_decode($shops->shopify_raw)->plan_name === $shops::PLAN_CANCELLED ||
                        json_decode($shops->shopify_raw)->plan_name === $shops::PLAN_FROZEN))
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'This store is already closed.',
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => "Install Debutify Theme Manager before sharing your license.",
                ]);
            }

            $storecount = ChildStore::where('store', $request->get('childstore'))->count();

            if ($storecount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'This store is already linked.',
                ]);
            }

            $shop->master_account = 1;
            $shop->save();

            $storeCount = $shop->childstores()->count();

            if ($storeCount >= 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Already shared max licences.',
                ]);
            }

            $stores = new ChildStore;
            $stores->store = $request->get('childstore');
            $stores->user_id = $shop->id;

            if ($stores->save()) {
                addScriptTagCurl($shops, true);
            }

            $storeCount = $shop->childstores()->count();


            $data = [
                'child_stores' => $this->childStores($shop),
                'store_count' => $storeCount,
            ];

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Store licence shared successfully.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            \DB::rollback();

            return $e->getMessage();
        }
    }

    // remove linked store function
    public function removeChildStore(Request $request)
    {
        $response = [];
        $shop = auth()->user();
        $storeId = $request->get('store_id');

        try {
            $stores = ChildStore::where('id',$storeId)->where('user_id',$shop->id)->first();

            if (!$stores) {
                return response()->json([
                    'success' => false,
                    'message' => 'Store not found!'
                ]);
            }

            try{

                $this->removeChildStoreAddOns($request, false);
            }
            catch(\Exception $e){
                Log::error('removeChildStore Error =>'. $e->getMessage(). ' File =>'. $e->getFile().' LIne =>'. $e->getLine());
                Log::error($e->getTraceAsString());
            }

            \DB::beginTransaction();

            $stores->delete();

            $storeCount = $shop->childstores()->count();


            $data = [
                'child_stores' => $this->childStores($shop),
                'store_count' => $storeCount,
            ];

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Store licence removed successfully.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json([
                'success' => false,
                'message' => __('messages.error_response'),
                'data' => $e->getMessage()
            ]);
        }
    }


    public function removeChildStoreAddOns(Request $request, $fromApi = true)
    {
        $shops = User::where('name', $request->get('child_store'))->first();

        if ($shops) {
            $this->deleteAllAddOns($shops, 'child');
        }

        if ($fromApi) {
            return response()->json([
                'success' => true,
                'message' => 'Store Add-Ons removed successfully.',
                'data' => [],
            ]);
        }

        return $shops;
    }

    public function stripeCardData()
    {
        $shop = auth()->user();

        if (!isset($shop->stripe_id) || empty($shop->stripe_id)) return false;

        \Stripe\Stripe::setApiKey($this->stripe_key);

        $stripeCustomer = \Stripe\Customer::retrieve($shop->stripe_id);

        if (empty($stripeCustomer) || !count($stripeCustomer->sources->data)) return false;

        return $stripeCustomer->sources->data[0]->card ?? $stripeCustomer->sources->data[0];
    }

    public function activeSubscription()
    {
        $shop = auth()->user();
        if ($shop->all_addons != 1) {
            return false;
        }

        $percentOff = '';
        $couponDuration = '';
        $couponDurationMonths = '';
        $previousPlan = '';
        $discount = '';
        $nextInvoiceTotal = 0.00;
        $currentPlan = '';
        $currentCost = '';
        $couponName = '';
        $stripeSubs = '';
        $nextPaymentAttempt = '';
        $subscriptions = [];

        # Subscription
        $mainSubscription = $shop->mainSubscription;

        if ($shop->all_addons == 1 && isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;

            if (
                $paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE &&
                $mainSubscription->stripe_customer_id != null
            ) {
                $subscriptions = $shop->stripeSubscription()->active()->first();

                if ($subscriptions) {
                    try {
                        $stripeSubs = \Stripe\Subscription::retrieve($subscriptions->stripe_id);

                        if (!$stripeSubs->cancel_at_period_end) {
                            $stripeUpcomingInvoice = \Stripe\Invoice::upcoming(["subscription" => $stripeSubs]);
                            $currentPlan = $stripeSubs->plan;
                            $discount = $stripeSubs->discount;
                            $nextInvoiceTotal = number_format($stripeUpcomingInvoice->amount_due / 100, 2);

                            $nextPaymentAttempt = Carbon::createFromTimestamp(
                                $stripeUpcomingInvoice->next_payment_attempt
                            )->format("F d, Y");

                            // get subscription discount
                            if ($discount) {
                                $couponName = $discount->coupon->name;
                                $couponDuration = $discount->coupon->duration;
                                $couponDurationMonths = $discount->coupon->duration_in_months;

                                if ($discount->coupon->percent_off) {
                                    $percentOff = $discount->coupon->percent_off . '% off';
                                } else {
                                    $percentOff = number_format(($discount->coupon->amount_off / 100), 2);
                                    $percentOff = 'US$' . $percentOff . ' off';
                                }
                            }

                            // get old pricing for current users
                            if ($currentPlan) {
                                $currentCost = $currentPlan->amount / 100;
                                $costs = [10, 84, 27, 197, 15, 90];

                                if (in_array($currentCost, $costs)) {
                                    $previousPlan = $currentCost;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        $e->getMessage();
                    }
                }
            }

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {

                $plan = $shop->paypalSubscription()->activeOrSuspended()->first();

                if ($plan)
                {
                    $annualMonthPlans = [];
                    $plan->name = chop($plan->name,'21Jun2021');

                    if(strpos($plan->name, 'master') !== false)
                    {
                        $plan->name = str_replace('master', 'guru', $plan->name);
                    }

                    if (strpos($plan->name, "Annually"))
                    {
                        $annualMonthPlans['annually'] = $plan->paypal_plan ?? '';
                        $mPlanExploded = explode("Annually", $plan->name)[0];
                        $mPlan = $mPlanExploded . "Monthly";
                        $qPlan = $mPlanExploded . "Quarterly";
                        $current_plan = StripePlan::where('name', $mPlan)->first('paypal_plan');
                        $annualMonthPlans['monthly'] = $current_plan->paypal_plan ?? '';
                        $annualMonthPlans['quarterly'] = StripePlan::where('name', $qPlan)->first('paypal_plan')->paypal_plan ?? '';
                    }
                    else if(strpos($plan->name,"Quarterly"))
                    {
                        $annualMonthPlans['quarterly'] = $plan->paypal_plan ?? '';
                        $mPlanExploded = explode("Quarterly", $plan->name)[0];
                        $mPlan = $mPlanExploded . "Monthly";
                        $qPlan = $mPlanExploded . "Quarterly";
                        $current_plan = StripePlan::where('name', $mPlan)->first('paypal_plan');
                        $annualMonthPlans['monthly'] = $current_plan->paypal_plan ?? '';
                        $annualMonthPlans['quarterly'] = StripePlan::where('name', $qPlan)->first('paypal_plan')->paypal_plan ?? '';
                    }
                    else if(strpos($plan->name,"Monthly"))
                    {
                        $annualMonthPlans['monthly'] = $plan->paypal_plan ?? '';
                        $mPlanExploded = explode("Monthly", $plan->name)[0];
                        $mPlan = $mPlanExploded . "Annually";
                        $qPlan = $mPlanExploded . "Quarterly";
                        $current_plan = StripePlan::where('name', $mPlan)->first('paypal_plan');
                        $annualMonthPlans['annually'] = $current_plan->paypal_plan ?? '';
                        $annualMonthPlans['quarterly'] = StripePlan::where('name', $qPlan)->first('paypal_plan')->paypal_plan ?? '';
                    }

                    $currentPlan = json_encode($annualMonthPlans);
                    $subscriptions = $shop->paypalSubscription()->activeOrSuspended()->first();

                    if ($subscriptions)
                    {
                        try
                        {
                            $subId = $subscriptions->paypal_id;
                            $paypal_subs = fetchPaypalSubscriptionStatus($subId);
                            if (@$paypal_subs['statusCode'] == 200)
                            {
                                $next_invoice_total_1 = $paypal_subs['response']['billing_info']['last_payment']['amount']['value'];
                                $nextInvoiceTotal = number_format($next_invoice_total_1, 2);
                                $currentPaymentDate = Carbon::parse($paypal_subs['response']['billing_info']['last_payment']['time']);
                                $paypalPlan = explode('Price', $subscriptions->name);

                                if (strpos(strtolower($paypalPlan[1]), 'monthly') !== false)
                                {
                                    $nextPaymentAttempt = $currentPaymentDate->copy()->addMonth();
                                }
                                if (strpos(strtolower($paypalPlan[1]), 'quarterly') !== false)
                                {
                                    $nextPaymentAttempt = $currentPaymentDate->copy()->addMonths(3);
                                }
                                if (strpos(strtolower($paypalPlan[1]), 'annually') !== false)
                                {
                                    $nextPaymentAttempt = $currentPaymentDate->copy()->addYear();
                                }
                                $nextPaymentAttempt = optional($nextPaymentAttempt)->format("F d, Y");
                            }
                            //Currently coupons are not supported by Paypal in current flow.
                        }
                        catch (Exception $e)
                        {
                            Log::error($e->getMessage());
                        }
                    }
                }
            }
        }

        return [
            'percent_off' => $percentOff,
            'coupon_duration' => $couponDuration,
            'coupon_duration_months' => $couponDurationMonths,
            'previous_plan' => $previousPlan,
            'discount' => $discount,
            'next_invoice_total' => $nextInvoiceTotal,
            'next_payment_attempt' => $nextPaymentAttempt,
            'current_plan' => $currentPlan,
            'current_cost' => $currentCost,
            'coupon_name' => $couponName,
            'subscription' => $subscriptions,
            'stripe_subs' => $stripeSubs,
            'mainSubscription' => $mainSubscription
        ];
    }

    public function plans(StripePlan $plan, Request $request)
    {
        $shop = auth()->user();

        \Stripe\Stripe::setApiKey($this->stripe_key);

        $isBetaTester = $this->isBetaTester();

        # Not applicable on the current setup
        // $latestTheme = Themes::orderBy('id', 'desc')->first();
        // $storeThemes = $shop->storethemes()->orderbyrole()->get();

        // if ( $isBetaTester )
        // {
        //     $latestTheme = Themes::isBetaTheme(1)->orderBy('id', 'desc')->first();
        //     $storeThemes = $shop->storethemes()->orderByRole()->get();
        // }

        # Was not used on the blade file
        // $free_addons = FreeAddon::where('shopify_domain', $shop->name)->where('status',1)->first();

        # StoreThemes
        $exit_code = '50OFF3MONTHS';
        $new_code = 'DEBUTIFY20';
        $previousPlan = '';
        $discount = '';
        $currentPlan = '';
        $currentCost = '';

        // subcription active
        if ($shop->all_addons == 1) {
            # Subscription whereNull endAt
            $subscription = $shop->stripeSubscription()->active()->first();

            if ($subscription) {
                $stripeSubs =  \Stripe\Subscription::retrieve($subscription->stripe_id);

                $currentPlan = $stripeSubs->plan;
                $discount = $stripeSubs->discount;

                // get subscription discount
                if ($discount) {
                    if ($discount->coupon->percent_off) {
                        // $percentOff = $discount->coupon->percent_off.'% off';
                    } else {
                        $percentOff_1 = $discount->coupon->amount_off / 100;
                        $percentOff_2 = number_format($percentOff_1, 2);
                    }
                }

                // get old pricing for current users
                if ($currentPlan) {
                    $currentCost = $currentPlan->amount / 100;

                    $costs = [10, 84, 27, 197, 15, 90];

                    if (in_array($currentCost, $costs)) {
                        $previousPlan = $currentCost;
                    }
                }
            }
        }

        # Not applicable on the react js integration
        // if ( $themeCount > 0 ) {
        //     $theme_current_version = Themes::find($shop->theme_id);

        //     if ( $shop->theme_id != null && $shop->shopify_theme_id != null ) {
        //         if ( $latest_theme->id > $shop->theme_id ) {
        //             $theme_url = $latest_theme->url;
        //             $request->session()->flash('new_version', $theme_url);
        //         }
        //     }
        // }

        # ChildStore
        $storeCount = $shop->childstores()->count();
        $storeLimit = 2;

        // taxes
        $shopData = $this->getShopData($shop);

        $applyTaxes = $shopData && $shopData['country_name'] == 'Canada' ? true : false;

        $billingCycle = 'Yearly';

        if ($shop->sub_plan == 'Monthly') {
            $billingCycle = 'Monthly';
        }

        if (strtolower($shop->sub_plan) == 'quarterly') {
            $billingCycle = 'Quarterly';
        }

        $globalAddons = GlobalAddons::orderBy('title', 'desc')->get();

        $faqs = FrequentlyAskedQuestion::all();

        $shopSubscription = $this->shopSubscription() ?? [];
        $cardData = $this->stripeCardData();
        $addOnsInfo = $this->addOnsInfo();

        $data = [
            'plans' => $this->stripePlans(),
            'store_count' => $storeCount,
            'store_limit' => $storeLimit,
            'discount' => $discount,
            'previous_plan' => $previousPlan,
            'current_plan' => $currentPlan,
            'current_cost' => $currentCost,
            'apply_taxes' => $applyTaxes,
            'billing_cycle' => $billingCycle,
            'global_add_ons' => $globalAddons,
            'card_data' => $cardData,
            'view_plans' => true,
            'faqs' => $faqs,
            'addons_info' => $addOnsInfo['data'],
            'addons_info_count' => $addOnsInfo['count'],
        ];

        $data = array_merge($data, $shopSubscription);

        return response()->json([
            'success' => true,
            'data' =>  $data
        ]);
    }

    public function stripePlans()
    {
        # StripePlan
        $shop = auth()->user();
        $stripePlans = StripePlan::all();

        // Default value
        $data = ['stripe_plans' => $stripePlans];

        // get active plan price and ID
        foreach ($stripePlans as $plan) {
            # Standard format of name by the time use is "starterPriceMonthly && starterPriceAnnually'

            // Except these plans
            $isEnterprise = Str::contains($plan->name, 'enterprisePrice');
            $isPro = Str::contains($plan->name, 'proPrice');

            if (!$isPro && !$isEnterprise) {
                $isMonthly = Str::contains($plan->name, 'Monthly');

                $data[$plan->name] = $plan->cost;

                # I.e From starterPriceMonthly to starterIdMonthly
                $planId = Str::replaceFirst('Price', 'Id', $plan->name);
                $data[$planId] = $plan->stripe_plan;

                # I.e From starterPriceMonthly to starterCodeMonthly
                $planCode = Str::replaceFirst('Price', 'Code', $plan->name);
                $data[$planCode] = $plan->paypal_plan;
            }
        }

        return $data;
    }

    // pause subscription
    public function pauseSubscription(Request $request)
    {
        $shop = auth()->user();

        if ($shop->is_paused) {
            return response()->json([
                'success' => false,
                'data' => [
                    'route' => route('home')
                ]
            ]);
        }

        try {
            \Stripe\Stripe::setApiKey($this->stripe_key);

            $planName = $shop->alladdons_plan;
            $subPlan = $shop->sub_plan;
            $next_month_date = strtotime("next Month");

            # Subscription
            $mainSubscription = $shop->mainSubscription;

            if (isset($mainSubscription)) {
                $paymentPlatform = $mainSubscription->payment_platform;

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                    $subscription = $shop->stripeSubscription()->active()->orderBy('id','desc')->first();
                    // $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
                    $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

                    if (isset($subscription->stripe_id) && !empty($subscription->stripe_id)) {
                        $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                            'pause_collection' => [
                                'behavior' => 'mark_uncollectible',
                            ],
                        ]);

                        if (isset($sub->id) && !empty($sub->id) && isset($sub->billing_cycle_anchor)) {
                            $shop->is_paused = 1;
                            $data_pause = ['plan_name' => $planName, 'sub_plan' => $subPlan];
                            $shop->pause_subscription =  serialize($data_pause);
                            $shop->alladdons_plan = "Freemium";
                            $shop->save();

                            if ($shop->script_tags) {
                                deleteScriptTagCurl($shop);
                            }

                            $this->pauseAllAddOns($shop, 'master');
                            $contact = $this->activeCampaign->sync([
                                'email' => $shop->email,
                                'fieldValues' => [
                                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $planName]
                                ]
                            ]);
                            $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);
                        }
                    }
                }

                if ($mainSubscription->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                    // $subscription = SubscriptionPaypal::where('user_id', $shop->id)->status('ACTIVE')->orderBy('id', 'desc')->first();
                    $subscription = $shop->paypalSubscription()->active()->first();
                    $subsriptionPaypalId = $subscription->paypal_id;
                    $subsriptionPaypal = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subsriptionPaypalId}"))->json();

                    if ($subsriptionPaypal['status'] == 'ACTIVE') {
                        $pauseSubscriptionResponse = getPaypalHttpClient()
                            ->withBody('{"reason":"Customer Requested Pausing Current Subscription"}', 'application/json')
                            ->post(getPaypalUrl("v1/billing/subscriptions/${subsriptionPaypalId}/suspend"))->status();
                        if ($pauseSubscriptionResponse == 204) {
                            $getPaypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subsriptionPaypalId}"))->json();
                            SubscriptionPaypal::where('paypal_id', $subsriptionPaypalId)->update(['paypal_status' => $getPaypalSubscription['status']]);

                            $shop->is_paused = 1;
                            $data_pause = ['plan_name' => $planName, 'sub_plan' => $subPlan];
                            $shop->pause_subscription =  serialize($data_pause);
                            $shop->alladdons_plan = "Freemium";
                            $shop->save();

                            if ($shop->script_tags) {
                                deleteScriptTagCurl($shop);
                            }

                            $this->pauseAllAddOns($shop, 'master');

                            $contact = $this->activeCampaign->sync([
                                'email' => $shop->email,
                                'fieldValues' => [
                                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $planName]
                                ]
                            ]);
                            $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_PAUSED);
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'subscription' => 'paused',
                    'alladdons_plan' => $planName
                ]
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function unpauseSubscription()
    {
        $shop = Auth::user();

        try {
            \Stripe\Stripe::setApiKey($this->stripe_key);

            $plan = unserialize($shop->pause_subscription);
            $mainSubscription = $shop->mainSubscription;
            $unpausedStatus = false;

            if (isset($mainSubscription)) {
                $paymentPlatform = $mainSubscription->payment_platform;

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                    $subscription = $shop->stripeSubscription()->orderBy('id','desc')->first();

                    //  $subscription = SubscriptionStripe::where('user_id', $shop->id)->orderBy('id', 'desc')->first();
                    if (isset($subscription->stripe_id) && !empty($subscription->stripe_id)) {
                        $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                            'pause_collection' => '',
                        ]);

                        if (isset($sub->id) && !empty($sub->id)) {
                            $this->unpauseAllAddOn($shop, 'master');
                            $license_key = Hash::make(Str::random(12));
                            $shop->all_addons = 1;
                            $shop->alladdons_plan = $plan['plan_name'];
                            $shop->license_key = $license_key;
                            $shop->is_paused = 0;
                            $shop->pause_subscription = null;
                            $shop->save();

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

                            $unpausedStatus = true;
                        }
                    }
                }

                if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                    logger('paypal subscription resume started');
                    //$subscription = SubscriptionPaypal::where('user_id',$shop->id)->status('SUSPENDED')->orderBy('id', 'desc')->first();
                    $subscription = $shop->paypalSubscription()->status('SUSPENDED')->orderBy('id','desc')->first();
                    $subscriptionPaypalId = $subscription->paypal_id;
                    logger('subscription_paypal_id is ' . $subscriptionPaypalId);
                    $subscriptionPaypal = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/{$subscriptionPaypalId}"))->json();
                    logger('subscription_paypal is ' . json_encode($subscriptionPaypal));

                    $unpausedMessage = "";
                    $billing_info = $subscriptionPaypal['billing_info'];
                    if($billing_info['failed_payments_count'] > 0 && $billing_info['outstanding_balance']['value'] > 0) {
                        $paypalOSResponse = paypal_capture_outstanding_balance($subscriptionPaypalId, $billing_info['outstanding_balance']);
                        if($paypalOSResponse['status'] == 202) {
                            $unpausedMessage  = "Capture on outstanding balance is in progress. Please try again in few minutes.";
                        } else {
                            return response()->json([
                                'success' => false,
                                'messages' => $paypalOSResponse['message']
                            ]);
                        }
                    }

                    if ($subscriptionPaypal['status'] == 'SUSPENDED') {
                        $pauseSubscriptionResponse = getPaypalHttpClient()
                            ->withBody('{"reason":"Customer Requested Reactivating Subscription"}', 'application/json')
                            ->post(getPaypalUrl("v1/billing/subscriptions/${subscriptionPaypalId}/activate"))->status();
                        logger('pauseSubscriptionResponse is ' . json_encode($pauseSubscriptionResponse));

                        if ($pauseSubscriptionResponse == 204) {
                            $getPaypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subscriptionPaypalId}"))->json();
                            SubscriptionPaypal::where('paypal_id', $subscriptionPaypalId)->update([
                                'paypal_status' => $getPaypalSubscription['status']
                            ]);
                            $license_key = Hash::make(Str::random(12));

                            $this->unpauseAllAddOn($shop, 'master');
                            $shop->all_addons = 1;
                            $shop->alladdons_plan = $plan['plan_name'];
                            $shop->license_key = $license_key;
                            $shop->is_paused = 0;
                            $shop->pause_subscription = null;
                            $shop->save();
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
                            $unpausedStatus = true;
                        } else {
                            return response()->json([
                                'success' => false,
                                'messages' => $unpausedMessage ?? "Your plan can not be unpaused. please contact Debutify Support to unpause the plan. "
                            ]);
                        }
                    }
                }

                if ($unpausedStatus) {
                    return response()->json([
                        'success' => true,
                        'messages' => [
                            'banner' => __('messages.plan_unpaused_banner_success_response', [
                                'plan' => $plan['plan_name']
                            ]),
                            'toast' => __('messages.plan_unpaused_success_response')
                        ],
                        'data' => [
                            'route' => route('plans')
                        ]
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'messages' => __('messages.no_subscription_response')
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'messages' => __('messages.no_subscription_response')
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'messages' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function pay_outstanding_balance()
    {
        $shop = Auth::user();
        $subscription = $shop->paypalSubscription()->active()->first();
        if($subscription) {
            $subsId = $subscription->paypal_id;
            $activePaypalBilling = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subsId}"))->json();

            $billing_info = isset($activePaypalBilling['billing_info']) ? $activePaypalBilling['billing_info'] : null;
            if($billing_info) {
                if($billing_info['failed_payments_count'] > 0 && $billing_info['outstanding_balance']['value'] > 0) {
                    $paypalOSResponse = paypal_capture_outstanding_balance($subsId, $billing_info['outstanding_balance']);

                    if($paypalOSResponse['status'] == 202) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Your request for capture on outstanding balance is in progress.'
                        ]);
                    }
                    return response()->json([
                        'success' => false,
                        'message' => $paypalOSResponse['message']
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'No outstanding balance found for this subscription!'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'An error occurred with PayPal, please try again in a few minutes!'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid subscription or subscription not found!'
        ]);
    }

    public function pauseAllAddOns($shop, $action)
    {
        $isBetaTester = $this->isBetaTester();
        $storeThemes = $shop->storeThemes()
            ->active()
            ->isBetaTheme($isBetaTester)
            ->get();

        if (!count($storeThemes)) {
            $storeThemes = $shop->storeThemes()->active()->get();
        }

        // $StoreTheme = StoreThemes::where('user_id', $shops->id)->where('status', 1)->get();
        $shop->license_key = null;
        $shop->save();
        $addOns = $shop->addons()->active()->get();
        $checkAddOn = 1;
        $updateAddOn = 0;

        foreach ($addOns as $addOn) {
            sleep(1);
            $this->deactivateAddOns($shop, $storeThemes, $addOn->global_id, $checkAddOn, $updateAddOn);
            sleep(1);
            no_addon_activate_curl($storeThemes, $shop);
        }

        $childStores = $shop->childStores()->get();
        foreach ($childStores as $key => $childStore) {
            $shops = User::where('name', $childStore->store)->first();
            if ($shops) {
                deleteScriptTagCurl($shops);
            }
        }
    }

    public function unpauseAllAddOn($shop, $action)
    {
        if ($shop->script_tags) {
            addScriptTag($shop);
        }

        $childStores = $shop->childstores()->get();

        if (count($childStores) > 0) {
            foreach ($childStores as $key => $childStore) {
                $shops = User::where('name', $childStore->store)->first();
                if ($shops) {
                    addScriptTagCurl($shops); // adding of script tag
                }
            }
        }
    }

    // subscription coupon function
    public function applycoupon(Request $request)
    {
        try {
            $shop = auth()->user();
            $this->fetchInitialData();
            $shopData = $shop->shop_api;
            $taxRates = array();

            if (!empty($shopData) && $shopData['country_name'] == 'Canada') {
                logger('domain=' . $shop->name . ', province=' . $shopData['province']);

                $tax = Taxes::where('region', $shopData['province'])->first();
                if ($tax) {
                    $taxId = $tax->stripe_taxid;
                } else {
                    $tax = Taxes::where('region', 'New-Brunswick')->first();
                    $taxId = $tax->stripe_taxid;
                }
                logger('returning tax=' . $taxId);
                $taxRates[] = $taxId;
            }
            \Stripe\Stripe::setApiKey($this->stripe_key);
            $getStripeSubscription = $this->getStripeSubscription();
            $subscription = $getStripeSubscription['subscription'];

            $done = \Stripe\Subscription::update($subscription->stripe_id, [
                'coupon' => $request->get('subscription_coupon'),
                'default_tax_rates' => $taxRates,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Coupon code applied."
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        } catch (Exception $e) {
            logger("Something else happened, completely unrelated to Stripe");
            return response()->json([
                'success' => false,
                'message' => "Invalid coupon code."
            ]);
        }
    }

    // new coupon functionn
    public function getCoupon(Request $request)
    {
        try {
            $coupon = $request->get('new_coupon');

            \Stripe\Stripe::setApiKey($this->stripe_key);
            $coupon = \Stripe\Coupon::retrieve($request->get('new_coupon'), []);

            if ($coupon->valid) {
                $couponName = $coupon->id;
                $couponDuration = $coupon->duration;
                $couponDurationMonths = $coupon->duration_in_months;

                Cookie::queue('coupon', $coupon, 10000);

                $data = [
                    'success' => true,
                    'message' => 'Coupon code applied',
                    'data' => [
                        'percent_off' => $coupon->percent_off ?? false,
                        'amount_off' => $coupon->amount_off,
                        'coupon_name' => $couponName,
                        'coupon_duration' => $couponDuration,
                        'coupon_duration_months' => $couponDurationMonths
                    ]
                ];
                return response()->json($data);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'invalid coupon code'
                ]);
            }
        } catch (\Stripe\Exception\CardException $e) {
            logger("Since it's a decline, \Stripe\Exception\CardException will be caught");
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            logger("Too many requests made to the API too quickly");
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            logger("Invalid parameters were supplied to Stripe's API");
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
            return response()->json([
                'success' => false,
                'message' => 'invalid coupon code'
            ]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            logger("Network communication with Stripe failed");
            return response()->json([
                'success' => false,
                'message' => 'invalid coupon code'
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            logger("Display a very generic error to the user, and maybe send yourself an email");
            return response()->json([
                'success' => false,
                'message' => 'invalid coupon code'
            ]);
        } catch (Exception $e) {
            logger("Something else happened, completely unrelated to Stripe");
            return response()->json([
                'success' => false,
                'message' => 'invalid coupon code'
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $shop = auth()->user();
        // The redirect old param to new billing param is set
        // on the ThemeControllerV2
        # We don't need to add the latest theme code here
        $request->get('plan_name');
        $plan = StripePlan::plan('starter')->get();

        // if(isset($shop->is_beta_tester) && $shop->is_beta_tester == 1 ){
        //     $latest_theme = Themes::where('is_beta_theme', 1)->orderBy('id', 'desc')->first();
        //     $theme_count = StoreThemes::where('user_id', $shop->id)->count();

        //     }else{
        //         $latest_theme = Themes::where('is_beta_theme', '!=', 1)->orWhere('is_beta_theme', NULL)->orderBy('id', 'desc')->first();
        //         $theme_count = StoreThemes::where('user_id', $shop->id)->where('is_beta_theme','!=',1)->orWhere('is_beta_theme', NULL)->count();
        //     }
        $freeAddons = FreeAddon::where('shopify_domain', $shop->name)->where('status', 1)->first();
        // # StoreThemes
        $themeCount = $shop->storethemes()->count();
        $exit_code = '50OFF3MONTHS';
        $new_code = 'PLAN10';
        $theme_url = '';
        $paypalPlan = [];

        $mainSubscription = $shop->mainSubscription;
        $getStripeSubscription = $this->getStripeSubscription();
        $getPaypalSubscription = $this->getPaypalSubscription();

        # Stripe sources data
        $cardData = $this->stripeCardData();

        # Subcription active
        $activeSubscription = $this->activeSubscription();

        # Stripe Plans
        $stripePlans = $this->stripePlans();

        if ($freeAddons) {
            $freeAddons = $freeAddons->status;
        }

        if ($themeCount > 0) {
            # Themes
            $latest_theme = Themes::orderBy('id', 'desc')->first();
            $theme_current_version = Themes::where('id', $shop->theme_id)->get();

            if ($shop->theme_id != null && $shop->shopify_theme_id != null) {
                if ($latest_theme->id > $shop->theme_id) {
                    $theme_url = $latest_theme->url;
                }
            }
        }

        // child store count
        $storeCount = $shop->childstores()->count();
        $storeLimit = 2;

        // taxes
        $shopData = $this->getShopData($shop);
        $applyTaxes = $shopData && $shopData['country_name'] == 'Canada';
        $taxCharges = Taxes::where('region_code', $shopData['province_code'])->select('percent')->first();
        $taxPercentage = $taxCharges ? floatval($taxCharges->percent) : 0;
        $pausedPlanData = "";
        if (isset($shop->pause_subscription)) {
            $pausedPlanData = unserialize($shop->pause_subscription);
        }

        $mainPlan = strtolower($request->get('plan_name'));
        $checkoutPlan = StripePlan::where('plan_name', Str::ucfirst($mainPlan))
            ->pluck('paypal_plan');

        if (count($checkoutPlan) > 0) {
            $paypalPlan = [
                'Monthly' => $checkoutPlan[0],
                'Annually' => $checkoutPlan[1],
                'Quarterly' => $checkoutPlan[2]
            ];
        }

        $addOns = $this->getShopAddOns();
        $paymentPlatform = getPaymentPlatform();
        $isSubscriptionEndingSoon = isSubscriptionEndingSoon(3);


        $contactTag = AC::TAG_EVENT_INITIATE_CHECKOUT;
        $contact = $this->activeCampaign->sync([
            'email' => $shop->email
        ]);
        $tag = $this->activeCampaign->tag($contact['id'], $contactTag);

        $data = [
            'new_theme_url' => $theme_url,
            'active_subscription' => $activeSubscription,
            'stripe_plans' => $stripePlans,
            'plan' => $plan,
            'free_addons' => $freeAddons,
            'store_count' => $storeCount,
            'store_limit' => $storeLimit,
            'exit_code' => $exit_code,
            'new_code' => $new_code,
            'card_data' => $cardData,
            'apply_taxes' => $applyTaxes,
            'tax_charges' => $taxPercentage,
            'customer_email_sha1' => sha1($shop->email),
            'customer_id' => $shop->id,
            'paused_plan_data' => $pausedPlanData,
            'theme_count' => $themeCount,
            'paypal_plan' => $paypalPlan,
            'add_ons' => $addOns,
            'payment_platform' => $paymentPlatform,
            'is_subscription_ending_soon' => $isSubscriptionEndingSoon
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ])->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    // subscription function
    public function allSubscription(Request $request, StripePlan $plan)
    {
        $shop = auth()->user();
        $totalActiveAddons = $shop->addons()->active()->count();
        $activeChildStores = $shop->childstores()->count();
        $selectedPlan = Str::ucfirst($request->get('payment_cycle'));
        $shopData = $this->shopPlansData($shop);
        $masterShopName = $this->checkMasterStore($shop);

        //add session for previous plan on thank you page
        session(['prevPlan' => $shop['alladdons_plan']]);

        // Backend validations
        if ($selectedPlan != 'Master') {
            $selectedPlanLimit = $shopData[Str::lower($selectedPlan) . '_limit'];

            if ($activeChildStores > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Remove linked stores to downgrade plan",
                    'data' => []
                ]);
            }

            if ($totalActiveAddons > $selectedPlanLimit) {
                return response()->json([
                    'success' => false,
                    'message' => "Too many Add-Ons activated to downgrade plan.",
                    'data' => [
                        'active' => $totalActiveAddons,
                        'limit' => $selectedPlanLimit
                    ]
                ]);
            };
        }


        // Backend validations
        if (!empty($masterShopName)) {
            return response()->json([
                'success' => false,
                'message' => "This store's subscription is managed by {$masterShopName}",
                'data' => []
            ]);
        }

        logger('all subscription shop=' . $shop->name);

        Session::put('tax_user_id', $shop->id);

        $shopData = $shop->shop_api;

        if (empty($shopData)) {
            return response()->json([
                'success' => false,
                'message' => "Failed to retrieve shop data. Please try again."
            ]);
        }

        $taxRates = array();

        if ($shopData['country_name'] == 'Canada') {
            logger('domain=' . $shop->name . ', province=' . $shopData['province']);

            // $taxId = getTaxId($shopData->province);
            $tax = Taxes::where('region', $shopData['province'])->first();

            if ($tax) {
                $taxId = $tax->stripe_taxid;
            } else {
                $tax = Taxes::where('region', 'New-Brunswick')->first();
                $taxId = $tax->stripe_taxid;
            }

            logger('returning tax=' . $taxId);
            $taxRates[] = $taxId;
        }

        // address for stripe
        $address = array(
            'line1'            => $shopData['address1'],
            'city'            => $shopData['city'],
            'country'        => $shopData['country_name'],
            'line2'            => $shopData['address2'],
            'postal_code'    => $shopData['zip'],
            'state'            => $shopData['province']
        );

        $themeCount = $shop->storethemes()->active()->count();

        $isBrandNewSubscription = false;

        try {
            \Stripe\Stripe::setApiKey($this->stripe_key);
            // cancel a subscription if already Created
            $check_active_subs = $shop->stripeSubscription()->where('stripe_status', 'active')->orderBy('id', 'desc')->first();
            if ($shop->all_addons == 1 && $check_active_subs) {
                // Remove Child Store onchange master store plans
                if ($shop->alladdons_plan == 'Master' && $selectedPlan != 'Master') {
                    $shop->master_account = null;
                    $childStores = $shop->childstores()->get();

                    if (isset($childStores) && count($childStores) > 0) {
                        foreach ($childStores as $key => $child_store) {
                            $shops = User::where('name', $child_store->store)->first();
                            if ($shops) {
                                $this->deleteAllAddOns($shops, 'child');
                            }
                        }
                        $deletedChildStore = $shop->childstores()->delete();
                    }
                }
                // subscription update
                $subscription = $shop->stripeSubscription()->orderBy('id', 'desc')->first();

                $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                    'trial_end' => 'now',
                ]);
                // Delete Discount code on upgrade/downgrade
                $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);
                if ($sub->discount) {
                    $deleteDiscount = $sub->deleteDiscount();
                }
                $stripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_id);
                // See what the next invoice would look like with a plan switch
                // upgrade/downgrade subscription
                $subscriptionData = [
                    'cancel_at_period_end' => false,
                    'proration_behavior' => "always_invoice",
                    'items' => [
                        [
                            'id' => $stripeSubscription->items->data[0]->id,
                            'plan' => $request->get('plan_id'),
                        ],
                    ],
                    'default_tax_rates' => $taxRates,
                    'payment_behavior' => 'allow_incomplete',
                ];
                if ($coupon = $request->get('new_coupon')) {
                    $subscriptionData['cancel_at_period_end'] = null;
                    $subscriptionData['coupon'] = $request->get('new_coupon');
                }
                $updateSubscription = \Stripe\Subscription::update($subscription->stripe_id, $subscriptionData);
                $sub = \Stripe\Invoice::retrieve($updateSubscription->latest_invoice);

                if ($sub->payment_intent) {
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($sub->payment_intent);

                    // If 3ds is required
                    if (($updateSubscription->status === 'incomplete' || $updateSubscription->status === 'past_due') && $paymentIntent->status === 'requires_source_action') {
                        $paymentMethods = \Stripe\PaymentMethod::all([
                            'customer' => $shop->stripe_id,
                            'type' => 'card',
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Requires action',
                            'data' => [
                                'subscription' => $updateSubscription,
                                'payment_intent' => $paymentIntent,
                                'payment_methods' => $paymentMethods,
                            ]
                        ]);
                    }
                }

                $totalBill = $sub->total;
                $totalTax = (empty($sub->tax) || $sub->tax < 0) ? 0 : $sub->tax;
                $totalAmount = (($totalBill - $totalTax) / 100) < 0 ? 0 : ($totalBill - $totalTax) / 100;
                $revenue = (($totalBill + $totalTax) / 100) < 0 ? 0 : ($totalBill + $totalTax) / 100;
                $taxFinal = $totalTax / 100;

                $thank_you_data = array(
                    'tracking' => $updateSubscription->latest_invoice,
                    'amount' => $totalAmount,
                    'subscription_id' => $subscription->stripe_id,
                    'plan_id' => $request->get('plan_id'),
                    'revenue' => $revenue,
                    'tax' => $taxFinal,
                    'alladdons_plan' => $selectedPlan,
                    'sub_plan' => $request->sub_plan,
                    'coupon' => $request->get('new_coupon'),
                );
                $shop->mainSubscription()->update([
                    'payment_platform' => 'stripe',
                    'stripe_customer_id' => $updateSubscription->customer
                ]);
                //update stripe plan
                $shop->stripeSubscription()->where('stripe_status', 'active')->update([
                    'stripe_plan' => $request->get('plan_id')
                ]);
                logger('subscription updated=' . json_encode($updateSubscription));
            } else {
                $isBrandNewSubscription = true;

                $stripeData = [
                    'email' => $request->get('email'),
                    'description' => $shop->name,
                    'name' => $shopData['shop_owner'],
                    'address' => $address,
                    'phone' => $shopData['phone']
                ];

                if ($request->has('pending_customer_id')) {
                    $customer = \Stripe\Customer::retrieve($request->input('pending_customer_id'));
                } else if (empty($shop->stripe_id)) {
                    logger('create new customer on stripe, email=' . $request->get('email'));

                    $stripeData['source'] = $request->stripeToken;
                    $customer = \Stripe\Customer::create($stripeData);
                } else {
                    logger('update existing customer on stripe');
                    $customer = \Stripe\Customer::update($shop->stripe_id, $stripeData);
                }

                $shop->stripe_id = $customer->id;

                $stripeSubscriptionData = [
                    'customer' => $shop->stripe_id,
                    'items' => [['plan' => $request->get('plan_id')]],
                    'metadata' => ['lm_data' => $request->linkminkRef],
                    'default_tax_rates' => $taxRates,
                    'payment_behavior' => 'allow_incomplete',
                ];

                if ($request->has('pending_subscription_id')) {
                    $subscriptionCreated = \Stripe\Subscription::retrieve($request->input('pending_subscription_id'));
                } else if ($coupon = $request->get('new_coupon')) {
                    $stripeSubscriptionData['coupon'] = $coupon;
                    $subscriptionCreated = \Stripe\Subscription::create($stripeSubscriptionData);
                } else {
                    $subscriptionCreated = \Stripe\Subscription::create($stripeSubscriptionData);
                }

                $sub = \Stripe\Invoice::retrieve($subscriptionCreated->latest_invoice);
                if($sub->payment_intent){
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($sub->payment_intent);

                    // If 3ds is required
                    if ($subscriptionCreated->status === 'incomplete' && ($paymentIntent->status === 'requires_source_action' || $paymentIntent->status === 'requires_source')) {
                        $paymentMethods = \Stripe\PaymentMethod::all([
                            'customer' => $customer->id,
                            'type' => 'card',
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Requires action',
                            'data' => [
                                'subscription' => $subscriptionCreated,
                                'payment_intent' => $paymentIntent,
                                'payment_methods' => $paymentMethods,
                            ]
                        ]);
                    }
                }

                $totalBill = $sub->total;
                $totalTax = (empty($sub->tax) || $sub->tax < 0) ? 0 : $sub->tax;
                $totalAmount = (($totalBill - $totalTax) / 100) < 0 ? 0 : ($totalBill - $totalTax) / 100;
                $revenue = (($totalBill + $totalTax) / 100) < 0 ? 0 : ($totalBill + $totalTax) / 100;
                $taxFinal = $totalTax / 100;

                $thank_you_data = [
                    'tracking' => $subscriptionCreated->latest_invoice,
                    'amount' => $totalAmount,
                    'subscription_id' => $subscriptionCreated->id,
                    'plan_id' => $request->get('plan_id'),
                    'revenue' => $revenue,
                    'tax' => $taxFinal,
                    'alladdons_plan' => $selectedPlan,
                    'sub_plan' => $request->sub_plan,
                    'coupon' => $request->get('new_coupon'),
                ];

                logger('subscription created=' . json_encode($subscriptionCreated));

                $subscription = new SubscriptionStripe;
                $subscription->user_id = $shop->id;
                $subscription->name = 'main';
                $subscription->stripe_id = $subscriptionCreated->id;
                $subscription->stripe_plan = $request->get('plan_id');
                $subscription->stripe_status = $subscriptionCreated->status;
                $subscription->quantity = 1;
                $subscription->save();


                MainSubscription::updateOrCreate(
                    ['user_id' => $shop->id],
                    [
                        'payment_platform' => 'stripe',
                        'stripe_customer_id' => $subscriptionCreated->customer
                    ]
                );
                logger('subscription saved');
            }


            $paypal_sub = SubscriptionPaypal::where('user_id',$shop->id)
                ->whereIn('paypal_status', ['ACTIVE', 'SUSPENDED'])
                ->orderBy('id', 'desc')->first();
            if($paypal_sub)
            {
                logger("Paypal Active subscription found cancelling this before activating new one ");
                app('App\Http\Controllers\PaypalController')->cancelSubscription(null,$paypal_sub,$paypal_sub->paypal_id);
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
            } catch (\Exception $e) {
                $e->getMessage();
            }

            setPlanActionTag($shop, $request->get('payment_cycle'));
        } catch (\Stripe\Exception\CardException $e) {
            logger("Since it's a decline, \Stripe\Exception\CardException will be caught");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'redirect' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            logger("Too many requests made to the API too quickly");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'redirect' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            logger("Invalid parameters were supplied to Stripe's API, error=" . $err['message']);

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'redirect' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'redirect' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            logger("Network communication with Stripe failed");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'redirect' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            logger("Display a very generic error to the user, and maybe send yourself an email");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'redirect' => route('theme_addons')
                ]
            ]);
        } catch (\Exception $e) {
            $body = $e->getMessage();
            logger("Something else happened, completely unrelated to Stripe: " . $body);

            return response()->json([
                'success' => false,
                'message' => $body,
                'data' => [
                    'redirect' => route('plans')
                ]
            ]);
        }

        // echo "sub_plan=".$request->get('sub_plan');
        $shop->all_addons = 1;
        $shop->alladdons_plan = $selectedPlan;
        $shop->sub_plan = $request->get('sub_plan');

        // license key created
        $license_key = Hash::make(Str::random(12));
        $shop->license_key = $license_key;
        $shop->custom_domain = $shopData['domain'];
        $shop->is_paused = null;
        $shop->pause_subscription = null;

        if ($shop->script_tags) {
            addScriptTag($shop);
        }

        $shop->save();

        $contact = $this->activeCampaign->sync([
            'email' => $shop->email,
            'fieldValues' => [
                ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $shop->alladdons_plan],
            ]
        ]);
        $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_MONTH_FREE);

        if ($contactTag) {
            $untag = $this->activeCampaign->untag($contactTag['id']);
        }

        $request->session()->put('thank_you', true);
        session(['thank_you_data' => $thank_you_data]);
        \Cookie::forget('discount-code');

        return response()->json([
            'success' => true,
            'message' => __('messages.plan_activated_response'),
            'data' => [
                'data' => $thank_you_data,
                'is_new_subscription' => $isBrandNewSubscription,
                'route' => route('thankyou')
            ]
        ]);
    }

    // cancel subscription function
    public function cancelAllSubscription(Request $request, StripePlan $plan = null, $paypalWebhookId = null)
    {
        \Stripe\Stripe::setApiKey($this->stripe_key);
        $shop = Auth::user();

        $plan = $shop->alladdons_plan;
        session(['previousPlanBeforeCancel' => $plan]);

        if ($shop->is_paused) {
            $paused_plan_data = unserialize($shop->pause_subscription);
            if (isset($paused_plan_data['plan_name']) && !empty($paused_plan_data['plan_name'])) {
                $plan = $paused_plan_data['plan_name'];
            } else {
                $plan = $shop->alladdons_plan;
            }
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
        } catch (\Exception $e) {
            $e->getMessage();
        }

        // Remove All addons from Child Store
        if ($plan == 'Master') {
            $shop->master_account = null;

            // Get all current shop child stores
            $childStores = $shop->childstores()->get();

            // Check if current shop has child stores
            if (count($childStores) > 0) {

                // Run through each child store and delete all addons
                foreach ($childStores as $key => $child_store) {
                    $childStoreShop = User::where('name', $child_store->store)->first();
                    if ($childStoreShop) {
                        $this->deleteAllAddOns($childStoreShop, 'child');
                        if ($childStoreShop->script_tags) {
                            deleteScriptTagCurl($childStoreShop);
                        }
                    }
                }

                $deletedChildStore = $shop->childstores()->delete();
            }
        }

        //delete shop addons from themes
        $this->deleteAllAddOns($shop, 'master');
        $mainSubscription = $shop->mainSubscription()->first();
        if (isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                try {
                    if ($shop->script_tags) {
                        deleteScriptTagCurl($shop);
                    }

                    logger("cancel all stripe subscription");
                    // $stripeSubscriptions =  SubscriptionStripe::where('user_id', $shop->id)->status('active')->get();
                    $stripeSubscriptions = $shop->stripeSubscription()->status('active')->get();


                    if (isset($stripeSubscriptions)) {
                        foreach ($stripeSubscriptions as $stripeSubscription) {
                            cancelStripeSubscription($stripeSubscription);
                        }
                    }
                    logger("cancel all stripe subscription completed");


                } catch (\Exception $e) {
                    logger('error ' . $e->getMessage());

                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
            }

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                
                try {
                    logger('=== Api/ThemeController/cancelAllSubscription Paypal sub cancellation started===');
                    if ($shop->script_tags) {
                        deleteScriptTagCurl($shop);
                    }
                    
                    $paypalSubscriptions = $shop->allPaypalSubscriptions()->activeOrSuspended()->get();
                    
                    logger('$paypalSubcriptions ' . json_encode($paypalSubscriptions));

                    if($paypalSubscriptions->isNotEmpty()) {
                         //making sure there are no active subscription left for user

                        foreach($paypalSubscriptions as $key=>  $paypalSubscription) {


                            $sub_id = $paypalSubscription->paypal_id;

                            if (@$paypalSubscription->paypal_status != 'CANCELLED') {

                                $paypalResponse = cancelPaypalSubscription($sub_id);

                                if (@$paypalResponse['statusCode'] == 204)
                                {
                                    $paypalSubscription->paypal_status = 'CANCELLED';
                                    $paypalSubscription->ends_at = null;
                                    $paypalSubscription->save();
                                    logger('paypalSubscription ' . json_encode($paypalSubscription));
                                }
                            }
                        }
                    }

                } catch (\Exception $e) {
                    logger('error ' . $e->getMessage().' '. $e->getTraceAsString());
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
                logger('===Api/ThemeController/cancelAllSubscription Paypal subscription cancellation ended===');
            }
        }

        \Cookie::queue(\Cookie::forget('discount-code'));
        $subscription = 'cancellation';

        return response()->json([
            'success' => true,
            'data' => [
                'subscription' => $subscription,
                'previous_plan' => $plan
            ]
        ]);
    }

    // prorated stripe plan upgrade function
    public function proratedAmount(Request $request)
    {
        $shop = auth()->user();
        $mainSubscription = $shop->mainSubscription;
        $proratedAmount = 0;

        if (isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                // $subscription = SubscriptionStripe::where('user_id', $shop->id)->orderBy('id', 'desc')->first();
                $subscription = $shop->stripeSubscription()->orderBy('id', 'desc')->first();
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                $subscriptionStripe =  \Stripe\Subscription::retrieve($subscription->stripe_id);
                $proratedAmount = $this->getProratedAmount($request->get('plan_id'), $subscriptionStripe, $subscription);
                logger('prorated amount=' . json_encode($proratedAmount * 100));
            }

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                $proratedAmount = 0;
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'prorated_amount' => $proratedAmount,
            ]
        ]);
    }

    //copy of other function ProratedAmount /used for subscription upsell
    public function getProratedAmount($planId, $subscriptionStripe, $subscription)
    {
        $items = [
            [
                'id' => $subscriptionStripe->items->data[0]->id,
                'price' => $planId, # Switch to new plan
            ],
        ];

        $invoice = \Stripe\Invoice::upcoming([
            'customer' => $subscriptionStripe->customer,
            'subscription' => $subscription->stripe_id,
            'subscription_items' => $items,
            'subscription_proration_date' => time(),
        ]);

        $cost = 0;

        $cost = $invoice->lines->data[0]->amount;

        return $cost / 100;
    }

    public function goodBye()
    {
        $shop = auth()->user();
        $storeCount = $shop->childstores()->count();
        $discountPrice = "";
        $previousPlan = "";
        $mainSubscription = $shop->mainSubscription;

        if (isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;
            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                $stripeSubscription = $shop->stripeSubscription()->orderBy('id', 'desc')->first();
                if (isset($stripeSubscription)) {
                    $previousPlan = StripePlan::where('stripe_plan', $stripeSubscription->stripe_plan)
                        ->orderBy('id', 'desc')
                        ->first();
                }
            }

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                // $paypalSubscription = $shop->paypalSubscription()->orderBy('id', 'desc')->first();
                $paypalSubscription = $shop->paypalSubscription()->orderBy('id', 'desc')->first();

                if (isset($paypalSubscription)) {
                    $previousPlan = StripePlan::where('stripe_plan', $paypalSubscription->paypal_plan)
                        ->orderBy('id', 'desc')
                        ->first();
                }
            }
        }

        $stripePlans = $this->stripePlans();

        $subPlan = Str::lower($shop->sub_plan);
        $addonsPlan = $shop->alladdons_plan;
        $addonsPlan = Str::lower($addonsPlan == 'Master' ? 'Guru' : $addonsPlan);

        if ($addonsPlan != 'guru' && $addonsPlan != 'freemium') {
            // hustlerPriceAnnually, starterPriceAnnually
            $discountPrice = ($subPlan == 'Yearly' ?
                number_format($stripePlans["{$addonsPlan}PriceAnnually"] * 20 / 100, 2)
                : (Str::lower($subPlan) == 'quarterly' ?
                    number_format($stripePlans["{$addonsPlan}PriceQuarterly"] * 20 / 100, 2)
                    : ''));
        }

        $plan_price = $subPlan == 'Monthly' ? ($stripePlans["{$addonsPlan}PriceMonthly"]) : '';

        $shopData = $shop->shop_api;
        $addOnsInfo = $this->addOnsInfo();

        $data = array_merge([
            'store_count' => $storeCount,
            'yearly_discount_price' => $discountPrice,
            'shop' => $shop,
            'shop_data' => $shopData,
            'plan_price' => $plan_price,
            'previous_plan' => $previousPlan,
            'addons_info_count' => $addOnsInfo['count']
        ], $stripePlans);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // free subscription
    public function freeSubscription(Request $request)
    {
        try {
            $shop = auth()->user();

            if ($shop->has_taken_free_subscription == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already used your free subscription',
                    'data' => []
                ]);
            }

            $data = [];
            $newDateAnchor = "";
            $next_month_date = strtotime("next Month");
            $planName = $shop->alladdons_plan;
            $subPlan = $shop->sub_plan;

            \Stripe\Stripe::setApiKey($this->stripe_key);
            $subscription = $shop->stripeSubscription()->orderBy('id', 'desc')->first();
            $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

            if ($subPlan == 'Monthly') {
                $discount = 100;
                $coupon_id = "ONEMONTHFREECANCEl";
            } else if ($subPlan == 'Quarterly') {
                $discount = 20;
                $coupon_id = 'ONEQUARTERFREECANCEL';
            } else {
                // Default yearly
                $discount = 20;
                $coupon_id = "20OFFNEXTYEARCANCEl";
            }

            $coupon = \Stripe\Coupon::create([
                'duration' => 'once',
                'percent_off' => $discount,
                'max_redemptions' => 1,
                'id' => $coupon_id . Str::random(12),
            ]);

            if (isset($coupon->id)) {
                $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                    'coupon' => $coupon->id,
                ]);
            }
            $upcomingInvoice = \Stripe\Invoice::upcoming(["customer" => $shop->stripe_id]);

            if (isset($upcomingInvoice->date) && !empty($upcomingInvoice->date)) {
                $newDateAnchor = strtotime('+30 days', $upcomingInvoice->date);
            }

            if (isset($sub->id) && !empty($sub->id) && isset($sub->billing_cycle_anchor)) {
                $shop->has_taken_free_subscription = 1;
                $shop->save();
                $contact = $this->activeCampaign->sync([
                    'email' => $shop->email,
                    'fieldValues' => [
                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $planName]
                    ]
                ]);
                $tag = $this->activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_MONTH_FREE);
            }

            $data = [
                'billing_cycle' => $newDateAnchor,
                'subscription' => 'free',
                'route' => route('goodbye', [
                    'subscription' => 'free', 'billing_cycle' => $newDateAnchor
                ])
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function contactTagAdd()
    {
        $shop = auth()->user();

        $activeCampaign = new ActiveCampaignJobV3();
        $contact = $activeCampaign->sync(['email' => $shop->email]);
        $activeCampaign->tag($contact['id'], AC::TAG_KAMIL_SATTAR_MENTORING);

        return response()->json([
            'success' => true,
            'data' => [
                'shop' => $shop
            ]
        ]);
    }

    // thank you
    public function thankYou(Request $request)
    {
        $shop = auth()->user();
        $data = session('thank_you_data', false);
        $prevPlan = session('prevPlan');
        // try {
            $shopData = $this->getShopData($shop);
            $shopPlansData = $this->shopPlansData($shop);
            $masterShopName = $this->checkMasterStore($shop);
            $nextPlanDetails = $this->getNextPlanDetails($request,$shop);
            $addOnsInfo = $this->addOnsInfo();
            $taxCharges = Taxes::where('region_code', $shopData['province_code'])->select('percent')->first();
            $taxPercentage = $taxCharges ? floatval($taxCharges->percent) : 0;

            $data = [
                'thank_you_data' => $data,
                'next_plan_details' => $nextPlanDetails,
                'shop' => $shop,
                'shop_data' => $shopData,
                'shop_plans_data' => $shopPlansData,
                'master_shop_name' => $masterShopName,
                'customer_email_sha1' => sha1($shop->email),
                'payment_method' => MainSubscription::PAYMENT_PLATFORM_STRIPE,
                'addons_info' => $addOnsInfo['data'],
                'addons_info_count' => $addOnsInfo['count'],
                'tax_charges' => $taxPercentage,
                'prevPlan' => $prevPlan,
                'paypal_signed_url' => URL::temporarySignedRoute(
                    'paypal-thankyou', now()->addMinutes(5), ['upgrade' => true]
                )
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        // } catch (\Throwable $exception) {
        //     $error_first_string = substr($exception->getTraceAsString(), 0, 150);
        //     return response()->json([
        //         'success' => false,
        //         'message' => $exception->getMessage() . $error_first_string
        //     ]);
        // }
    }

    public function getNextPlanDetails($request,$shop)
    {

        if ($shop->all_addons != 1) return false;
        $subscription = [];
        $stripeSubscription = [];
        $hustlerCount = User::hasPlan('Hustler')->count();
        $masterCount = User::hasPlan('Guru')->orWhere->hasPlan('Master')->count();
        $stripeSubs = '';
        $subPlan = $shop->sub_plan;
        $allAddons = $shop->all_addons;
        $allAddonsPlan =  $shop->alladdons_plan;
        $freemium = 'Freemium';
        $starter = 'Starter';
        $hustler = 'Hustler';
        $guru = 'Master';

        $nextPlan = $shop->alladdons_plan == $starter ? $hustler : $guru;

        // Default values - for Guru as next plan
        $firstCycle = 'year';
        $userCount = $masterCount;
        $nextPlan = $guru;
        $nextPlanId = 'guruId';
        $nextPlanCode = 'guruCode';
        $nextPlanPrice = 'guruPrice';
        $multiplier = 0.8;
        $subPlan = strtolower($subPlan);
        if ($subPlan == 'quarterly') {
            $planCycle = 'Quarterly';
            $firstCycle = 'quarter';
        } else if ($subPlan != 'Yearly') {
            $planCycle = 'Monthly';
            $firstCycle = 'month';
        } else {
            $planCycle = 'Annually';
        }
        if (strtolower($subPlan) == 'yearly') {
            $planCycle = 'Annually';
            $firstCycle = 'year';
        }
        $mainSubscription = $shop->mainSubscription;
        if (isset($mainSubscription)) {
            $paymentPlatform = $mainSubscription->payment_platform;
            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_STRIPE) {
                $paypalSubcriptions = $shop->paypalSubscription()->status('ACTIVE')->get();
                if ($paypalSubcriptions) {
                    foreach ($paypalSubcriptions as $paypalSubscription) {
                        $pc = new PaypalController();
                        $pc->cancelSubscription($request, $paypalSubscription, $paypalSubscription->paypal_id);

                    }
                }
                \Stripe\Stripe::setApiKey($this->stripe_key);

                $subscription = $shop->stripeSubscription()->active()->first();

                if ($subscription) {
                    $stripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_id);
                    $currentPlan = $stripeSubscription->plan;
                    $currentPlanDuration = 'Monthly';

                    if (strpos(strtolower($currentPlan->nickname), "annually") !== false) {
                        $currentPlanDuration = 'Yearly';
                    }
                }
            }

            if ($paymentPlatform == MainSubscription::PAYMENT_PLATFORM_PAYPAL) {
                $subscription = $shop->paypalSubscription()->active()->first();
                // $subscription = SubscriptionPaypal::where('user_id',$shop->id)->status('ACTIVE')->first();
                if ($subscription) {
                    $subId = $subscription->paypal_id;
                    $paypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}"))->json();
                    $paypalPlanResponse = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/plans/${subscription['paypal_plan']}"))->json();

                    $paypalCustomer  = $paypalSubscription['subscriber']['payer_id'];
                    $paypalUpcomingInvoice = $paypalSubscription['billing_info']['next_billing_time'];
                    $currentPlan = $paypalPlanResponse['name'];

                    // $nextInvoiceTotal_1 = $stripeUpcomingInvoice->total/100;
                    $nextInvoiceTotal = $paypalSubscription['billing_info']['last_payment']['amount']['value'];
                    $nextInvoiceTotal = number_format($nextInvoiceTotal, 2);

                    $currentPlanDuration = 'Monthly';
                    if (strpos(strtolower($currentPlan), "annually") !== false)
                    {
                        $currentPlanDuration = 'Yearly';
                    }

                    // get old pricing for current users
                    if ($currentPlan)
                    {
                        $costs = [10, 15, 27, 84, 90, 197];
                        $currentCost = (int)$paypalSubscription['billing_info']['last_payment']['amount']['value'];

                        if (in_array($currentCost, $costs))
                        {
                            $previousPlan = $currentCost;
                        }
                    }
                }
            }
        }

        # Stripe Plans
        $stripePlans = $this->stripePlans();

        // Values for Hustler as next plan
        if ($allAddonsPlan == $starter)
        {
            $userCount = $hustlerCount;
            $nextPlan = $hustler;
            $nextPlanId = 'hustlerId';
            $nextPlanCode = 'hustlerCode';
            $nextPlanPrice = 'hustlerPrice';
        }

        # Stripe Plans, - $stripePlans['guruIdAnnually']
        $nextPlanId = $stripePlans[$nextPlanId . $planCycle];
        $nextPlanCode = $stripePlans[$nextPlanCode . $planCycle];
        $nextPlanPrice = $stripePlans[$nextPlanPrice . $planCycle];

        $proratedAmount = '';
        $difference = '';
        $differenceExtra10 = '';
        $savings = '';
        $savingsExtra10 = '';

        if ($stripeSubscription)
        {
            $proratedAmount = $this->getProratedAmount($nextPlanId, $stripeSubscription, $subscription);
            $difference = number_format((($nextPlanPrice * $multiplier) + $proratedAmount), 2);
            $differenceExtra10 = number_format((($nextPlanPrice * ($multiplier - 0.1)) + $proratedAmount), 2);
            $savings = number_format(($nextPlanPrice - ($nextPlanPrice * $multiplier)), 2);
            $savingsExtra10 = number_format(($nextPlanPrice - ($nextPlanPrice * ($multiplier - 0.1))), 2);
        }

        return [
            'next_plan' => $nextPlan,
            'next_plan_id' => $nextPlanId,
            'next_plan_code' => $nextPlanCode,
            'next_plan_price' => $nextPlanPrice,
            'savings' => $savings,
            'savings_extra10' => $savingsExtra10,
            'difference' => $difference,
            'difference_extra10' => $differenceExtra10,
            'subscription' => $subscription,
            'first_cycle' => $firstCycle,
            'multiplier' => $multiplier,
            'user_count' => $userCount,
            'prorated_amount' => $proratedAmount
        ];
    }

    public function upsellSubscription(Request $request)
    {
        $shop = auth()->user();

        //add session for previous plan on thank you page
        session(['prevPlan' => $shop['alladdons_plan']]);

        logger('upsell subscription shop = ' . $shop->name);
        Session::put('tax_user_id', $shop->id);

        $shopData = $shop->shop_api;

        if ($shop->alladdons_plan == 'Master')
        {
            return response()->json([
                'success' => false,
                'message' => 'You already reached the last Debutify plan',
                'data' => []
            ]);
        }
        else if ($shop->all_addons != 1)
        {
            // I based this condition here based on the current flow on updating the subscription plan
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have an existing subsription.',
                'data' => []
            ]);
        }
        else if (empty($shopData))
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve your shopify shop data.',
                'data' => []
            ]);
        }

        $taxRates = [];

        // api request to retrieve the shop data on shopify

        if ($shopData['country_name'] == 'Canada')
        {
            logger('domain=' . $shop->name . ', province=' . $shopData['province']);

            $tax = Taxes::where('region', $shopData['province'])->first();

            if ($tax)
            {
                $taxId = $tax->stripe_taxid;
            }
            else
            {
                $tax = Taxes::where('region', 'New-Brunswick')->first();
                $taxId = $tax->stripe_taxid;
            }

            logger('returning tax=' . $taxId);

            $taxRates[] = $taxId;
        }

        // address for stripe
        $address = [
            'line1' => $shopData['address1'],
            'city' => $shopData['city'],
            'country' => $shopData['country_name'],
            'line2' => $shopData['address2'],
            'postal_code' => $shopData['zip'],
            'state' => $shopData['province']
        ];

        $nextPlanDetails = $this->getNextPlanDetails($request, $shop);

        try {
            \Stripe\Stripe::setApiKey($this->stripe_key);

            // subscription update
            $subscription = $shop->stripeSubscription()->latest()->first();

            // Delete Discount code on upgrade/downgrade
            $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);

            if ($sub->discount)
            {
                $deleteDiscount = $sub->deleteDiscount();
            }

            $subscriptionStripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

            // See what the next invoice would look like with a plan switch
            // upgrade/downgrade subscription
            $coupon = $request->get('coupon');

            $couponPercentOff = $coupon == '8864215630' ? 20 : ($coupon == '4156088664' ? 30 : 0);

            if ($couponPercentOff)
            {
                $starterCoupons = \Stripe\Coupon::create([
                    'percent_off' => $couponPercentOff,
                    'duration' => 'repeating',
                    'duration_in_months' => 1,
                ]);
                $new_coupon = $starterCoupons->id;
            }

            $updateSubscription = \Stripe\Subscription::update($subscription->stripe_id, [
                'coupon' => $starterCoupons ?? '',
                'cancel_at_period_end' => false,
                'proration_behavior' => "always_invoice",
                'items' => [
                    [
                        'id' => $subscriptionStripe->items->data[0]->id,
                        'plan' => $nextPlanDetails['next_plan_id'],
                    ],
                ],
                'default_tax_rates' => $taxRates,
                'payment_behavior' => 'allow_incomplete',
            ]);

            $shop->stripeSubscription()->where('stripe_status', 'active')->update([
                'stripe_plan' => $nextPlanDetails['next_plan_id']
            ]);
            if (isset($starterCoupons) && !empty($starterCoupons))
            {
                $starterCoupons->delete();
            }

            $sub = \Stripe\Invoice::retrieve($updateSubscription->latest_invoice);

            if ($sub->payment_intent) {
                $paymentIntent = \Stripe\PaymentIntent::retrieve($sub->payment_intent);

                // If 3ds is required
                if (($updateSubscription->status === 'incomplete' || $updateSubscription->status === 'past_due') && $paymentIntent->status === 'requires_source_action') {
                    $paymentMethods = \Stripe\PaymentMethod::all([
                        'customer' => $shop->stripe_id,
                        'type' => 'card',
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Requires action',
                        'data' => [
                            'subscription' => $updateSubscription,
                            'payment_intent' => $paymentIntent,
                            'payment_methods' => $paymentMethods,
                        ]
                    ]);
                }
            }

            $totalBill = $sub->total;
            $totalTax = (empty($sub->tax) || $sub->tax < 0) ? 0 : $sub->tax;
            $totalAmount = (($totalBill - $totalTax) / 100) < 0 ? 0 : ($totalBill - $totalTax) / 100;
            $revenue = (($totalBill + $totalTax) / 100) < 0 ? 0 : ($totalBill + $totalTax) / 100;
            $taxFinal = $totalTax / 100;

            $thank_you_data = [
                'tracking' => $updateSubscription->latest_invoice,
                'amount' => $totalAmount,
                'subscription_id' => $subscription->stripe_id,
                'plan_id' => $nextPlanDetails['next_plan_id'],
                'revenue' => $revenue,
                'tax' => $taxFinal,
                'alladdons_plan' => $nextPlanDetails['next_plan'],
                'sub_plan' => $shop->sub_plan,
                'coupon' => $coupon,
            ];
            logger('subscription updated = ' . json_encode($updateSubscription));
        } catch (\Stripe\Exception\CardException $e) {
            logger("Since it's a decline, \Stripe\Exception\CardException will be caught");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            logger("Too many requests made to the API too quickly");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            logger("Invalid parameters were supplied to Stripe's API, error=" . $err['message']);

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            logger("Network communication with Stripe failed");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            logger("Display a very generic error to the user, and maybe send yourself an email");
            $body = $e->getJsonBody();
            $err  = $body['error'];

            return response()->json([
                'success' => false,
                'message' => $err['message'],
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } catch (\Exception $e) {
            logger("Something else happened, completely unrelated to Stripe");
            $err  = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $err,
                'data' => [
                    'route' => route('theme_addons')
                ]
            ]);
        } finally {
            logger('Updating final');
        }

        setPlanActionTag($shop, $nextPlanDetails['next_plan']);

        $shop->all_addons = 1;
        $shop->alladdons_plan = $nextPlanDetails['next_plan'];
        // license key created
        $license_key = Hash::make(Str::random(12));
        $shop->license_key = $license_key;
        $shop->custom_domain = $shopData['domain'];
        $shop->save();

        try {
            $contact = $this->activeCampaign->sync([
                'email' => $shop->email,
                'fieldValues' => [
                    ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $nextPlanDetails['next_plan']]
                ]
            ]);
            $contactTag = $this->activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_CANCELLED);

            if ($contactTag) {
                $untag = $this->activeCampaign->untag($contactTag['id']);
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }

        $request->session()->put('thank_you', true);
        $request->session()->put('status', 'Subscription plan upgraded');
        session(['thank_you_data' => $thank_you_data]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription plan upgraded',
        ]);
    }

    //expired free trial
    public function freeTrialExpired(Request $request)
    {
        $shop = Auth::user();

        $exit_code = '50OFF3MONTHS';
        $new_code = 'DEBUTIFY20';
        $couponName = '';
        $percentOff = '';
        $couponDuration = '';
        $couponDurationMonths = '';
        $previousPlan = '';
        $discount = '';
        $stripePlans = $this->stripePlans($shop);

        $shopData = $shop->shop_api;

        $applyTaxes = $shopData['country_name'] == 'Canada';

        $billingCycle = 'Yearly';

        if ($shop->sub_plan == 'Monthly') {
            $billingCycle = 'Monthly';
        }

        if ($shop->sub_plan == 'Quarterly') {
            $billingCycle = 'Quarterly';
        }

        $hustlerCount = User::hasPlan('Hustler')->count();
        $masterCount = User::hasPlan('Guru')->orWhere->hasPlan('Master')->count();

        $globalAddOns = GlobalAddons::orderBy('title', 'asc')->get();
        $masterShopName = $this->checkMasterStore($shop);
        $addOnsInfo = $this->addOnsInfo();

        $prevPlan = session('previousPlanBeforeCancel');
        $data = [
            'all_addons' => $shop->all_addons,
            'alladdons_plan' => $shop->alladdons_plan,
            'billingCycle' => $billingCycle,
            'shop' => $shop,
            'shop_plans_data' => $this->shopPlansData($shop),
            'shop_data' => $shopData,
            'global_addons' => $globalAddOns,
            'master_shop_name' => $masterShopName,
            'addons_info' => $addOnsInfo['data'],
            'addons_info_count' => $addOnsInfo['count'],
            'stripe_plans' => $stripePlans,
            'previous_plan' => $prevPlan
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function generateTenPercentCoupon()
    {
        $shop = Auth::user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('Unautenticated')
            ]);
        }

        $trial_coupon = config('env-variables.TRIAL_COUPON') != '' ? config('env-variables.TRIAL_COUPON') : 'DEBUTIFYTRIAL10';

        return response()->json([
            'success' => true,
            'data' => [
                'coupon_code' => $trial_coupon
            ]
        ]);
    }

    public function reviewGiven(Request $request)
    {
        $shop = Auth::user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ]);
        }

        try {
            \DB::beginTransaction();

            $shop->review_given = 1;
            $shop->save();

            \DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'review_given' => $shop->review_given
                ]
            ]);
        } catch (\Throwable $th) {
            \DB::rollback();

            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function changelog()
    {
        try {
            $updates = $this->updates();

            $data = [
                'updates' => $updates
            ];
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function feedback(Request $request)
    {
        $shop = auth()->user();

        $ssoToken = self::createUpvotyToken();

        $response = [
            'success' => true,
            'data' => [
                'sso_token' => $ssoToken,
            ]
        ];

        return response()->json($response);
    }

    public function createUpvotyToken()
    {
        $shop = Auth::user();
        $owner_detail = json_decode($shop->shopify_raw);
        $owner_name = $owner_detail->shop_owner;
        if (!isset($owner_detail->shop_owner) || empty($owner_detail->shop_owner)) {
            $owner_name = $owner_detail->shop_owner;
        }

        $privateKey = \Config::get('upvoty.upvoty_private_key');
        $userData = [
            'id' => $shop->id, // Required
            'name' => $owner_name,  // Required
            'email' => $shop->email,  // Optional but preferred
        ];
        return JWT::encode($userData, $privateKey, 'HS256');
    }

    public function installBetaThemePlan()
    {
        $shop = Auth::user();
        $shopData = $shop->shop_api;

        $licenseKey = Hash::make(Str::random(12));
        $trialDays = 30;

        $current_date = new DateTime();
        $formatted_current_date = $current_date->format('Y-m-d');
        $trialEndsAt = date('Y-m-d', strtotime($formatted_current_date . ' + ' . $trialDays . ' days'));
        $shop->trial_ends_at = $trialEndsAt;
        $shop->license_key = $licenseKey;
        $shop->alladdons_plan = "";

        if ($shop->all_addons == 1) {
            $shop->sub_trial_ends_at = 1;
            $shop->sub_plan = $shop->sub_plan;
        } else {
            $shop->all_addons = 1;
            $shopOwner = $shopData['shop_owner'];
            $shopOwnerName = explode(" ", $shopOwner);
            $shop->sub_trial_ends_at = 1;
            $shop->sub_plan = "Monthly";
            $shop->custom_domain = $shopData['domain'];
        }

        $shop->save();
    }

    // app view show all feature
    public function ExtendedTrial(Request $request)
    {
        $shop = Auth::user();

        if (!$shop) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ]);
        }

        $isFreePlan = ($shop->trial_days > 0 ||
            $shop->alladdons_plan == "Freemium" ||
            $shop->alladdons_plan == "");

        $isBetaTester = $this->isBetaTester();
        $ExtendFeatureRequest = [];

        if ($isFreePlan && !$isBetaTester && !$shop->is_paused) {

            $ExtendFeatures = ExtendTrial::orderby('id', 'desc')->get();

            foreach ($ExtendFeatures as $key => $ExtendFeature) {
                $ExtendTrialStatus = "";
                $RequestFeature = UserExtendTrialRequest::where('extend_trials_id', $ExtendFeature->id)
                    ->where('user_id', $shop->id)
                    ->select('extend_trial_status')
                    ->first();

                if ($RequestFeature) {
                    $ExtendTrialStatus = $RequestFeature->extend_trial_status ?? "";
                }
                $ExtendFeature['extend_trial_status'] = $ExtendTrialStatus;
                $ExtendFeatureRequest[] = $ExtendFeature;
            }
        }
        $ProgressBar = $this->GetExtendTrialProgress($shop);
        $progressNumbers = $extendTrialRequestData = $this->extendTrialRequestData();
        $data = [
            'success' => true,
            'data' => [
                'extendtrial' => $ExtendFeatureRequest,
                'progress_bar' => $ProgressBar,
                'progress_numbers' => $progressNumbers['trial_extend_step_progress'] ?? ""
            ]
        ];

        return response()->json($data);
    }

    public function GetExtendTrialProgress($shop)
    {

        $CompleteStep = 0;
        $ProgressBar = 0;
        $ExtendFeatures = ExtendTrial::orderby('id', 'desc')->get();
        $ExtendFeatureRequest = [];
        foreach ($ExtendFeatures as $key => $ExtendFeature) {
            $ExtendTrialStatus = "";
            $RequestFeature = UserExtendTrialRequest::where('extend_trials_id', $ExtendFeature->id)->where('user_id', $shop->id)->select('extend_trial_status')->first();

            if ($RequestFeature) {
                $ExtendTrialStatus = $RequestFeature->extend_trial_status ?? "";
            }
            $ExtendFeature['extend_trial_status'] = $ExtendTrialStatus;
            $ExtendFeatureRequest[] = $ExtendFeature;
        }

        $CompleteStep = 0;
        $ProgressBar = 0;
        foreach ($ExtendFeatures as $ExtendFeature) {
            if ($ExtendFeature->extend_trial_status == "approved") {
                $CompleteStep++;
            }
        }
        if (count($ExtendFeatures) != 0) {
            $ProgressBar = $CompleteStep * 100 / count($ExtendFeatures);
        }
        return $ProgressBar;
    }

    public function ExtendedTrialRequest(Request $request)
    {
        $shop = Auth::user();
        if (!$shop) {
            return redirect()->route('login');
        }
        if ($request->has('extend_feature_id') && $request->has('feature_proof_image'))
        {
            // $image = str_replace('data:image/png;base64,', '', );
            // print_r($request->feature_proof_image);
            $ExplodeData = explode(',', $request->feature_proof_image);
            $pos  = strpos($ExplodeData[0], ';');
            $type = explode(':', substr($ExplodeData[0], 0, $pos))[1];
            $image = $ExplodeData[1];
            $ImageType = explode('/', $type);
            $image = str_replace(' ', '+', $image);
            $ImageName = 'debutify-' . time() . '.' . $ImageType[1];
            Storage::disk('public')->put('extend_feature_request/' . $ImageName, base64_decode($image));
            $ImageUrl = URL::to('/') . Storage::url('extend_feature_request/' . $ImageName);
            UserExtendTrialRequest::ExtendUserRequest($request, $shop->id, $ImageUrl);

            $request->session()->flash('extend_request', 'ok');
        }

        $data = [
            'success' => true,
            'messages' => [
                'toast' => __('messages.trial_request_send')
                // 'banner' => __('messages.theme_added_success', ['theme' => $themeName])
            ],
            'data' => [
                'route' => route('extended_trial'),
            ]
        ];

        return response()->json($data);
    }

    public function refreshScriptTags(Request $request)
    {
        $shop = Auth::user();
        addScriptTag($shop);
        return redirect()->route('home');
    }
    public function reportBugPopUp()
    {
        $shopSubscription = $this->shopSubscription();
        if ($shopSubscription['subscription_status'] == 'unpaid')
        {
            return response()->json([
                'unpaid' => true,
                'route' => route('plans')
            ]);
        }
        return response()->json([
            'unpaid' => false,
            'route' => route('reportBugPopUp')
        ]);
    }

    public function uploadImage(Request $request)
    {
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

    public function partnerCategories(Request $request)
	{
		$partners = Partner::whereNotNull('categories')->select('categories')->get();

        $updateCategories['0']['label'] = 'Select a Category';
        $updateCategories['0']['value'] = '';

        $partners->each(function($item, $key) use (&$updateCategories) {

            foreach ($item->categories as $category) {

                    $updateCategories[$category]['label']= ucfirst($category);
                    $updateCategories[$category]['value']= $category;
            }
        });

        $transformedCategories = array_values($updateCategories);

        return response()->json(['success' => true, 'data' => $transformedCategories]);
	}
}

