<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function change()
    {
       return view('artisan.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('status', 'Password changed successfully');
    }


}
