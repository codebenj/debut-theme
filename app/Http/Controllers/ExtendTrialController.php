<?php

namespace App\Http\Controllers;

use App\ExtendTrial;
use Illuminate\Http\Request;
use View;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\UserExtendTrialRequest;
use App\Jobs\ActiveCampaignJob;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;





class ExtendTrialController extends Controller
{
    public $activeCampaign;
    public function __construct() {
        $this->middleware('auth:admin');
        $nbShops = ((int) User::where('password', '!=', '')->count()) + 43847;
        $this->activeCampaign = new ActiveCampaignJobV3();
        // $this->updateStatus();
        View::share(['nbShops' => $nbShops]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        //
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
      {
        echo "You don't have permission to extend trial feature.";
        die;
      }
        return view('admin.extend_trial.create_extend_trial');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return [type]
     */
    public function store(Request $request)
    {
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
      {
        echo "You don't have permission to extend trial feature.";
        die;
      }
        $validator = Validator::make($request->all(), [
            'feature_name' => 'required|unique:extend_trials,name',
            'feature_description' => 'required',
            'extend_days' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)->withInput();
        }

        ExtendTrial::store_extend_feature($request);
        $request->session()->flash('status', 'Extend feature added successfully');
        return redirect()->route('extend_trial_show');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExtendTrial  $extendTrial
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
      {
        echo "You don't have permission to extend trial feature.";
        die;
      }
        $extend_features = ExtendTrial::orderby('id','desc')->get();
        return view('admin.extend_trial.show_extend_trial',['extend_features' => $extend_features]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtendTrial  $extendTrial
     * @return [type]
     */
    public function edit(Request $request, $id)
    {
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
      {
        echo "You don't have permission to extend trial feature.";
        die;
      }
        $validator = Validator::make($request->all(), [
            'feature_name' => 'required',
            'feature_description' => 'required',
            'extend_days' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)->withInput();
        }
        $extendtrial_feature = ExtendTrial::update_extend_feature($request, $id);
        $request->session()->flash('status', 'Extend feature update successfully');
        return redirect()->route('extend_trial_show');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExtendTrial  $extendTrial
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
        //
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
      {
        echo "You don't have permission to extend trial feature.";
        die;
      }
        $extendtrial_feature = ExtendTrial::getFeatureByID($id);
        return view('admin.extend_trial.update_extend_trial',['extendtrial_feature' => $extendtrial_feature]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtendTrial  $extendTrial
     * @return [type]
     */

    //  admin section delete feature
    public function deleteextendfeature(Request $request, $id) {
      $roles = json_decode(Auth::user()->user_role, 1);
      if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
      {
        echo "You don't have permission to extend trial feature.";
        die;
      }
        $extend_feature = ExtendTrial::find($id);
        if ($extend_feature) {
            $extend_feature->delete();
            $user_requests = UserExtendTrialRequest::where('extend_trials_id',$id)->delete();

        }
        $request->session()
            ->flash('status', 'Extend feature deleted successfully');
        return redirect()
            ->route('extend_trial_show');
    }


// ajax search feature admin
    public function ajax_search_feature(Request $request){

        $extend_features = ExtendTrial::where(function ($query) use($request) {
                if($request->query('query') != ''){
                  $query->where('name', 'like', '%' . $request->query('query') . '%')
                       ->orWhere('description', 'like', '%'.$request->query('query').'%');
                }
              })->orderBy('id', 'desc')
              ->paginate(50);

              $html = View::make('admin..extend_trial.extend_trial_table',['extend_features' => $extend_features]);
              $response = $html->render();
              return response()->json([
                  'status' => 'success',
                  'html' => $response
              ]);

    }

// show all request in admin
    public function user_extend_request(Request $request){
                    $roles = json_decode(Auth::user()->user_role, 1);
                    if (!isset($roles) || empty($roles) || !in_array('extend_trial_show', $roles))
                    {
                      echo "You don't have permission to extend trial feature.";
                      die;
                    }
                    $user_requests = UserExtendTrialRequest::where('extend_trial_status','pending')->orderby('id','desc')->get();
                    $user_request_request = [];
                    foreach ($user_requests as $key => $user_request) {
                            $shops = User::where('id', $user_request->user_id)->first();
                            if(!empty($shops) && ($shops->alladdons_plan == 'Freemium' || $shops->alladdons_plan == "")){
                                // if($shops->alladdons_plan == 'Freemium' || $shops->alladdons_plan == ""){
                                $feature_description = "";
                                $feature_name = "";
                                $trial_day = "";
                                $request_feature = ExtendTrial::where('id', $user_request->extend_trials_id)->first();

                                if(isset($request_feature) && !empty($request_feature)) {
                                    $feature_name = $request_feature->name;
                                    $feature_description = $request_feature->description;
                                    $trial_day = $request_feature->extend_trial_days    ;
                                  }
                                  $user_request['name'] = $feature_name;
                                  $user_request['description'] = $feature_description;
                                  $user_request['extend_trial_days'] = $trial_day;
                                  $user_request['user_name'] = $shops->name;
                                  $user_request_request[] = $user_request;
                                // }
                            }else{
                                UserExtendTrialRequest::where('user_id',$user_request->user_id)->delete();
                            }

                    }
                    $total_request_pending = count($user_request_request);
                    return view('admin.extend_trial.user_request_status',['user_requests' => $user_request_request, 'extend_request_pending' => $total_request_pending]);
    }


// save user request status approve and refuse
     public function user_request_approve_refuse(Request $request){

                        $data = $request->all();
                    if ($request->has('request_status') && $request->has('request_status')){
                            $feature_title = ExtendTrial::where('id', $data['feature_id'])->select('name','extend_trial_days','description')->first();
                            $shop = User::where('id', $data['user_id'])->first();
                            $api_action = 'contact_tag_add';

                        if($request->get('request_status') && $request->get('request_status') == 'approve_btn'){ 
                            if(!empty($shop)){
                                $user_requests = UserExtendTrialRequest::where('user_id', $data['user_id'])->where('extend_trials_id', $data['feature_id'])->update(['extend_trial_status' => 'approved']);
                                $increase_day = $shop->trial_days + $feature_title->extend_trial_days;
                                setTrialDays($shop, $increase_day);
                                    $campian_event = "Event - Trial Extended ".$feature_title->name;

                                $tag_id = $this->activeCampaign->create_tag($campian_event , $feature_title->description);
                                $this->add_activecampaigntag($tag_id, $shop);
                                
                                try {
                                  if ($shop->trial_days > 0) {
                                    $subscription = 'Trial';
                                  } else if ($shop->alladdons_plan == null || $shop->alladdons_plan == '' || $shop->alladdons_plan == 'Freemium') {
                                    $subscription = 'Freemium';
                                  } else {
                                    $subscription = $shop->alladdons_plan;
                                  }
                            
                                  $this->activeCampaign->sync([
                                    'email' => $shop->email,
                                    'fieldValues' => [
                                      ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $subscription],
                                    ]
                                  ]);
                                } catch (\Exception $e) {
                                  logger($e->getMessage());
                                }
                            }

                            $request->session()->flash('status', 'User Request Approved successfully!');
                        }elseif($request->get('request_status') && $request->get('request_status') == 'refuse_btn'){  
                            // $user_requests = UserExtendTrialRequest::where('user_id', $data['user_id'])->where('extend_trials_id', $data['feature_id'])->delete();
                            $user_requests = UserExtendTrialRequest::where('user_id', $data['user_id'])->where('extend_trials_id', $data['feature_id'])->update(["extend_trial_status" => 'rejected']);

                                    $campian_event = "Event - Trial Extension Rejected ".$feature_title->name;
                                if(!empty($shop)){ 
                                    $tag_id = $this->activeCampaign->create_tag($campian_event , $feature_title->description);
                                    $this->add_activecampaigntag($tag_id, $shop);
                                }
                            $request->session()->flash('status', 'User Request Refused successfully!');
                        }
                    }
                    return response()->json([
                              'status' => 'success',
                          ]);
    }

    public function add_activecampaigntag($tag_id, $shop){
                      if($tag_id != 0){
                                    try {
                                    $contact = $this->activeCampaign->sync([
                                      'email' => $shop->email,
                                      'fieldValues' => [
                                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => 'Extend Trial']
                                      ]
                                    ]);
                                    $tag = $this->activeCampaign->tag($contact['id'],$tag_id);
                                    } catch(\Exception $e) {
                                        $e->getMessage();
                                    }
                                }
    }


}
