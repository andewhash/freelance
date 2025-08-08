<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class EnsureVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (!Auth::user()->email_verified_at || !Auth::user()->phone_verified_at)) {
            return redirect()->route('verification');
        }
    
        return $next($request);
    }
}
