<?php

namespace App\Http\Controllers\Admin;

use App\Webinar;
use App\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WebinarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        if ($request->isMethod('get') && $request->input('q') != '')
        {
            $webinar = Webinar::where(function ($query) use ($request, $keyword)
            {
                if ($request->query('query') != '')
                {
                    $query->where('title', 'like', '%' . $keyword . '%');
                }
            })->orderBy('id', 'desc')
            ->paginate(50);
        }
        else
        {
            $webinar = Webinar::orderBy('id', 'desc')->paginate(50);
        }
        return view('admin.webinars.index', ['webinars' => $webinar, 'keyword' => $keyword]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admins = AdminUser::get();
        return view('admin.webinars.create', ['admins' => $admins]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'presenter' => ['required', 'exists:admin_users,id'],
            'duration' => ['string','nullable'],
            'release_date' => ['date', 'nullable'],
            'webinar_link' => ['string', 'nullable', 'url'],
        ]);

        if ($validator->fails())
        {
            if ($request->wantsJson())
            {
                return response()->json(["errors" => $validator->errors()], 422);
            }
            else
            {
                return back()->withErrors($validator->errors());
            }
        }

        $webinar = Webinar::create($request->only('title', 'presenter', 'duration', 'release_date', 'webinar_link'));

        if ($request->has('image'))
        {
            $img_name = 'webinar_' . time() . '.' . $request->get('image_ext');
            $img_content = file_get_contents($request->get('image'));
            Storage::put('public/webinar/' . $img_name, $img_content);
            $img_url = config('env-variables.APP_URL') . '/storage/webinar/' . $img_name;
            $webinar->image = $img_url;
            $webinar->save();
        }

        $request->session()->flash('status', 'Webinar has been created successfully');

        return response()->json([
            'status' => 'ok',
            'redirect' => route('admin.webinars.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Webinar $webinar)
    {
        $admins = AdminUser::get();

        return view('admin.webinars.edit', ['webinar' => $webinar, 'admins' => $admins]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'presenter' => ['required', 'exists:admin_users,id'],
            'duration' => ['string', 'nullable'],
            'release_date' => ['date', 'nullable'],
            'webinar_link' => ['string', 'nullable', 'url'],
        ]);

        if ($validator->fails())
        {
            if ($request->wantsJson())
            {
                return response()->json(["errors" => $validator->errors()], 422);
            }
            else
            {
                return back()->withErrors($validator->errors())->withInput();
            }
        }

        $webinar = Webinar::findOrFail($id);;

        if ($request->has('image'))
        {
            if ($request->get('image') != $webinar->image)
            {
                $img_name = 'webinar_' . time() . '.' . $request->get('image_ext');
                $img_content = file_get_contents($request->get('image'));
                Storage::put('public/webinar/' . $img_name, $img_content);
                $img_url = config('env-variables.APP_URL') . '/storage/webinar/' . $img_name;
                $image = $img_url;
            }
            else
            {
                $image = $request->get('image');
            }
        }
        else
        {
            $image = null;
        }

        $data = array_merge($request->only('title', 'presenter', 'duration', 'release_date', 'webinar_link'), [
            'image' => $image
        ]);

        $webinar->update($data);

        $request->session()->flash('status', 'Webinar has been updated successfully');
        return response()->json([
            'status' => 'ok',
            'redirect' => route('admin.webinars.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Webinar $webinar, Request $request)
    {

        $webinar->delete();

        $request->session()->flash('status', 'Webinar deleted successfully');
        return redirect()->route('admin.webinars.index');
    }
}
