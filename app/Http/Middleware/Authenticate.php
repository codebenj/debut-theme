<?php



namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;



use Illuminate\Auth\Middleware\Authenticate as Middleware;



class Authenticate extends Middleware

{

    /**

     * Get the path the user should be redirected to when they are not authenticated.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return string

     */

    protected function redirectTo($request)

    {
        $current_route = Route::currentRouteName();
        if($current_route == "plans"){

            $this->redirectTo = 'login';
            return $this->redirectTo;


        }

        if (! $request->expectsJson()) {

            return route('login');

        }

    }

}

