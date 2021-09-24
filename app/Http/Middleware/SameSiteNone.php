<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class SameSiteNone
{
    /**
     * Sets SameSite=None while checking for incompatible browsers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // parse the User Agent
        $agent = new Agent;
        $browser = $agent->browser();
        $browserVersion = $agent->version($browser, Agent::VERSION_TYPE_FLOAT);

        // check for incompatible browsers based on https://www.chromium.org/updates/same-site/incompatible-clients
        $browserIsCompatible = true;
        if ($browser == 'Safari' && $agent->match('Mac OS X 10_14_*|iP.+; CPU .*OS 12_')) {
            $browserIsCompatible = false;
        } elseif ($browser == 'Chrome' && $browserVersion > 50 && $browserVersion < 67) {
            $browserIsCompatible = false;
        } elseif ($browser == 'UCBrowser' && $browserVersion < 12.13) {
            $browserIsCompatible = false;
        }

        // set SameSite none to supported browsers only
        if ($browserIsCompatible) {
            config(['session.secure' => true]);
            config(['session.same_site' => 'none']);
        } else {
            config(['session.secure' => false]);
            config(['session.same_site' => null]);
        }

        return $next($request);
    }
}