<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
      * @return mixed
     */
    // est une fun  important
    public function handle($request,Closure $next){
        if (Auth::guard('web')->check()) {
            return redirect(RouteServiceProvider::HOME);
        }
        if (Auth::guard('admin')->check()) {
            return redirect(RouteServiceProvider::ADMIN);
        }
        return $next($request);
    }
}
