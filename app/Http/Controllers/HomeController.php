<?php

namespace App\Http\Controllers;

use App\YoutubeVideos;
use File;
use Hash;
use DateTime;
use App\Step;
use App\User;
use App\AddOns;
use App\Themes;
use App\Updates;
use App\Course;
use App\Module;
use App\AdminUser;
use App\FreeAddon;
use App\StripePlan;
use App\WinningProduct;
use App\AddOnInfo;
use App\TeamMember;
use App\FrequentlyAskedQuestion;
use App\Webinar;
use App\Themefile;
use App\ThemefileContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PulkitJalan\Google\Facades\Google;
use PulkitJalan\Google\GoogleServiceProvider;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Podcasts;
use App\Blog;
use App\Partner;
use Illuminate\Support\Facades\Session;
use App\Subscription;
use App\StoreThemes;
use DB;
use App\MainSubscription;
use App\SubscriptionPaypal;
use App\SubscriptionStripe;
use App\ExtendTrial;
use App\Cms;
use App\AddOnsReport;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use App\Constants\SubscriptionPlans;
use ZipArchive;
use DirectoryIterator;
use App\Jobs\GenerateAddOnAnalyticsData;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AddOnsAnalyticsExport;
use App\Exports\AddOnsPlanAnalyticsExport;
use App\Exports\ColorsAnalyticsExport;
use App\Exports\AnalyticsExport;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('auth:admin');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('users', $roles))
      {
        echo "You don't have permission to users.";
        die;
      }

      $StripePlan = StripePlan:: all();
      $starterPriceAnnually = $starterPriceMonthly = $hustlerPriceAnnually = 0;
      $hustlerPriceMonthly = $guruPriceAnnually = $guruPriceMonthly = 0;

      foreach ($StripePlan as $plan) {
          if($plan->name == SubscriptionPlans::STARTER_PRICE_ANNUALLY){
              $starterPriceAnnually = $plan->cost;
          }
          if($plan->name == SubscriptionPlans::STARTER_PRICE_MONTHLY){
              $starterPriceMonthly = $plan->cost;
          }
          if($plan->name == SubscriptionPlans::HUSTLER_PRICE_ANNUALLY){
              $hustlerPriceAnnually = $plan->cost;
          }
          if($plan->name == SubscriptionPlans::HUSTLER_PRICE_MONTHLY){
              $hustlerPriceMonthly = $plan->cost;
          }
          if($plan->name ==  SubscriptionPlans::MASTER_PRICE_ANNUALLY){
              $guruPriceAnnually = $plan->cost;
          }
          if($plan->name == SubscriptionPlans::MASTER_PRICE_MONTHLY){
              $guruPriceMonthly = $plan->cost;
          }
      }

  	  $keyword = '';

  	  if ($request->isMethod('get') && $request->input('q') != '') {
  		  $keyword = $request->input('q');

  		  $shop = User::withTrashed()->where(function ($query) use($keyword) {
  				$query->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('custom_domain', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->orWhere('created_at', 'like', '%' . $keyword . '%');
  			})->orderBy('id', 'desc')
          ->paginate(100);
  	  } else {
  		  $shop = User::withTrashed()->orderBy('id', 'desc')->paginate(100);
  	  }

      $free_addons_count = FreeAddon::where('status',1)->count();
      $shop_null = User::whereNull('alladdons_plan')->count();
      $shop_unactive = User::whereNotNull('deleted_at')->count();
      $shop_active = User::whereNull('deleted_at')->count();

      $starterCount = User::where('alladdons_plan', 'Starter')->count();
      $starterMonthly = User::where('alladdons_plan', 'Starter')->where('sub_plan', 'month')->count();
      $starterAnnually = User::where('alladdons_plan', 'Starter')->where('sub_plan', 'yearly')->count();

      $hustlerCount = User::where('alladdons_plan', 'Hustler')->count();
      $hustlerMonthly = User::where('alladdons_plan', 'Hustler')->where('sub_plan', 'month')->count();
      $hustlerAnnually = User::where('alladdons_plan', 'Hustler')->where('sub_plan', 'yearly')->count();;

      $guruCount = (User::where('alladdons_plan', 'Master')->count())-1;
      $guruMonthly = (User::where('alladdons_plan', 'Master')->where('sub_plan', 'month')->count())-1;
      $guruAnnually = User::where('alladdons_plan', 'Master')->where('sub_plan', 'yearly')->count();

      $basicAddonsCount = User::where('alladdons_plan', 'basic')->count();
      $all_addons = User::where('alladdons_plan', 'basic')->get();
      $basicAddonsActive=0;
      foreach ($all_addons as $all_addon) {
        $addon_activated = AddOns::where('user_id',$all_addon->id)->where('status',1)->count();
        $basicAddonsActive += $addon_activated;
      }

      $basicAddonsMonthly = $basicAddonsActive*2;

      $totalPriceMonthly = ($starterMonthly*$starterPriceMonthly)+($hustlerMonthly*$hustlerPriceMonthly)+($guruMonthly*$guruPriceMonthly);
      $totalPriceAnnually = ($starterAnnually*$starterPriceAnnually)+($hustlerAnnually*$hustlerPriceAnnually)+($guruAnnually*$guruPriceAnnually);

      $paid = $starterCount+$hustlerCount+$guruCount+$basicAddonsCount;

      $mrr = ($totalPriceMonthly)+($totalPriceAnnually/12)+($basicAddonsMonthly);
      $arr = (($totalPriceMonthly*12)+$totalPriceAnnually)+($basicAddonsMonthly*12);
      $mrrGoal = 1000;

      $freemium = $shop_active - $paid;

      $allmix = [];
      $basic_addons = 0;
      $already_addon_activated = 0;

      foreach ($shop as $shops) {

        if($shops->deleted_at){
          $shops->status = 'Inactive';
        }
        elseif (empty($shops->password)) {
          $shops->status = 'Pending';
        }
        else{
          $shops->status = 'Active';
        }

        if($shops->alladdons_plan == 'Starter'){
          $addon_activated = AddOns::where('user_id',$shops->id)->where('status',1)->count();
          $basic_addons += $addon_activated;
        }

        $already_addon_activated = AddOns::where('user_id',$shops->id)->where('status',1)->count();
        $free_addons = FreeAddon::where('shopify_domain', $shops->name)->where('status',1)->first();

        if($free_addons){
          $free_addons = $free_addons->status;
        }

        $shops->count = $already_addon_activated;
        $shops->referral = $free_addons;
        $allmix[] = $shops;
      }
        
      // search changes 3

      return view('admin.dashboard', [
        'freemium' => $freemium,
        'starterCount' => $starterCount,
        'starterMonthly' => $starterMonthly,
        'starterAnnually' => $starterAnnually,
        'hustlerCount' => $hustlerCount,
        'hustlerMonthly' => $hustlerMonthly,
        'hustlerAnnually' => $hustlerAnnually,
        'guruCount' => $guruCount,
        'guruMonthly' => $guruMonthly,
        'guruAnnually' => $guruAnnually,
        'starterPriceAnnually' => $starterPriceAnnually,
        'starterPriceMonthly' => $starterPriceMonthly,
        'hustlerPriceAnnually' => $hustlerPriceAnnually,
        'hustlerPriceMonthly' => $hustlerPriceMonthly,
        'guruPriceAnnually' => $guruPriceAnnually,
        'guruPriceMonthly' => $guruPriceMonthly,
        'totalPriceMonthly' => $totalPriceMonthly,
        'totalPriceAnnually' => $totalPriceAnnually,
        'paid' => $paid,
        'shops' => $allmix,
        'shop_pagination' => $shop->appends($request->except('page')),
        'mrr' => $mrr,
        'arr' => $arr,
        'mrrGoal' => $mrrGoal,
        'mrrGoalPercentage' => ($mrr/$mrrGoal) * 100,
        'shopifyreferral' => $free_addons_count,
        'basic_addons' => $basic_addons,
        'already_addon_activated' => $already_addon_activated,
        'basicAddonsCount' => $basicAddonsCount,
        'shop_null' => $shop_null,
        'basicAddonsMonthly' => $basicAddonsMonthly,
        '$basicAddonsCount' => $basicAddonsCount,
        'basicAddonsActive' => $basicAddonsActive,
        'nbShops' => User::count(),
        'keyword' => $keyword,
      ]);
    }

    public function admin_dashboard() {
      $roles = json_decode(Auth::user()->user_role, true);
      $data = [
        'users' => User::count(),
        'products' => WinningProduct::count(),
        'course' => Course::count(),
        'themes' => Themes::count(),
        'updates' => Updates::count(),
        'podcasts' => Podcasts::count(),
        'blogs' => Blog::count(),
        'partners' => Partner::count(),
        'admin_user' => AdminUser::count(),
        'youtube_videos' => YoutubeVideos::count(),
        'faq' => FrequentlyAskedQuestion::count(),
        'extend_trial' => ExtendTrial::count(),
        'cms' => Cms::count(),
        'addons_reports' => AddOnsReport::count(),
        'addons' => AddOnInfo::count(),
        'team_members' => TeamMember::count(),
        'webinar' => Webinar::count(),
      ];

      return view('admin.admin_dashboard', [
        'roles' => $roles,
        'user_data'=> $data
      ]);
    }

    public function usersSearch(Request $request){
      $shops = User::withTrashed()->where(function ($query) use ($request){
              if($request->query('query') != ''){
                  $query->where('name', 'like', '%' . $request->query('query') . '%')
                  ->orWhere('custom_domain', 'like', '%' . $request->query('query') . '%')
                  ->orWhere('email', 'like', '%' . $request->query('query') . '%')
                  ->orWhere('created_at', 'like', '%' . $request->query('query') . '%')
                  ->orWhere('shop_id', 'like', '%' . $request->query('query') . '%')
                  ->orWhereHas('paypalSubscription', function($query) use ($request) {
                    return $query->where('paypal_email', 'like', '%' . $request->query('query') . '%');
                  });
              }
            })->orderBy('id', 'desc')
        ->paginate(10);

      $html = View::make('admin.searched_users',['shops' => $shops]);

      $response = $html->render();
      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    public function show_addons_report(){
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('addons_reports', $roles)) {
          echo "You don't have permission to access AddOns Reports.";
          die;
      }

      $reports = AddOnsReport::orderBy('id', 'desc')->paginate(20);
      return view('admin.addons_report', ['reports' => $reports]);
    }

    public function generate_settings_report(){
      // \Artisan::queue('update:addonanalytics');
      dispatch(new GenerateAddOnAnalyticsData());

      return redirect()->back()->with('status', 'Your request for generate AddOns Settings Report is in progress. The report will be generate in few hours'); 
    }

    public function export($id, $type) {
        switch ($type) {
        case "all_active_addons":
          return Excel::download(new AddOnsAnalyticsExport($id), 'all_addons_analytics_report('. date("Y-m-d h:i:s") .').xlsx');
        case "plan_wise_active_addons":
          return Excel::download(new AddOnsPlanAnalyticsExport($id), 'plan_addons_analytics_report('. date("Y-m-d h:i:s") .').xlsx');
        case "top_used_colors":
          return Excel::download(new ColorsAnalyticsExport($id), 'top_colors_analytics_report('. date("Y-m-d h:i:s") .').xlsx');
        default:
          return Excel::download(new AddOnsAnalyticsExport($id), 'all_addons_analytics_report('. date("Y-m-d h:i:s") .').xlsx');
      }
    }

    public function view_settings_report($id){
      $report = AddOnsReport::whereId($id)->first();
      if($report) {
        return view('admin.view_addons_report', ['report' => $report]);
      }
      return redirect('/admin/addons_report')->with('error', 'Invaild report ID or record does not exist!'); 
    }

    public function addtheme(){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('themes', $roles)){
        echo "You don't have permission to view.";die;
      }
        return view('admin.addtheme');
    }

    public function themes(){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('themes', $roles)){
        echo "You don't have permission to view.";die;
      }
      $themes = Themes::orderBy('id', 'desc')->get();
      // $themes = Themes::get();
      return view('admin.themes', [
        'themes' => $themes
      ]);
    }

    public function uploadAsset(Request $request)
    {
      $validatedData = $request->validate(['asset_file' => 'required|file']);
      $image = $request->file('asset_file');
      $image = is_array($image) ? $image[0] : $image;
      $filename  = time() .'-'.pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME).'.' . $image->getClientOriginalExtension();
      $assetURL = config('app.url').'/storage/courses/'.$filename;

      Storage::putFileAs('public/courses', $image, $filename);

      return response()->json([
        'success' => 1,
        'url' => $assetURL,
        'name' => $filename
      ]);
    }

    // courses
    public function courses(Request $request){

      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('courses', $roles)){
        echo "You don't have permission to courses.";die;
      }

      $keyword = '';
      if ($request->isMethod('get') && $request->input('q') != '') {
        $keyword = $request->input('q');
        $courses = Course::where(function ($query) use ($request, $keyword){
                if($request->query('query') != ''){
                        $query->where('title', 'like', '%'.$keyword.'%');
                }
            })->orderBy('id', 'desc')
        ->paginate(50);
      }else{
        $courses = Course::orderBy('id', 'desc')->paginate(50);
      }
      return view('admin.courses', ['courses' => $courses, 'keyword' => $keyword]);
    }

    public function coursesSearch(Request $request){
      $courses = Course::where(function ($query) use ($request){

                if($request->query('query') != ''){
                        $query->where('title', 'like', '%'.$request->query('query').'%');
                }
            })->orderBy('id', 'desc')
        ->paginate(50);

      $html = View::make('admin.searched_courses',['courses' => $courses]);

      $response = $html->render();
      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    public function addcourse(Request $request){
      $roles = json_decode(Auth::user()->user_role,1);

      if (!isset($roles) || empty($roles) || !in_array('courses', $roles)) {
        echo "You don't have permission to courses.";die;
      }

      return view('admin.addcourse', [
        'assets' => $this->getAssets($request)
      ]);
    }

    public function createcourse(Request $request){

      $validator = Validator::make($request->all(), [
            'Title' => 'required',
            'Description' => 'required',
      ]);
      if ($validator->fails())
      {
          return response()->json(['errors'=>$validator->errors()->all()]);
      }

      $modules = $request->get('modules');
      $modules = json_decode($modules, true);

      $course = new Course;
      $course->title = $request->get('Title');
      $course->description = $request->get('Description');
      if($request->has('image')){
        $img_name = 'course_'.time().'.'.$request->get('image_ext');
        $img_content = file_get_contents($request->get('image'));
        Storage::put('public/courses/'.$img_name, $img_content);
        $img_url = config('app.url').'/storage/courses/'.$img_name;
        $course->image = $img_url;
      }
      if($request->has('plans')){
        $plans = implode(",", $request->get('plans'));
        $course->plans = $plans;
      }
      $course->save();
      $path= storage_path().'/app/public/videos/course_'.$course->id;
      File::makeDirectory($path, 0777, true, true);

      for($i=0;$i<count($modules);$i++){
        $cur_index = $i+1;
        $module = new Module;
        $module->course_id = $course->id;
        $module->title = $modules[$i]['title'];
        $module->description = $modules[$i]['desc'];
        $module->position = $cur_index;
        $module->save();
        if(isset($modules[$i]['steps'])){
          for($j=0;$j<count($modules[$i]['steps']);$j++){
            $curr_index = $j+1;
            $step = new Step;
            $step->module_id = $module->id;
            $step->title = $modules[$i]['steps'][$j]['title'];
            $step->description = $modules[$i]['steps'][$j]['desc'];
            $step->tags = $modules[$i]['steps'][$j]['tags'];
            $step->position = $curr_index;
            $cur_step = $j+1;
            $url1 = null;
            $url2 = null;

            if (isset($modules[$i]['steps'][$j]['video1'])) {
              $url1 = $modules[$i]['steps'][$j]['video1'];
            }

            if (isset($modules[$i]['steps'][$j]['video2'])) {
              $url2 = $modules[$i]['steps'][$j]['video2'];
            }

            $step->video1 = $url1;
            $step->video2 = $url2;
            $step->save();
          }
        }
      }
      $request->session()->flash('status', 'New course created successfully');
      return response()->json([
          'status' => 'ok',
          'redirect'=> route('courses')
      ]);
    }

    public function showcourse(Request $request,$id){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('courses', $roles)){
        echo "You don't have permission to courses.";die;
      }
      $course = Course::where('courses.id',$id)->with(['modules.steps' => function ($query) { $query->orderBy('position', 'asc');}])->first();
      $all_plans = ['Freemium','Starter','Hustler','Master'];
      $course->plans = explode(",", $course->plans);
      $course->all_plans = $all_plans;
      $course = json_decode($course);
      $all_files = array();
      $video_files = Storage::files('public/videos/course_'.$course->id);

      foreach ($video_files as $file) {
        $files['url'] = config('app.url').'/'.str_replace('public','storage',$file);
        $file_name = explode('public/videos/course_'.$course->id.'/', $file);
        $files['name'] = $file_name[1];
        $all_files[] = $files;
      }

      return view('admin.editcourse', [
        'course' => $course,
        'video_files' => $all_files,
        'assets' => $this->getAssets($request)
      ]);
    }

    public function getAssets(Request $request, $type = [])
    {
      $assets = collect(Storage::files('public/courses'))->map(function ($file) {
        return [
          'name' => str_replace('public/courses/', '', $file),
          'path' => $file,
          'url' => url(Storage::url($file))
        ];
      })->reject(function ($file) use($type) {
        $allowed = $type;
        $excluded = ['.DS_Store'];

        if (!count($allowed)) {
          return Str::contains($file['name'], $excluded);
        }

        return !Str::contains($file['name'], $allowed) || Str::contains($file['name'], $excluded);
      });

      // Return rendered HTML
      if ($request->get('type') == 'html') {
        return response()->json([
          'success' => true,
          'html' => View::make('admin.assets', ['assets' => $assets])->render()
        ]);
      }

      return $assets;
    }

    public function editcourse(Request $request,$id){
      $validator = Validator::make($request->all(), [
            'Title' => 'required',
            'Description' => 'required',
      ]);
      if ($validator->fails())
      {
          return response()->json(['errors'=>$validator->errors()->all()]);
      }

      $modules = $request->get('modules');
      $modules = json_decode($modules, true);

      $course = Course::find($id);
      if($course){
        $course->title = $request->get('Title');
        $course->description = $request->get('Description');
        if($request->has('image')){
          if ($request->get('image') != $course->image) {
            $img_name = 'course_'.time().'.'.$request->get('image_ext');
            $img_content = file_get_contents($request->get('image'));
            Storage::put('public/courses/'.$img_name, $img_content);
            $img_url = config('app.url').'/storage/courses/'.$img_name;
            $course->image = $img_url;
          } else {
            $course->image = $request->get('image');
          }
        }else{
          $course->image = null;
        }
        if($request->has('plans')){
          $plans = implode(",", $request->get('plans'));
          $course->plans = $plans;
        }
        $course->save();

        for($i=0;$i<count($modules);$i++){
          $cur_index = $i+1;
          $module = Module::find($modules[$i]['id']);
          if($module){
            $module->title = $modules[$i]['title'];
            $module->description = $modules[$i]['desc'];
            $module->position = $cur_index;
            $module->save();

            if(isset($modules[$i]['steps'])){
              for($j=0;$j<count($modules[$i]['steps']);$j++){
                $curr_index = $j+1;
                $step = Step::find($modules[$i]['steps'][$j]['id']);
                if($step){
                  $step->position = $curr_index;
                  $step->title = $modules[$i]['steps'][$j]['title'];
                  $step->description = $modules[$i]['steps'][$j]['desc'];
                  $step->tags = $modules[$i]['steps'][$j]['tags'];
                  $cur_step = $j+1;

                  $url1 = null; $url2 = null;
                  if(isset($modules[$i]['steps'][$j]['video1']) && $modules[$i]['steps'][$j]['video1'] != ''){
                  	$url1 = $modules[$i]['steps'][$j]['video1'];
                  }

                  if(isset($modules[$i]['steps'][$j]['video2']) && $modules[$i]['steps'][$j]['video2'] != ''){
                  	$url2 = $modules[$i]['steps'][$j]['video2'];
                  }

                  $step->video1 = $url1;
                  $step->video2 = $url2;

                }else{
                  $step = new Step;
                  $step->module_id = $module->id;
                  $step->position = $curr_index;
                  $step->title = $modules[$i]['steps'][$j]['title'];
                  $step->description = $modules[$i]['steps'][$j]['desc'];
                  $step->tags = $modules[$i]['steps'][$j]['tags'];
                  $cur_step = $j+1;

                  $url1 = null;$url2 = null;
                  if(isset($modules[$i]['steps'][$j]['video1']) && $modules[$i]['steps'][$j]['video1'] != ''){
                    // $namefile1 = 'module'.$module->id. '-step'.$cur_step.'-v1_'.time().'.'.$modules[$i]['steps'][$j]['video1_ext'];
                    // $content1 = file_get_contents($modules[$i]['steps'][$j]['video1']);
                    // Storage::put('public/steps/'.$namefile1, $content1);
                    // $url1 = config('app.url').'/storage/steps/'.$namefile1;
                    $url1 = config('app.url').'/storage/videos/course_'.$course->id.'/'.$modules[$i]['steps'][$j]['video1'];
                  }

                  if(isset($modules[$i]['steps'][$j]['video2']) && $modules[$i]['steps'][$j]['video2'] != ''){
                    // $namefile2 = 'module'.$module->id. '-step'.$cur_step.'-v2_'.time().'.'.$modules[$i]['steps'][$j]['video2_ext'];
                    // $content2 = file_get_contents($modules[$i]['steps'][$j]['video2']);
                    // Storage::put('public/steps/'.$namefile2, $content2);
                    // $url2 = config('app.url').'/storage/steps/'.$namefile2;
                    $url2 = config('app.url').'/storage/videos/course_'.$course->id.'/'.$modules[$i]['steps'][$j]['video2'];
                  }
                  $step->video1 = $url1;
                  $step->video2 = $url2;
                }

                $step->save();
              }
            }
          }else{
            $module = new Module;
            $module->course_id = $course->id;
            $module->position = $cur_index;
            $module->title = $modules[$i]['title'];
            $module->description = $modules[$i]['desc'];
            $module->save();
            if(isset($modules[$i]['steps'])){
              for($j=0;$j<count($modules[$i]['steps']);$j++){
                  $curr_index = $j+1;
                  $step = new Step;
                  $step->module_id = $module->id;
                  $step->position = $curr_index;
                  $step->title = $modules[$i]['steps'][$j]['title'];
                  $step->description = $modules[$i]['steps'][$j]['desc'];
                  $step->tags = $modules[$i]['steps'][$j]['tags'];
                  $cur_step = $j+1;

                  $url1 = null; $url2 = null;
                  if(isset($modules[$i]['steps'][$j]['video1']) && $modules[$i]['steps'][$j]['video1'] != ''){
                    // $namefile1 = 'module'.$module->id. '-step'.$cur_step.'-v1_'.time().'.'.$modules[$i]['steps'][$j]['video1_ext'];
                    // $content1 = file_get_contents($modules[$i]['steps'][$j]['video1']);
                    // Storage::put('public/steps/'.$namefile1, $content1);
                    // $url1 = config('app.url').'/storage/steps/'.$namefile1;
                    $url1 = config('app.url').'/storage/videos/course_'.$course->id.'/'.$modules[$i]['steps'][$j]['video1'];
                  }

                  if(isset($modules[$i]['steps'][$j]['video2']) && $modules[$i]['steps'][$j]['video2'] != ''){
                    // $namefile2 = 'module'.$module->id. '-step'.$cur_step.'-v2_'.time().'.'.$modules[$i]['steps'][$j]['video2_ext'];
                    // $content2 = file_get_contents($modules[$i]['steps'][$j]['video2']);
                    // Storage::put('public/steps/'.$namefile2, $content2);
                    // $url2 = config('app.url').'/storage/steps/'.$namefile2;
                    $url2 = config('app.url').'/storage/videos/course_'.$course->id.'/'.$modules[$i]['steps'][$j]['video2'];
                  }
                  $step->video1 = $url1;
                  $step->video2 = $url2;

                  $step->save();
              }
            }
          }
        }
      }
      $request->session()->flash('status', 'Course has been updated successfully');
      return response()->json([
          'status' => 'ok',
          'redirect'=> route('courses')
      ]);
    }

    public function deleteModule(Request $request){
      $module = Module::find($request->get('module_id'));
      if($module){
        $module->delete();
      }
      return response()->json([
          'status' => 'success'
      ]);
    }

    public function deleteStep(Request $request){
      $step = Step::find($request->get('step_id'));
      if($step){
        $step->delete();
      }
      return response()->json([
          'status' => 'success'
      ]);
    }

    public function deleteCourse(Request $request,$id){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('courses', $roles)){
        echo "You don't have permission to courses.";die;
      }
      $course = Course::find($id);
      if($course){
        $course->delete();
      }
      $request->session()->flash('status', 'Course deleted successfully');
      return response()->json([
          'status' => 'ok',
          'redirect'=> route('courses')
      ]);
    }

    public function deleteAsset(Request $request){
      $validatedData = $request->validate([
        'url' => 'required',
        'path' => 'required'
      ]);

      return Storage::delete($request->input('path'));
    }

    // products
    public function products(Request $request){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('products', $roles)){
        echo "You are not authorized User for Products";die;
      }
		$keyword = '';
		if ($request->isMethod('get') && $request->input('q') != '') {
		  $keyword = $request->input('q');
		  $products = WinningProduct::where(function ($query) use($keyword) {
				$query->where('name', 'like', '%' . $keyword . '%')
				->orWhere('aliexpresslink', 'like', '%' . $keyword . '%')
				->orWhere('price', 'like', '%' . $keyword . '%');
			})->orderBy('id', 'desc')
			->paginate(50);
		}else{
			$products = WinningProduct::orderBy('id', 'desc')->paginate(50);
		}

		return view('admin.products', ['products' => $products->appends($request->except('page')), 'keyword' => $keyword]);
    }

    public function productsSearch(Request $request){

      $products = WinningProduct::where(function ($query) use($request) {
        if($request->query('q') != ''){
          $query->where('name', 'like', '%' . $request->query('q') . '%')
          ->orWhere('aliexpresslink', 'like', '%' . $request->query('q') . '%')
          ->orWhere('price', 'like', '%' . $request->query('q') . '%');
        }
      })->orderBy('id', 'desc')
      ->paginate(50);

      $html = View::make('admin.searched_products',['products' => $products]);

      $response = $html->render();
      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    public function addproduct(){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('products', $roles)){
        echo "You are not authorized User for Products";die;
      }
      return view('admin.addproduct');
    }

    public function newproduct(Request $request){
      // $this->validate($request, [
      //   'name' => 'required',
      //   'price' => 'required',
      //   'cost' => 'required',
      //   'profit' => 'required',
      //   'aliexpresslink' => 'required',
      //   'facebookadslink' => 'required',
      //   'googletrendslink' => 'required',
      //   'youtubelink' => 'required',
      //   'competitorlink' => 'required',
      //   'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      // ]);

      // $this->validate($request, [
      //     'video' => 'max:500000',
      // ]);
      // $video = $request->file('video');
      // if($video){
      //   $filename = 'product_video'.time().'.'.$video->getClientOriginalExtension();
      //   $destinationPath = public_path('product_video');
      //   $video->move($destinationPath,$filename);
      //   $videos= $filename;
      // }
      //

      // $images ='';
      // $image = $request->file('image');
      // if($image){
      //   $input['imagename'] = 'product'.time().'.'.$image->getClientOriginalExtension();
      //   $destinationPath = public_path('images/product');
      //   $img = Image::make($image->getRealPath());

      //   $img->resize(300, 300, function($constraint){
      //     $constraint->aspectRatio();
      //   })->save($destinationPath.'/'.$input['imagename']);
      //   $images = $input['imagename'];
      // }

      $age = implode(",",$request->age);
      $gender = implode(",",$request->gender);
      $placement = implode(",",$request->placement);

      $product = new WinningProduct;
      $product->name = $request->name;
      $product->price = $request->price;
      $product->cost = $request->cost;
      $product->profit = $request->profit;
      $product->aliexpresslink = $request->aliexpresslink;
      $product->facebookadslink = $request->facebookadslink;
      $product->googletrendslink = $request->googletrendslink;
      $product->youtubelink = $request->youtubelink;
      $product->competitorlink = $request->competitorlink;
      $product->age = $age;
      $product->gender = $gender;
      $product->placement = $placement;
      $product->saturationlevel = $request->saturationlevel;
      $product->category = $request->category;
      $product->interesttarget = $request->interesttarget;
      $product->image = $request->image;
      $product->opinion = $request->opinion;
      $product->description = $request->description;
      $product->video = $request->video;
      $product->save();
      $request->session()->flash('status', 'Upload New Product successfully');
      return redirect()->route('products');
    }

    public function showproduct($id){
      $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('products', $roles)){
        echo "You are not authorized User for Products";die;
      }
      $all_ages=['18-24','25-34','35-44','45-54','55-64','65+'];
      $all_genders=['Men','Women'];
      $all_placements=['Mobile','Desktop'];
      $product = WinningProduct::find($id);
      $product->age = explode(",",$product->age);
      $product->gender = explode(",",$product->gender);
      $product->placement = explode(",",$product->placement);
      $age=[];
      $placement =[];
      $gender=[];
      foreach ($all_genders as $keys => $all_gender) {
        $check=false;
        foreach ($product->gender as $key => $genders) {
          if($genders == $all_gender){
            $gender[] = array('gender' =>$genders, 'selected'=>'selected');
            $check = true;
          }
        }
        if($check){}else{
          $gender[] = array('gender' =>$all_gender, 'selected'=>'');
        }
      }
      $product->gender = $gender;
      foreach ($all_placements as $keys => $all_placement) {
        $check=false;
        foreach ($product->placement as $key => $placements) {
          if($placements == $all_placement){
            $placement[] = array('placement' =>$placements, 'selected'=>'selected');
            $check = true;
          }
        }
        if(!$check){
          $placement[] = array('placement' =>$all_placement, 'selected'=>'');
        }
      }
      $product->placement = $placement;
      foreach ($all_ages as $keys => $all_age) {
        $check=false;
        foreach ($product->age as $key => $ages) {
          if($ages == $all_age){
            $age[] = array('age' =>$ages, 'selected'=>'selected');
            $check = true;
          }
        }
        if(!$check){
          $age[] = array('age' =>$all_age, 'selected'=>'');
        }
      }
     $product->age = $age;
      return view('admin.editproduct', ['product' => $product]);
    }

    public function editproduct(Request $request, $id){

      $age = implode(",",$request->age);
      $gender = implode(",",$request->gender);
      $placement = implode(",",$request->placement);

      $product = WinningProduct::find($id);
      $product->name = $request->name;
      $product->price = $request->price;
      $product->cost = $request->cost;
      $product->profit = $request->profit;
      $product->aliexpresslink = $request->aliexpresslink;
      $product->facebookadslink = $request->facebookadslink;
      $product->googletrendslink = $request->googletrendslink;
      $product->youtubelink = $request->youtubelink;
      $product->competitorlink = $request->competitorlink;
      $product->age = $age;
      $product->gender = $gender;
      $product->placement = $placement;
      $product->saturationlevel = $request->saturationlevel;
      $product->category = $request->category;
      $product->interesttarget = $request->interesttarget;
      $product->image = $request->saveimage;
      $product->opinion = $request->opinion;
      $product->description = $request->description;
      $product->video = $request->saveVideo;
      $product->save();
      $request->session()->flash('status', 'Product has been updated successfully');
      return redirect()->route('products');
    }

    public function newtheme(Request $request){
        $file = $request->file('theme_file');
        $file = is_array($file) ? $file[0] : $file;
        //$filename = 'debutify-'.$theme_version.'-'. time() . '.' . $file->getClientOriginalExtension();
        $filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('themes', $filename, 'public');
        $url = config('app.url').'/storage/'.$path;

        $themes = new Themes;
        $themes->version = $request->version;
        $themes->size = $file->getSize();
        $themes->url = $url;

        if(isset($request->is_beta_theme) && !empty($request->is_beta_theme)){
            $themes->is_beta_theme = 1;
        }
        else {
            $themes->is_beta_theme = 0;
        }
        $themes->save();

        try {
            $themeUrl = public_path('storage/'.$path);
            $allThemeFiles = array();
            $fileContent = array();
            $za = new ZipArchive(); 

            $za->open($themeUrl);
            $za->extractTo(public_path('storage/temp/'));

            $tempDirectory = public_path('storage/temp/');

            for( $i = 0; $i < $za->numFiles; $i++ ) {
                $filename = '';
                $stat = $za->statIndex( $i );
                // save all filenames as an array
                if (is_file($tempDirectory.$stat['name'])) {
                    // get only the files in layout, sections, templates, assets, locales and config folder
                    if (strpos($stat['name'], 'layout/') !== false) {
                        $filename = 'layout/'.substr($stat['name'] , strpos($stat['name'], "layout/") + 7);
                    }
                    else if (strpos($stat['name'], 'sections/') !== false) {
                        $filename = 'sections/'.substr($stat['name'] , strpos($stat['name'], "sections/") + 9);
                    }
                    else if (strpos($stat['name'], 'snippets/') !== false) {
                        $filename = 'snippets/'.substr($stat['name'] , strpos($stat['name'], "snippets/") + 9);
                    }
                    else if (strpos($stat['name'], 'templates/') !== false) {
                        $filename = 'templates/'.substr($stat['name'] , strpos($stat['name'], "templates/") + 10);
                    }
                    else if (strpos($stat['name'], 'assets/') !== false) {
                        $filename = 'assets/'.substr($stat['name'] , strpos($stat['name'], "assets/") + 7);
                    }
                    else if (strpos($stat['name'], 'locales/') !== false) {
                        $filename = 'locales/'.substr($stat['name'] , strpos($stat['name'], "locales/") + 8);
                    }
                    else if (strpos($stat['name'], 'config/') !== false) {
                        $filename = 'config/'.substr($stat['name'] , strpos($stat['name'], "config/") + 7);
                    }

                    $allThemeFiles[] = $filename;
                    if (($filename == 'layout/theme.liquid')
                    || ($filename == 'sections/product-template.liquid')
                    || ($filename == 'snippets/cart-page.liquid')
                    || ($filename == 'snippets/product-template.liquid')
                    || ($filename == 'templates/cart.ajax.liquid')
                    || ($filename == 'templates/product.liquid')
                    ) {
                        // save file content from selected files
                        $fileContent[$filename] = file_get_contents('storage/temp/'.$stat['name']);
                    } else {
                        $fileContent[$filename] = '';
                    }
                }
            }

            $fileContent = mb_convert_encoding($fileContent, 'UTF-8');
            $encodedFileContent = json_encode($fileContent, JSON_UNESCAPED_SLASHES);

            $encodedThemeFiles = json_encode($allThemeFiles,JSON_UNESCAPED_SLASHES);
            $themeFiles = new Themefile;
            $themeFiles->theme_id = $themes->id;
            $themeFiles->file_names = $encodedThemeFiles;
            $themeFiles->save();

            $themeFileContent = new ThemefileContent;
            $themeFileContent->themefile_id = $themeFiles->id;
            $themeFileContent->themefile_content = $encodedFileContent ;
            $themeFileContent->save();

            $deletePath = public_path('storage/temp/');
            // delete temp files
            if (File::exists($deletePath)) {
                File::deleteDirectory($deletePath);
            }

            logger('theme files successfully saved');
        }
        catch (\Exception $e) {
            logger('error saving themefiles'.$e->getMessage());
        }

        return redirect()->route('themes');
    }

    public function freeaddon(Request $request){
      if($request->get('status') == 1)
      {
        $status = 0;
      }
      else{
        $status = 1;
      }
      $free_addons = FreeAddon::where('shopify_domain',$request->get('shopify_domain'))->where('email',$request->get('email'))->count();
        if($free_addons==0){
                $freeaddon = new FreeAddon;
                $freeaddon->email = $request->get('email');
                $freeaddon->shopify_domain =$request->get('shopify_domain');
                $freeaddon->status = $status;
                $freeaddon->save();
        }else{
                $freeaddon = FreeAddon::where('shopify_domain',$request->get('shopify_domain'))->where('email',$request->get('email'))->first();
                $freeaddon->status = $status;
                $freeaddon->save();
        }
      //$request->session()->flash('error', 'Invalide coupon code');
      return redirect()->route('dashboard');
    }
    /*--- For referrel --*/
    // public function referral()
    // {
    //   return 'http://example.test/?ref=' . \Hashids::encode(auth()->user()->id);
    // }
    // public function referrer()
    // {
    //     return auth()->user()->referrer;
    // }

    // public function referrals()
    // {
    //     return auth()->user()->referrals;
    // }
    public function deleteproduct(Request $request,$id)
    {
      $product = WinningProduct::find($id);
      if($product){
        $product->delete();
      }
      $request->session()->flash('status', 'Product has been deleted successfully');
      return redirect()->route('products');
    }

    public function addtrialdays(Request $request){

      $shop = User::where('name', $request->get('shopify_domain'))->first();
      setTrialDays($shop, $request->get('trial_days'));
      if($shop && $shop->is_beta_tester == true){
          if($request->get('trial_days') == 0 || $request->get('trial_days') == null){
            remove_from_beta_user($shop->id, $shop->email, $request->get('shopify_domain'), 0);
          }
      }

      try {
        $activeCampaign = new ActiveCampaignJobV3();

        if ($shop->trial_days > 0) {
          $subscription = 'Trial';
        } else if ($shop->alladdons_plan == null || $shop->alladdons_plan == '' || $shop->alladdons_plan == 'Freemium') {
          $subscription = 'Freemium';
        } else {
          $subscription = $shop->alladdons_plan;
        }

        $activeCampaign->sync([
          'email' => $shop->email,
          'fieldValues' => [
            ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $subscription],
          ]
        ]);
      } catch (\Exception $e) {
        logger($e->getMessage());
      }

      return redirect()->route('users');
    }

    public function refreshScriptTags(Request $request) {

      try {

        $shop = User::where('name', $request->get('shopify_domain'))->firstorFail();
        addScriptTagCurl($shop);
      }
      catch (\Exception $e) {
        logger($e->getMessage());
      }

      return redirect()->route('users');
    }

    //updates work start here
     public function addupdate(){
      $roles = json_decode(Auth::user()->user_role,1);
        if(!isset($roles) || empty($roles) || !in_array('updates', $roles)){
          echo "You don't have permission to view.";die;
        }
        return view('admin.addupdate');
    }

    public function updates(){
      $roles = json_decode(Auth::user()->user_role,1);
        if(!isset($roles) || empty($roles) || !in_array('updates', $roles)){
          echo "You don't have permission to view.";die;
        }
      $updates = updates::orderBy('id', 'desc')->get();
      return view('admin.updates', [
        'updates' => $updates
      ]);
    }

  public function newupdate(Request $request){
    $roles = json_decode(Auth::user()->user_role,1);
        if(!isset($roles) || empty($roles) || !in_array('updates', $roles)){
          echo "You don't have permission to view.";die;
        }

    $validator = Validator::make($request->all(), [
      'description' => 'required',
      'show_until' => 'nullable',
      'modal_title' => 'nullable'
    ]);

    if ($validator->fails()){
        return redirect(route('addupdate'))
                      ->withErrors($validator)
                      ->withInput();
    }

        $update = new Updates;
        $update->modal_title = $request->modal_title;
        $update->description = $request->description;
        $update->image = $request->image_path;
        $update->video = $request->video_link;
        $update->footer_button_text = $request->footer_button_text;
        $update->footer_button_link = $request->footer_button_link;
        $update->show_until = $request->show_until;
        $update->save();
        $append = [
            date("F j, Y",strtotime(now())),
            $request->image_path=='' ? "No Image Provided" : $request->image_path,
            $request->video_link=='' ? "No Video Link Provided" : $request->video_link,
            $request->description
        ];


        Sheets::spreadsheet(\Config::get('google.SPREADSHEET_ID'))
              ->sheet('Sheet1')
              ->append([$append]);
       return redirect()->route('updates');
    }

     public function showupdate(Request $request,$id){
      $roles = json_decode(Auth::user()->user_role,1);
        if(!isset($roles) || empty($roles) || !in_array('updates', $roles)){
          echo "You don't have permission to view.";die;
        }
      $update = Updates::where('id',$id)->first();
      return view('admin.editupdate', ['update' => $update ]);
    }

    public function editupdate(Request $request,$id){
      $validator = Validator::make($request->all(), [
        'description' => 'required',
        'show_until' => 'nullable',
        'modal_title' => 'nullable'
      ]);

      if ($validator->fails()) {
        return redirect(route('show_update', $id) )
                    ->withErrors($validator)
                    ->withInput();
      }

      $update = Updates::find($id);
      if($update){
        $update->modal_title = $request->get('modal_title');
        $update->video = $request->get('video_link');
        $update->description = $request->get('description');
        $update->image = $request->get('last_used');
        $update->footer_button_text = $request->get('footer_button_text');
        $update->footer_button_link = $request->get('footer_button_link');
        $update->show_until = $request->get('show_until');
        $update->save();
      }
         return redirect()->route('updates');
    }

    public function deleteupdate(Request $request,$id){
      $roles = json_decode(Auth::user()->user_role,1);
        if(!isset($roles) || empty($roles) || !in_array('updates', $roles)){
          echo "You don't have permission to view.";die;
        }
      $update = Updates::find($id);
      if($update){
          $path_to_delete = str_replace(config('app.url') . '/', "", $update->image);
          if (File::exists($path_to_delete)) {
              unlink($path_to_delete);
          }
        $update->delete();
      }
      $request->session()->flash('status', 'Update deleted successfully');
      return redirect()->route('updates');
    }


    public function uploadimage(Request $request){
      if ($request->has('image_file')) {
        $path_to_delete = str_replace(config('app.url') . '/', "", $request->get('last_used'));
        if (File::exists($path_to_delete)) {
            unlink($path_to_delete);
        }
        $file = $request->file('image_file');
        $file = is_array($file) ? $file[0] : $file;
        $filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('updates', $filename, 'public');
        $url = config('app.url') . '/storage/' . $path;
        return response()->json(['success' => true, 'url' => $url]);
      }
      return response()->json(['success' => false, 'url' => ""]);
    }

    public function search_updates(Request $request){
      $updates = Updates::where(function ($query) use($request) {
        if($request->query('query') != ''){
          $query->where('description', 'like', '%' . $request->query('query') . '%')
               ->orWhere('video', 'like', '%'.$request->query('query').'%')
               ->orWhere('image', 'like', '%'.$request->query('query').'%');
        }
      })->orderBy('id', 'desc')
      ->paginate(50);
      $html = View::make('admin.updates_table',['updates' => $updates]);
      $response = $html->render();
      return response()->json([
          'status' => 'success',
          'html' => $response
      ]);
    }

    // search theme
