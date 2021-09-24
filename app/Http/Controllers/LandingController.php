<?php

namespace App\Http\Controllers;

use View;
use App\Cms;
use Storage;
use App\Team;
use App\User;
use Redirect;
use App\Themes;
use App\Contact;
use App\Partner;
use App\Webinar;
use App\AddOnInfo;
use App\AdminUser;
use App\StripePlan;
use App\TeamMember;
use App\YoutubeVideos;
use App\Course;
use Illuminate\Http\Request;
use App\FrequentlyAskedQuestion;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\SubscriptionPlans;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Constants\ActiveCampaignConstants as AC;
use Carbon\Carbon;
use App\Rules\RecaptchaValidator;
use App\Podcasts;


class LandingController extends Controller {
    /**
     * Show the application landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct(){
      $route =   \Request::route() ? \Request::route()->getName() : "";
      if(is_null(Cache::get('data_cached')) ){
            $nbShops = number_format(((int) User::where('password', '!=', '')->count()) + 43847);
            $global_add_ons = AddOnInfo::orderBy('name')->get();
            $nbAddons = AddOnInfo::count();
            $faqs = FrequentlyAskedQuestion::all();
            $teamMembers = TeamMember::orderBy('hierarchy', 'asc')->get();
            $allTeams = collect([[
              'id' => 0,
              'name' => 'All Members',
              'icon_path' => 'images/landing/icon-affiliate.svg'
            ]]);
            $nbShops_range = [
              'day'   => $this->getUsersCount(1),
              'week'  => $this->getUsersCount(7),
              'month' => $this->getUsersCount(1,'month'),
              'year'  => $this->getUsersCount(12,'month'),
            ];
            $teams = $allTeams->concat(Team::orderBy('name', 'asc')->get());
            $data_cached = [
              'nbShops'=>$nbShops,
              'global_add_ons'=>$global_add_ons,
              'nbAddons' => $nbAddons,
              'faqs' => $faqs,
              'team_members' => $teamMembers,
              'teams' => $teams,
              'nbShops_range' => $nbShops_range
            ];
            Cache::put('data_cached', $data_cached, 60); //  60 Minutes
      }else {
            $data_cached = Cache::get('data_cached');
            $nbShops =  $data_cached['nbShops'];
            $nbShops_range =  $data_cached['nbShops_range'];
            $global_add_ons = $data_cached['global_add_ons'];
            $nbAddons =  $data_cached['nbAddons'];
            $faqs = $data_cached['faqs'];
            $teamMembers = $data_cached['team_members'];
            $teams = $data_cached['teams'];
      }

      if($route != 'landing'){
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
          'nbShops_range' => $nbShops_range,
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
          'global_add_ons' => $global_add_ons,
          'faqs' => $faqs,
          'team_members' => $teamMembers,
          'teams' => $teams,
        ]);

      }else{
        View::share([
          'nbShops' => $nbShops,
          'nbShops_range' => $nbShops_range,
          'nbAddons' => $nbAddons,
          'global_add_ons' => $global_add_ons,
          'faqs' => $faqs,
          'team_members' => $teamMembers,
          'teams' => $teams,
        ]);
        }

    }

    public function getUsersCount($period,$type='date')
    {
      $date = $type == 'date' ? Carbon::now()->subDays($period) : Carbon::now()->subMonth($period);
      return User::where('password', '!=', '')
                        ->whereDate('created_at', '>=' ,$date )
                        ->count();
    }

    // home view
    public function landing(){
        $latest_theme = Themes::select('version')->orderBy('id', 'desc')->first();
        $csm_dashboard = Cms::get()->toArray();
        $cms_dashboard_data = [];
        if(!empty($csm_dashboard)){
          foreach ($csm_dashboard as $key => $cms_data) {
              $cms_dashboard_data[$cms_data['title']] = $cms_data;
          }
        }

        return view('landing.landing',[
          'version' => $latest_theme->version,
          'cms_data' => $cms_dashboard_data
        ]);
    }

   // blackfriday view
    public function blackfriday_1(){
      return redirect()->route('landing');
    }
    // partners view
    public function partners(Request $request){

        $allPartners = Partner::whereNotNull('categories')->select('categories')->get();
        $categories = array();
        $transformedCategories = array();

        $allPartners->each(function($item, $key) use ($request, &$categories) {
            foreach ($item->categories as $category) {

                $categories[$category]['text']= ucfirst($category);
                $categories[$category]['value']= $category;
            }
        });

        $transformedCategories = array_values($categories);

        $partners = Partner::orderBy('created_at', 'desc')->when($request->has('category'), function($query) use($request) {
          return $query->whereJsonContains('categories', $request->category);
        })->get();

        return view('landing.partners',[
          'partners' => $this->_sortPartners($partners),
          'categories' => $transformedCategories
        ]);
    }

    // Single Partner View
    public function showPartner($slug){
      $partner = Partner::where('slug', $slug)->first();

      if (!$partner) {
        return redirect()->route('partners.landing');
      }

      return view('landing.single-partner',[
        'partner' => $partner
      ]);
    }

    public function searchPartner(Request $request) {
      $partners = Partner::orderBy('created_at', 'desc')->when($request->input('search_title'), function($query) use ($request) {
        return $query->where('name', 'like', '%'.$request->input('search_title').'%');
      })->when($request->input('category'), function($query) use ($request) {
        return $query->whereJsonContains('categories', $request->category);
      })->get();

      $html = View::make('landing.partners-result',['partners' => $this->_sortPartners($partners)]);
      $response = $html->render();

      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    private function _sortPartners($partners)
    {
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

     return $partners->sortBy('order');

    }

    // privacy view
    public function old(){
        return redirect()->route('landing');
    }

    // privacy view
    public function privacy(){
        return view('landing.privacy');
    }

    // download view
    public function download(){
      return view('landing.download');
    }

    // Thank you view
    public function thankYou(){
      return view('landing.thank-you');
    }

    // chat view
    public function chat(){
        return view('landing.chat');
    }

    // theme view
		public function theme(){
        return view('landing.theme');
    }

    // terms view
    public function terms(){
				return view('landing.terms');
    }

    // sales terms view
    public function sales_terms(){
				return view('landing.sales-terms');
    }

    // about view
    public function about(){
        return view('landing.about');
    }

    /**
     * return the courses page
     * @return view
     */
    public function courses(){
      $courses = Course::get();

      return view('landing.courses', [
        'courses' => $courses
      ]);
    }

