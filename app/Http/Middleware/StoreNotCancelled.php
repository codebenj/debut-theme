<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Cache;

class StoreNotCancelled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $store = $request->user();

        $shopify_info = json_decode($store->shopify_raw, 1);

        if (isset($shopify_info['plan_name']) && $shopify_info['plan_name'] === User::PLAN_CANCELLED)
        {
            $request->session()->invalidate();

            return redirect(route('login'));
        }

        return $next($request);
    }
}
