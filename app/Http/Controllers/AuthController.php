<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\Artisan;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegistrationRequest $request)
    {
        //  $request->validated();

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

         auth()->login($user);

         if($user->role === 'client') {
            return redirect()->route('client.dashboard')->with('success', 'welcome to your dashboard');
         }

         if($user->role === 'artisan') {
            return redirect()->route('artisan.dashboard')->with('success', 'welcome to your dashboard');
         }

         return redirect()->route('login')->with('error', 'Something went wrong, try again.');
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

        if($expectedRole && $user->role !== $expectedRole) {
           Auth::logout();
           return back()->withErrors([
               'email' => 'You tried to login as a ' . $expectedRole . ', but this account is registered as an ' . $user->role . '-'
           ]);
        }

        return $user->role === 'client' ? redirect()->route('client.dashboard') : redirect()->route('artisan.dashboard');
       }

       return back()->withErrors([
        'email' => 'The provided credentials do not match our records'
       ])->onlyInput('email');
    }

    public function logout()
    {

    }

}
