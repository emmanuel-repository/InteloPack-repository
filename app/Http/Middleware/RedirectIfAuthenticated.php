<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        switch ($guard) {
        case 'empleado':
            if (Auth::guard($guard)->check()) {
                return redirect()->route('bienvenida.index');
            }
            break;
        default:
            if (Auth::guard($guard)->check()) {
                return redirect('/');
            }
            break;
        }
        return $next($request);
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }
        // return $next($request);
    }
}
