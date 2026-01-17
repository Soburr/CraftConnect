<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Mail\VerificationEmail;
use App\Models\Artisan;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegistrationRequest $request)
    {
        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        if($request->role === 'client') {
            $user->client()->create([
                'user_id' =>  $user->id,
                'hall_of_residence' => $request->hall_of_residence
            ]);
        }

        if($request->role == 'artisan') {
            $user->artisan()->create([
                'user_id' =>  $user->id,
                'hall_of_residence' => $request->hall_of_residence,
                'skill' => $request->skill,
                'years_of_experience' => $request->years_of_experience,
                'portfolio_url' => $request->portfolio_url
            ]);
        }

        // Generate verification token (plain text for email)
        $plainToken = Str::random(60);
        $user->verification_token = hash('sha256', $plainToken);
        $user->verification_token_expires = now()->addHours(24);
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($user, $plainToken));

        // Store email in session for verification page
        session(['verification_email' => $user->email]);

        // Redirect to verification notice instead of logging in
        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function showLoginForm(Request $request)
    {
        $role = $request->query('role');
        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        $expectedRole = $request->input('role');

        if(Auth::Attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                session(['verification_email' => $request->email]);
                return redirect()->route('verification.notice')
                    ->with('error', 'Please verify your email before logging in.');
            }

            if($expectedRole && $user->role !== $expectedRole) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You tried to login as a ' . $expectedRole . ', but this account is registered as an ' . $user->role . '.'
                ]);
            }

            return $user->role === 'client' ? redirect()->route('client.dashboard') : redirect()->route('artisan.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ])->onlyInput('email');
    }
}
