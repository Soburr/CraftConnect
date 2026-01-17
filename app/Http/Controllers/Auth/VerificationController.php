<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice
     */
    public function notice()
    {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect()->route(Auth::user()->role === 'client' ? 'client.dashboard' : 'artisan.dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle email verification
     */
    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('verification.notice')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('success', 'Email already verified. Please login.');
        }

        if (!$user->hasValidVerificationToken($request->token)) {
            return redirect()->route('verification.notice')
                ->with('error', 'Invalid or expired verification link. Please request a new one.');
        }

        $user->markEmailAsVerified();

        Auth::login($user);

        $redirectRoute = $user->role === 'client' ? 'client.dashboard' : 'artisan.dashboard';

        return redirect()->route($redirectRoute)
            ->with('success', 'Email verified successfully! Welcome to your dashboard.');
    }

    /**
     * Resend verification email
     */
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email is already verified.');
        }

        // Generate new token
        $plainToken = Str::random(60);
        $user->verification_token = hash('sha256', $plainToken);
        $user->verification_token_expires = now()->addHours(24);
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($user, $plainToken));

        return back()->with('success', 'Verification email has been resent. Please check your inbox.');
    }
}
