<?php namespace App\Http\Controllers;

use App\User;
use DateTime;
use App\Taxes;
use Exception;
use App\AddOns;
use App\Course;
use App\Themes;
use App\Partner;
use App\Updates;
use App\FreeAddon;
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
use App\Constants\Master;
use App\SubscriptionPaypal;
use App\SubscriptionStripe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\UserExtendTrialRequest;
use App\FrequentlyAskedQuestion;
use App\Jobs\ActiveCampaignJobV3;
use App\Jobs\ShareasaleCommission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Constants\ActiveCampaignConstants as AC;
use Mediatoolkit\ActiveCampaign\Client as ACClient;

class ThemeControllerV2 extends Controller {
    public $subscription_status;
    public $secong_addon_name;
    public $third_theme_name;
    public $activeCampaign;

    /**
     * Show the application landing page.
     */
    public function __construct()
    {
        $shop = Auth::user();
        if($shop) {
            $this->activeCampaign = new ActiveCampaignJobV3();
            $isPayPalSubscriptionApprovalPending = isPayPalSubscriptionApprovalPending();

            if ($isPayPalSubscriptionApprovalPending) {
                $this->redirectToRoute($isPayPalSubscriptionApprovalPending['route']);
            }
        }
    }

    function redirectToRoute($route) {
        return redirect($route);
    }

    public function index()
    {
        $shop = Auth::user();
        $trial_days = $shop->trial_days;
        return view('app-dashboard', ['trial_days' => $trial_days]);
    }

    public function affiliate()
    {
        return view('app-affiliate');
    }

    public function addons()
    {
        $shop = auth()->user();

        $latestUploadedTheme = $shop->storeThemes()
            ->active()
            ->last();

        if ( $this->subscriptionStatus() == 'unpaid')
        {
            return redirect()->route('billing');
        }

        if (!($shop->storeThemes()->active()->where('version','2.0.2')->exists()))
        {
            return redirect()->route('theme_view');
        }

        return view('app-addons');
    }

    public function billing()
    {
        return view('app-billing');
    }

    public function changelog(StripePlan $plan, Request $request)
    {
        return view('app-changelog');
    }

    public function support()
    {
        return view('app-support');
    }

    public function testing()
    {
        return view('app-testing');
    }

    public function courses()
    {
        if ( $this->subscriptionStatus() == 'unpaid')
        {
            return redirect()->route('billing');
        }

        return view('app-courses');
    }

    public function singleCourse(StripePlan $plan, Request $request,$id)
    {
        if ( $this->subscriptionStatus() == 'unpaid')
        {
            return redirect()->route('billing');
        }
        $course = Course::where('courses.id',$id)
                    ->with(['modules.steps' => function ($query) {
                        $query->orderBy('position', 'asc');
                    }])->first();

        if ($course) {
            $course->sub_plans = explode(",", $course->plans);
            $course = json_decode($course);

            return view('app-single-course', ['course' => $course]);
        }
    }

    public function integrations()
    {
        if ($this->subscriptionStatus() == 'unpaid')
        {
            return redirect()->route('billing');
        }
        return view('app-integrations');
    }

    public function mentoring()
    {
        if ( $this->subscriptionStatus() == 'unpaid') {
            return redirect()->route('billing');
        }
        return view('app-mentoring');
    }

    public function technicalSupport()
    {
        return view('app-technical-support');
    }

    public function themeLibrary() {
        if ( $this->subscriptionStatus() == 'unpaid') {
            return redirect()->route('billing');
        }
        return view('app-theme-library');
    }

    public function winningProducts()
    {
        if ( $this->subscriptionStatus() == 'unpaid') {
            return redirect()->route('billing');
        }

        return view('app-winning-products');
    }

    public function partners()
    {
        return view('app-partners');
    }

    public function plans()
    {
        return view('app-plans');
    }

    public function checkout(StripePlan $plan, Request $request)
    {
        // Redirect old param to new billing param
        if (
            $request->has('Monthly') && $request->input('Monthly') == null ||
            $request->has('Quarterly') && $request->input('Quarterly') == null ||
            $request->has('Yearly') && $request->input('Yearly') == null
        ) {
          return redirect()->route('checkout', array_merge(
            [
              'plan' => lcfirst($plan->plan_name),
              'billing' => array_keys($request->only(['Monthly', 'Quarterly', 'Yearly']))[0]
            ],
            $request->except(['Monthly', 'Quarterly', 'Yearly'])
          ));
        }

        return view('app-checkout');
    }

    public function goodBye()
    {
        $shop = auth()->user();

        if ( $shop->alladdons_plan == 'Freemium' ) {
            return redirect()->route('plans');
        }

        return view('app-goodbye');
    }

    public function thankYou(Request $request)
    {
        $newCheckout  = $request->session()->pull('thank_you');

        $thank_you_data = session('thank_you_data');
        if (isset($thank_you_data['subscription_id']) && Cookie::get('sas_m_awin'))
        {
            $subscription = SubscriptionStripe::whereStripeId($thank_you_data['subscription_id'])->first();
            if ($subscription && optional($subscription->user)->commission_count < 12)
            {
                $cookie = json_decode(Cookie::get('sas_m_awin'), 1);
                if (isset($cookie['clickId']))
                {
                    dispatch(new ShareasaleCommission($subscription->user, [
                        'action' => "new", 'sscid' => $cookie['clickId'],
                        'tracking' => $thank_you_data['subscription_id'],
                        'amount' => $thank_you_data['amount'], 'sscidmode' => 6,
                    ]));
                }
            }
        }

        if ( empty($newCheckout) || ! $newCheckout ) {
            return redirect()->route('home');
        }

        return view('app-thank-you');
    }

    public function freeTrialExpired(Request $request)
    {
        $shop = auth()->user();

        if (empty($shop))
        {
              return redirect()->route('login');
        }

        if (
            $shop->trial_days != 0 &&
            $shop->alladdons_plan != "" &&
            $shop->alladdons_plan != "Freemium"
        )
        {

              return redirect()->route('home');
        }

        return view('app-free-trial-expired');
    }

    public function feedback()
    {
        return view('app-feedback');
    }

    public function extendedTrial()
    {
        return view('app-extended-trial');
    }
    public function paypalThankYou(Request $request){
        if ($request->has('upgrade') && ! $request->hasValidSignature()) {
            return redirect()->route('home');
        }

        $thank_you_data = session('thank_you_data');
        if (isset($thank_you_data['subscription_id']) && Cookie::get('sas_m_awin'))
        {
            $subscription = SubscriptionPaypal::wherePaypalId($thank_you_data['subscription_id'])->first();
            if ($subscription && optional($subscription->user)->commission_count < 12)
            {
                $cookie = json_decode(Cookie::get('sas_m_awin'), 1);
                if (isset($cookie['clickId']))
                {
                    dispatch(new ShareasaleCommission($subscription->user, [
                        'action' => "new", 'sscid' => $cookie['clickId'],
                        'tracking' => $thank_you_data['subscription_id'],
                        'amount' => $thank_you_data['amount'], 'sscidmode' => 6,
                    ]));
                }
            }
        }

        $upgrade = $request->has('upgrade') ? $request->boolean('upgrade') : false;
        if(!$upgrade) {
            $newCheckout = $request->session()->pull('thank_you');

            if ( empty($newCheckout) || ! $newCheckout ) {
                return redirect()->route('home');
            }
        }

        return view('app-paypal-thank-you');
    }
}
