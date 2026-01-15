<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->hasCompletedProfile()) {
            if (!$request->routeIs('client.profile') && !$request->routeIs('artisan.profile')) {
                session()->flash('profile_incomplete', 'Please complete your profile to access all features.');
            }
        }

        return $next($request);
    }
}