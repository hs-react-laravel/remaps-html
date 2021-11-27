<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckOnlyStaff
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('staff')->check()) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
