<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next)
    {
        // Skip the check for admins or users without client/artisan role
        if (auth()->check() && in_array(auth()->user()->role, ['client', 'artisan'])) {
            if (!auth()->user()->hasCompletedProfile()) {
                // Don't show the message on profile routes
                if (!$request->routeIs('client.profile') && !$request->routeIs('artisan.profile')) {
                    session()->flash('profile_incomplete', 'Please complete your profile to access all features.');
                }
            }
        }

        return $next($request);
    }
}