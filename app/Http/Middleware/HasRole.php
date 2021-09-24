<?php

namespace App\Http\Middleware;

use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user() && in_array($role, json_decode($request->user()->user_role, true)))
        {
            return $next($request);
        }
        if ($request->wantsJson()) {
            return response()->json([
                'message' => "You don't have permission to webinar."
            ], 403);
        }

        abort(403, "You don't have permission to webinar.");
    }
}