    /**
     * return the about-us page
     * @return view
     */
    public function aboutUs(){
      return view('landing.about-us');
    }

    /**
     * return the subscription-confirm page
     * @return view
     */
     public function subscriptionConfirm(Request $request){
       $podcasts = Podcasts::orderBy('podcast_publish_date', 'desc')->limit(3)->get();
       $videos = YoutubeVideos::orderBy('id', 'desc')->limit(8)->get();

       return view('landing.subscription_confirm',compact('podcasts', 'videos'));
     }
    // career view
    public function career(){
				return view('landing.career');
    }

    // training view
    public function training(){
      return view('landing.training');
    }

    // reviews view
    public function reviews(){
			return view('landing.reviews');
    }

    // faq view
		public function faq(){
			return view('landing.faq');
    }

    // affiliate view
    public function affiliate(){
			return view('landing.affiliate');
    }

    // pricing view
    public function pricing(){
        return view('landing.pricing');
    }

    // addons view
    public function addons(){
        return view('landing.addons');
    }

    // testimonials view
    public function testimonials(){
        return view('landing.testimonials');
    }

    // youtubers view
    public function youtubers(){
        return view('landing.youtubers');
    }

    // contact view
    public function contact(){
        return view('landing.contact',[
            'status' => 'not done'
        ]);
    }

    // webinar view
    public function webinar(){
        return view('landing.webinar-new');
    }

    public function initiateDownload(Request $request) {
      $validator = Validator::make($request->all(), [
        'name' => ['required'],
        'email' => ['required', 'email'],
        'g-recaptcha-response' => ['required', new RecaptchaValidator],
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()->all()]);
      }

