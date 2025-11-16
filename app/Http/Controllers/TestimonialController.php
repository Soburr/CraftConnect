<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required'
        ]);

        Testimonial::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $request->name,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Thank you! Your testimonial has been submitted');
    }

    public function getAll()
    {
        $testimonials = Testimonial::where('status', 'approved')->latest()->get();
        return view('homepage', compact('testimonials'));
    }
}
