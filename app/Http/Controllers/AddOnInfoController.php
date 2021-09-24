<?php

namespace App\Http\Controllers;

use App\AddOnInfo;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;

class AddOnInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->exitIfNotAllowed();
        $addons = AddOnInfo::orderBy('name')->get();

        return view('admin.addons.index', ['addons' => $addons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $this->exitIfNotAllowed();
        return view('admin.addons.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->exitIfNotAllowed();

        if ($request->has('icon_file')) {
            $path = $request->file('icon_file')->store('public/uploads');
            $request->merge(['icon_path' => $path]);
        }

        AddOnInfo::create($request->only([
            'name',
            'addon_settings_title',
            'description',
            'wistia_video_id',
            'cost',
            'conversion_rate',
            'icon_path',
            'category',
        ]));

        return redirect()->route('addons.index')->with('status', 'Add-On created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AddOnInfo  $addon
     * @return mixed
     */
    public function show(AddOnInfo $addon)
    {
        $this->exitIfNotAllowed();
        return $addon;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AddOnInfo  $addon
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(AddOnInfo $addon)
    {
        $this->exitIfNotAllowed();
        return view('admin.addons.form', ['addon' => $addon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddOnInfo  $addon
     */
    public function update(Request $request, AddOnInfo $addon)
    {
        $this->exitIfNotAllowed();

        if ($request->has('icon_file')) {
            $path = $request->file('icon_file')->store('public/uploads');
            $request->merge(['icon_path' => $path]);
        }

        $addon->update($request->only([
            'name',
            'addon_settings_title',
            'description',
            'wistia_video_id',
            'cost',
            'conversion_rate',
            'icon_path',
            'category',
        ]));

        return redirect()->route('addons.index')->with('status', 'Add-On updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddOnInfo  $addon
     */
    public function destroy(AddOnInfo $addon)
    {
        $this->exitIfNotAllowed();
        $addon->delete();
        
        return redirect()->back()->with('status', 'Add-On deleted successfully');;
    }

    public function search(Request $request)
    {
        $this->exitIfNotAllowed();
        $addons = AddOnInfo::where('name', 'LIKE', '%'.$request->input('query').'%')
            ->orWhere('description', 'LIKE', '%'.$request->input('query').'%')
            ->orderBy('name')
            ->get();
        $html = View::make('admin.addons.table',['addons' => $addons]);
        $response = $html->render();

        return response()->json([
            'status' => 'success',
            'html' => $response
        ]);
    }
    
    public function exitIfNotAllowed()
    {
        $roles = json_decode(Auth::user()->user_role, 1);

        if (!isset($roles) || empty($roles) || !in_array('addons', $roles)) {
            echo "You don't have permission to access Add-Ons.";
            die;
        }
    }
}
