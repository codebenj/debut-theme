<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class ShopLoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $prev = $request->session()->get('_previous');

        $prev_url = ( @$prev['url'] ) ? $prev['url'] : null;

        if(@$prev_url && strpos($prev_url, '/app/') !== false){
            Session::put('return_to', $prev_url);
            $redirect_access = 1;
        }else{
            Session::put('return_to', null);
            $redirect_access = 0;
        }
//    	$redirect_access = 1;
//		if (!isset($_SERVER['HTTP_REFERER'])) {
//			$redirect_access = 0;
//		}
        return view('auth.index', ['redirect_access' => $redirect_access]);
    }
}
