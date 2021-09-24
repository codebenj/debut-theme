<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\StripePlan;

class StripePlanController extends Controller
{
    public function index()
    {
            $plans = StripePlan::all();
            return view('plans.index', compact('plans'));
    }
    public function show(StripePlan $plan, Request $request)
    {
        return view('plans.show', compact('plan'));
    }
}




















?>