      $activeCampaign = new ActiveCampaignJobV3();
      $contact = $activeCampaign->sync([
        'email' => $request->input('email'),
        'firstName' => getName($request->input('name'), 'first'),
        'lastName' => getName($request->input('name'), 'last')
      ]);
      $updateListStatus = $activeCampaign->updateListStatus([
        'list' => AC::LIST_MASTERLIST,
        'contact' => $contact['id'],
        'status' => AC::LIST_SUBSCRIBE
      ]);

      $contactTag = AC::TAG_EVENT_LEAD;
      $tag = $activeCampaign->tag($contact['id'], $contactTag);

      return response()->json([
        'status' => 'success',
        'name' => $request->input('name'),
        'email' => $request->input('email')
      ]);
    }

    public function exitIntent(Request $request){
      $validator = Validator::make($request->all(), [
        'name' => ['required'],
        'email' => ['required', 'email'],
                        'g-recaptcha-response' => ['required', new RecaptchaValidator],
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()->all()]);
      }

      $activeCampaign = new ActiveCampaignJobV3();
      $contact = $activeCampaign->sync([
        'email' => $request->input('email'),
        'firstName' => getName($request->input('name'), 'first'),
        'lastName' => getName($request->input('name'), 'last')
      ]);
      $updateListStatus = $activeCampaign->updateListStatus([
        'list' => AC::LIST_MASTERLIST,
        'contact' => $contact['id'],
        'status' => AC::LIST_SUBSCRIBE
      ]);
      $tag = $activeCampaign->tag($contact['id'], AC::TAG_SOURCE_WEBSITE_EXIT_INTENT);

      return response()->json([
        'status' => 'success',
        'name' => $request->input('name'),
        'email' => $request->input('email')
      ]);
    }

    // contacted message
    public function contacted(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:255'],
            'hear' => ['required'],
            'help' => ['required'],
            'message' => ['required', 'max:255'],
            'g-recaptcha-response' => ['required', new RecaptchaValidator]
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $msg = '<html><head></head><body>
          Hello!<br><br>
          We received a contact us request from : <br>'
          . 'Name: '. $request->get('name') . '<br>'
          . 'Email: ' . $request->get('email') . '<br>'
          . 'Phone: ' . $request->get('phone') . '<br><br>'
          . 'Message: '. $request->get('message') . '<br><br><br>
          Please contact him asap and keep rocking!<br>
          The Debutify Team<br/><br/>
          Following is the text that does not need attention<br/>
          Morbi cursus tristique accumsan. Pellentesque a ipsum sed tortor tincidunt hendrerit. Pellentesque metus quam, feugiat eu nisl a, laoreet pulvinar tellus. Vestibulum et pulvinar orci, quis aliquet felis. Phasellus quis tristique metus. Mauris lectus sapien, finibus sed aliquet a, interdum vitae metus. Sed at sem nec mi tincidunt fringilla. Curabitur consectetur justo vel fermentum ullamcorper. Donec nec nisi purus. Proin aliquet id tortor pretium euismod. Praesent semper vestibulum ligula, ac imperdiet lorem lacinia eu. Proin luctus mollis tincidunt. Pellentesque gravida mattis blandit. Sed in diam non tortor pellentesque feugiat.<br/>

            Ut tortor urna, placerat et placerat non, porta vitae urna. Nullam mollis risus ligula, quis facilisis dui blandit at. Vivamus sodales felis est, placerat ullamcorper nunc consectetur ac. Morbi et lorem velit. Nulla vitae scelerisque sem. Curabitur dapibus iaculis sem vel aliquam. Quisque posuere fringilla magna id euismod. Phasellus aliquam luctus diam. Donec congue vestibulum orci in luctus. Proin placerat dolor ligula, ac pharetra erat maximus in. Fusce suscipit ante sit amet nisi fringilla commodo. Pellentesque non iaculis ex, vel elementum tortor. Mauris eleifend tortor eget aliquam dictum. Ut in justo elementum, efficitur dolor eu, scelerisque lorem. Proin pulvinar odio sit amet magna dapibus, at condimentum mauris malesuada. Curabitur viverra risus non posuere maximus.<br/>

            In hendrerit leo a eros eleifend, non lacinia nisl accumsan. Morbi auctor id erat et ornare. Donec cursus efficitur elit, id auctor risus egestas ut. Vivamus blandit tristique nisl id feugiat. Duis sodales ut mauris a venenatis. Integer id elit aliquet, hendrerit diam non, laoreet ante. Curabitur dapibus diam vel enim lacinia tincidunt. Quisque ex ex, viverra sed varius in, dapibus ac leo. Quisque lobortis faucibus libero vel faucibus. Ut id euismod odio. In consectetur, justo quis pulvinar dignissim, neque justo venenatis velit, in venenatis ipsum nibh id mi. Nullam nec ante semper magna iaculis iaculis ac tempor ante.<br/>

            Quisque nec felis non risus mollis faucibus nec vel risus. Cras facilisis non risus quis fermentum. Sed aliquam nulla hendrerit metus pellentesque accumsan. Cras lectus mi, accumsan at dolor consectetur, maximus aliquam leo. Aliquam scelerisque nulla et justo maximus lacinia. Quisque diam mauris, varius sit amet ullamcorper non, imperdiet a lectus. In ac auctor odio. Vivamus nisi leo, aliquam nec ornare nec, tincidunt sit amet mauris. Suspendisse finibus tincidunt purus, congue eleifend massa convallis vel. Aenean fermentum pellentesque rhoncus. Suspendisse potenti. Vivamus ornare enim ac iaculis congue.<br/>

            Mauris non massa tempor metus facilisis imperdiet. Mauris venenatis id lorem eget faucibus. Duis vestibulum iaculis leo, ultricies consectetur lacus blandit sit amet. In sit amet convallis erat, eget posuere nisl. Donec ultricies a sem eget viverra. Nullam ultrices pretium arcu in laoreet. Nullam lorem mi, interdum vel euismod ac, facilisis vel lectus. Integer lacinia, sapien quis semper tristique, ipsum massa tristique quam, sit amet consectetur velit neque quis odio. Vivamus id arcu vel neque lobortis fringilla. Donec turpis duis.<br/>

          </body>
          </html>
        ';

        $plainMsg = preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($msg))) );

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg, 70);

        // https://app.sendgrid.com/guide/integrate/langs/php
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(config('env-variables.DEBUTIFY_SUPPORT_EMAIL'), "Debutify");
        $email->setSubject("A client from debutify sent a Contact request");
        $email->addTo(config('env-variables.DEBUTIFY_SUPPORT_EMAIL'), "Debutify");
        $email->addContent("text/plain", $plainMsg);
        $email->addContent("text/html", $msg);
        $sendgrid = new \SendGrid(config('env-variables.SENDGRID_API_KEY'));
        try {
          $response = $sendgrid->send($email);
          \Log::info('Contact us email sent! From : ' . $request->get('email'));
        } catch (Exception $e) {
          \Log::error('Failed to send contact us email');
        }

        // save in database
        $contact = new Contact;
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->phone_no = $request->get('phone');
        $contact->message = $request->get('message');
        $contact->save();
        return Redirect::to('contact')->withSuccess('done');
    }

    public function webinarNew() {
      $webinars = Webinar::paginate(8);
      $dateNow = date('Y-m-d');
      $date = strtotime(date('Y-m-d'));
      $date7 = strtotime("+7 day", $date);
      $dateformat = date('Y-m-d',$date7);

      $upcoming = Webinar::where('release_date','<=',$dateformat)->where('release_date','>=',$dateNow)->get();
      return view('landing.webinarNew', ['webinars' => $webinars,'upcomings' => $upcoming]);
    }

    public function webinarSearch(Request $request) {

      $webinar = Webinar::where(function ($query) use ($request) {
        if($request->query('query') != ''){
                $query->where('title', 'like', '%'.$request->query('query').'%');
        }
      })->orderBy('id', 'desc')->paginate(8);

        $html = View::make('landing.searched_webinar_landing', ['webinars' => $webinar , 'searchValue' => $request->query('query') ]);

        $response = $html->render();
        return response()->json([
          'status' => 'success',
          'html' => $response
        ]);
    }
}
