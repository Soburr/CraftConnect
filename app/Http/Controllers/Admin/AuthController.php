<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['password', Password::defaults()]
        ]);

        if(Auth::guard('admin')->attempt($credentials, $request->remember)) {
           $request->session()->regenerate();
           return redirect()->route('admin.admin.dashboard')->with('success', 'Welcome back, Super Admin');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password'
        ]);
    }
}
