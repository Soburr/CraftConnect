<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('status', 'approved')->latest()->take(5)->get();
        return view('homepage', compact('testimonials'));
    }
}
