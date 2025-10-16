<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user()->load('client');
        return view('client.profile', compact('user'));
    }

    public function store(Request $request)
    {
        try {

            $user = Auth::user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'number' => 'required|string|regex:/^[0-9\s\-\+\(\)]*$/',
                'hall_of_residence' => 'nullable|string|max:255',
                'faculty' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'matric_no' => 'nullable|string|max:255',
                'room_number' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'number' => $validated['number']
            ]);

            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            $user->client()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'hall_of_residence' => $validated['hall_of_residence'] ?? null,
                    'faculty' => $validated['faculty'] ?? null,
                    'department' => $validated['department'] ?? null,
                    'matric_no' => $validated['matric_no'] ?? null,
                    'room_number' => $validated['room_number'] ?? null,
                    'avatar' => $avatarPath ?? $user->client->avatar ?? null,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile updated'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
