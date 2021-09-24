<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $shop;

    public function __contstruct()
    {
        $this->shop = auth()->user();
    }

    public function index()
    {
        $shop = Auth::user();

        if ( ! $shop ) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthenticated')
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => $shop
        ], 200);
    }
}
