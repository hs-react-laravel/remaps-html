<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckCompany
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('admin')->check() || Auth::guard('master')->check()) {
            return $next($request);
        } else {
            return redirect('/admin/login');
        }
    }
}