public function search_themes(Request $request){

            $themes = Themes::where(function ($query) use($request) {
              // echo $request->query('query');
                if($request->query('query') != ''){
                  $query->where('version', 'LIKE', '%'. trim($request->query('query') .'%'))
                       ->orWhere('url', 'like', '%'.$request->query('query').'%');
                }
              })->orderBy('id', 'desc')
              ->paginate(50);
              $data['html'] = view('admin.theme_table', compact('themes'))->render();

                echo json_encode($data);
                die;

  }

  //save beta tester
  public function save_beta_tester_users(Request $request){
    $all_emails = $request->all();
    $emails = explode(',', $all_emails['beta_email']);
    $email_not_exists = [];
    foreach ($emails as $key => $email) {
      $exists_emails = User::where('email',trim($email))->get();
      if(!empty($exists_emails) && count($exists_emails) !=0 ){
        foreach ($exists_emails as $key => $exists_email) {

          $this->pause_beta_user_subscription($exists_email->id, $exists_email->email, $exists_email->name);

          User::where('email', $exists_email->email)->update(['is_beta_tester' => 1]);
        }
           Session::flash('email_exists', 1);
      }else{
        $email_not_exists[] = trim($email);
      }
    }

    if(!empty($email_not_exists) && count($email_not_exists) > 0){
          $not_exists = implode(',', $email_not_exists);
          Session::flash('email_not_exists', $not_exists);
    }

    return redirect()->route('users');
  }

  public function pause_beta_user_subscription($user_id, $user_email, $user_domain){
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    $trial_days = 60;
    $current_date = new DateTime();
    $formatted_current_date = $current_date->format('Y-m-d');
    $trial_ends_at = date('Y-m-d', strtotime($formatted_current_date.' + '.$trial_days.' days'));

    $shop = User::where('name', $user_domain)->first();
    $user_plan = User::where('id', trim($user_id))->select('alladdons_plan')->get();
    $old_meta =  json_encode(['plan_name'=> $user_plan[0]->alladdons_plan]);
    setTrialDays($shop, $trial_days);
    $update_user = User::where('email', trim($user_email))->where('name', trim($user_domain))->update([
      'is_beta_tester' => 1,
      'trial_ends_at' => $trial_ends_at,
      'sub_trial_ends_at' => 1,
      'alladdons_plan' => '',
      'trial_days' => $trial_days,
      'old_plan_meta' => $old_meta,
    ]);

    $subscription = SubscriptionStripe::where('user_id',$user_id)->orderBy('id', 'desc')->first();
    if (isset($subscription->stripe_id) && !empty($subscription->stripe_id)) {
      $stripe_subs = \Stripe\Subscription::retrieve($subscription->stripe_id);

      if (isset($stripe_subs->id) && !empty($stripe_subs->id) && $stripe_subs->status != 'canceled') {
        $sub = \Stripe\Subscription::update($subscription->stripe_id, [
          'pause_collection' => [
            'behavior' => 'mark_uncollectible',
          ],
        ]);
      }
    }

    $paypal_subscription = SubscriptionPaypal::where('user_id', $user_id)->orderBy('id', 'desc')->first();
    if (isset($paypal_subscription->paypal_id) && !empty($paypal_subscription->paypal_id)) {
      $subId = $paypal_subscription->paypal_id;
      $paypal_subs = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}"))->json();

      if (isset($paypal_subs['id']) && !empty($paypal_subs['id']) && $paypal_subs['status'] != 'CANCELLED') {
        $pauseSubscriptionResponse = getPaypalHttpClient()
          ->withBody('{"reason":"Customer Requested Pausing Current Subscription"}', 'application/json')
          ->post(getPaypalUrl("v1/billing/subscriptions/${subId}/suspend"))->status();

        if ($pauseSubscriptionResponse == 204) {
          $getPaypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}"))->json();
          SubscriptionPaypal::where('paypal_id', $subId)->update([
            'paypal_status' => $getPaypalSubscription['status']
          ]);
        }
      }
    }
  }

  //save beta tester
  public function save_beta_tester_user(Request $request){
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    if ($request->get('user_email')) {
      $message = "";
      if($request->get('save_beta_tester_user') == 1){
            $this->pause_beta_user_subscription($request->get('user_id'), $request->get('user_email'), $request->get('data_domain'));
          $message = "Beta tester user is added!";
          $shop = User::where('id', $request->get('user_id'))->first();
            addScriptTagCurl($shop);

      }else{

          $trial_days = 0;
            remove_from_beta_user($request->get('user_id'),$request->get('user_email'),$request->get('data_domain'), $trial_days);
          $message = "Beta tester user is removed!";
      }
      return response()->json([
          'status' => 'success',
          'message' => $message
      ]);
    }
  }


  //get veta user
  function get_all_beta_users(Request $request){

    $users = $request->get('beta_tester_user');


    if($request->get('show_all_beta_tester')){

      $shops = User::where(function ($query) use ($request){
                if($request->get('beta_tester_user') == 1){
                    $query->where('is_beta_tester', $request->get('beta_tester_user'));
                }
              })->orderBy('id', 'desc')
          ->paginate(100);

        $html = View::make('admin.searched_users',['shops' => $shops]);

        $response = $html->render();
        return response()->json([
            'status' => 'success',
            'html' => $response
        ]);

    }


  }

  // save beta theme
  public function save_beta_theme(Request $request){
    if ($request->get('save_beta_theme')) {
        $message = "";
        if($request->get('is_beta_theme') == 1){
            $themeUpdate = Themes::where('id', trim($request->get('id')))->update(['is_beta_theme' => 1]);
            $message = "Beta theme is added!";
            $this->update_store_theme($themeUpdate, $request, 1);
        }else{
            $themeUpdate = Themes::where('id', trim($request->get('id')))->update(['is_beta_theme' => 0]);
            $message = "Beta theme is removed!";
            $this->update_store_theme($themeUpdate, $request, 0);

        }
        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }
  }

    //webinar
  public function webinar(Request $request) {
    $roles = json_decode(Auth::user()->user_role,1);
      if(!isset($roles) || empty($roles) || !in_array('webinar', $roles)){
        echo "You don't have permission to webinar.";
        die;
      }

      $keyword = '';
      if ($request->isMethod('get') && $request->input('q') != '') {
        $keyword = $request->input('q');
        $webinar = Webinar::where(function ($query) use ($request, $keyword){
                if($request->query('query') != ''){
                        $query->where('title', 'like', '%'.$keyword.'%');
                }
            })->orderBy('id', 'desc')
        ->paginate(50);
      }else{
        $webinar = Webinar::orderBy('id', 'desc')->paginate(50);
      }
      return view('admin.admin_webinar', ['webinars' => $webinar, 'keyword' => $keyword]);
  }

    public function searchWebinar(Request $request)
    {
        $webinar = Webinar::where(function ($query) use ($request)
            {
                if($request->query('query') != ''){
                    $query->where('title', 'like', '%'.$request->query('query').'%');
                }
            })->orderBy('id', 'desc')->paginate(50);

        $html = View::make('admin.webinars.searched',['webinars' => $webinar]);

        $response = $html->render();
        return response()->json([
            'status' => 'success',
            'html' => $response
        ]);
    }

  function update_store_theme($themeUpdate, $request, $is_beta_or_not){
            $term = $request->all();
            if($themeUpdate){
                $theme_version = $request->get('theme_version');
                 if (isset($term['theme_version']) && !empty($term['theme_version'])) {
                      $StoreThemes = StoreThemes::where('store_themes.version', $term['theme_version'])->update(['is_beta_theme' => $is_beta_or_not]);

                  }
            }

  }



} /*---end of controller----*/
