<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // dd($guard); // login 時に null なのでdefaultの web
        // $guard = 'api'; // tokenがないとエラー
        // $guard = $guard ?: $this->getDefaultDriver(); -> web

        if (Auth::guard($guard)->check()) {

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
