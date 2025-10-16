<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill;
use App\Models\Category;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user()->load('artisan');

        $categories = Category::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();

        return view('artisan.profile', compact('user', 'categories', 'skills'));
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
            'bio' => 'nullable|string|max:500',
            'years_of_experience' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'skill_id' => 'nullable',
            'custom_skill' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'number' => $validated['number'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $skillId = null;

        if ($validated['skill_id'] === 'others' && !empty($validated['custom_skill'])) {
            $existingSkill = Skill::whereRaw('LOWER(name) = ?', [strtolower($validated['custom_skill'])])
                ->where('category_id', $validated['category_id'])
                ->first();

            if ($existingSkill) {
                $skillId = $existingSkill->id;
            } else {
                $newSkill = Skill::create([
                    'name' => ucfirst($validated['custom_skill']),
                    'category_id' => $validated['category_id'],
                ]);
                $skillId = $newSkill->id;
            }
        } elseif (!empty($validated['skill_id']) && $validated['skill_id'] !== 'others') {
            $skillId = $validated['skill_id'];
        }

        $user->artisan()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'hall_of_residence' => $validated['hall_of_residence'] ?? null,
                'faculty' => $validated['faculty'] ?? null,
                'department' => $validated['department'] ?? null,
                'matric_no' => $validated['matric_no'] ?? null,
                'room_number' => $validated['room_number'] ?? null,
                'portfolio_url' => $validated['portfolio_url'] ?? null,
                'years_of_experience' => $validated['years_of_experience'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'avatar' => $avatarPath ?? $user->artisan->avatar ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'skill_id' => $skillId,
            ]
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
}

}
