<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
    
        foreach ($guards as $guard) {           
            if ($guard == "secretary" && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::SECRETARY_DASHBOARD);
            }
            if ($guard=="officer" && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::OFFICER_DASHBOARD);
            }
            if ($guard=="admin" && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
            }
            if ($guard=="member" && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::MEMBER_DASHBOARD);
            }
            if ($guard=="treasurer" && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::TREASURER_DASHBOARD);
            }
            if ($guard=="chairman" && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::CHAIRMAN_DASHBOARD);
            }
        }

        return $next($request);
    }
}
