<?php

namespace App\Http\Controllers;

use App\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CmsController extends Controller
{

    public function __construct() {

        $this->middleware(function ($request, $next) { 
            $roles = json_decode(Auth::user()->user_role,1);
            if(!isset($roles) || empty($roles) || !in_array('cms', $roles)){
                echo "You don't have permission to CMS dashboard.";die;
            }
            return $next($request);
        });
        $this->middleware('auth:admin', ['except' => ['show_cms_dashboard']]);
        
        // $nbShops = ((int) User::where('password', '!=', '')->count()) + 43847;
        // View::share(['nbShops' => $nbShops]);

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
        $data = [];
        $cms = Cms::updateOrCreate(['title'=>$request->data_title ],
            ['content' => $request->data_content]
        );
            if($cms){
                $data['success'] = 'ok';
            }
            return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $cms
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Cms $cms)
    {
        //
        $roles = json_decode(Auth::user()->user_role, 1);
        if (!isset($roles) || empty($roles) || !in_array('cms', $roles)) {
            echo "You don't have permission to CMS Dashboard.";
            die;
        }
        $csm_dashboard = Cms::get()->toArray();
        $new_array = [];
            if(!empty($csm_dashboard)){
            foreach ($csm_dashboard as $key => $cms_data) {
                $new_array[$cms_data['title']] = $cms_data;
            }
        }
        return view('admin.cms.csm_dashboard',['cms_data' => $new_array]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function edit(Cms $cms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cms $cms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cms $cms)
    {
        //
    }
}
