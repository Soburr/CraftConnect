<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Post;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $featuredPosts = Post::with(['user', 'likes', 'comments'])->latest()->take(3)->get();

        $testimonials = Testimonial::where('status', 'approved')->latest()->take(5)->get();
        
        return view('homepage', [
          'featuredPosts' => $featuredPosts,
          'testimonials' => $testimonials
        ]);
    }
}
