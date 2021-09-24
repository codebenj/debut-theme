<?php

namespace App\Http\Controllers;

use View;
use Redirect;
use Storage;
use App\User;
use App\Themes;
use App\Contact;
use App\StripePlan;
use App\GlobalAddons;
use App\Partner;
use Illuminate\Http\Request;
use App\Constants\SubscriptionPlans;

class BlackFridayController extends Controller{
    /**
     * Show the application landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct(){
      $nbShops = ((int) User::where('password', '!=', '')->count()) + 43847;
      $nbAddons = GlobalAddons::count();
      $global_add_ons = GlobalAddons::orderBy('title')->get();
      $StripePlan = StripePlan:: all();

      $starterPriceAnnually = $starterPriceMonthly = $hustlerPriceAnnually = 0;
      $hustlerPriceMonthly = $guruPriceAnnually = $guruPriceMonthly = 0;

      foreach ($StripePlan as $plan) {
          if($plan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY){
               $starterPriceAnnually = $plan->cost;
               $starteridAnnually = $plan->stripe_plan;
          }
          if($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY){
              $starterPriceMonthly = $plan->cost;
              $starteridMonthly = $plan->stripe_plan;
          }
          if($plan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY){
              $hustlerPriceAnnually = $plan->cost;
              $hustleridAnnually = $plan->stripe_plan;
          }
          if($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY){
              $hustlerPriceMonthly = $plan->cost;
              $hustleridMonthly = $plan->stripe_plan;
          }
          if($plan->name == SubscriptionPlans::MASTER_PRICE_ANNUALLY){
              $guruPriceAnnually = $plan->cost;
              $guruidAnnually = $plan->stripe_plan;
          }
          if($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY){
              $guruPriceMonthly = $plan->cost;
              $guruidMonthly = $plan->stripe_plan;
          }
        }

        $starter = 'Starter';
        $hustler = 'Hustler';
        $guru = 'Master';
        $starterLimit = '3';
        $hustlerLimit = $nbAddons;
        $guruLimit = $nbAddons;

        //$screenshots = File::allFiles('/images/testimonials/');
        $screenshots = Storage::allFiles('/images/testimonials/');

        $testimonials = [
          "10" => "7abhQECTmWQ",
          "9" => "GDj9vQ05Q0U",
          "8" => "nk6yMbcK2G0",
          "7" => "ozJIYWIlCxA",
          "6" => "DUaPaf1-ylY",
          "5" => "38wCMRKWcYA",
          "4" => "yFD6Mx32PUA",
          "3" => "9NTcHMWhSsI",
          "2" => "1xRSQid9sHI",
          "1" => "MWfxWA0KdNw"
        ];

        $youtubers = [
          "12" => "ATwNAUd9L20",
          "11" => "XCgV9Vg9wD0",
          "10" => "KhZFUa7dmHQ",
          "9" => "wro6hcas3KQ",
          "8" => "_ktBYMWbHcQ",
          "7" => "GbWKoWto1qg",
          "6" => "8EjWCReZBB0",
          "5" => "O_8z7qflxDU",
          "4" => "Q9DGlJ1IcL8",
          "3" => "Li5Ogqr8Wzc",
          "2" => "VcZNtIqh3tU",
          "1" => "bD9dHm0fp0M"
        ];

        View::share([
          'nbShops' => $nbShops,
          'starter' => $starter,
          'hustler' => $hustler,
          'guru' => $guru,
          'starterPriceAnnually' => $starterPriceAnnually,
          'starterPriceMonthly' => $starterPriceMonthly,
          'hustlerPriceAnnually' => $hustlerPriceAnnually,
          'hustlerPriceMonthly' => $hustlerPriceMonthly,
          'guruPriceAnnually' => $guruPriceAnnually,
          'guruPriceMonthly' => $guruPriceMonthly,
          'starteridAnnually' => $starteridAnnually ?? '',
          'starteridMonthly' => $starteridMonthly ?? '',
          'hustleridAnnually' => $hustleridAnnually ?? '',
          'hustleridMonthly' => $hustleridMonthly ?? '',
          'guruidAnnually' => $guruidAnnually ?? '',
          'guruidMonthly' => $guruidMonthly ?? '',
          'testimonials' => $testimonials,
          'screenshots' => $screenshots,
          'youtubers' => $youtubers,
          'nbAddons' => $nbAddons,
          'starterLimit' => $starterLimit,
          'hustlerLimit' => $hustlerLimit,
          'guruLimit' => $guruLimit,
          'global_add_ons' => $global_add_ons
        ]);
    }

    // home view
    public function landing(){
      return redirect()->route('landing');
    }
    // blackfriday-lp2 view
    public function blackfridayLp2(){
      return redirect()->route('landing');
    }
}
