<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function artisanReviews()
    {
        $artisanId = Auth::id();

        $reviews = Review::with(['skill', 'client'])
                         ->where('artisan_id', $artisanId)
                         ->latest()
                         ->get();

        return view('artisan.reviews', compact('reviews'));
    }

}
