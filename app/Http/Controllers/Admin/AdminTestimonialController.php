<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('admin.testimonial', compact('testimonials'));
    }

    public function approve($id)
    {
        Testimonial::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'Testimonial approved successfully');
    }

    public function reject($id)
    {
        Testimonial::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('error', 'Testimonial rejected successfully');
    }
}
