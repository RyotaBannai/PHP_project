<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        /**
         * Determine if the current request probably expects a JSON response.
         *
         * @return bool
         */
        if (! $request->expectsJson()) {
            return route('login');
        }
        //return abort(404);
    }
}
