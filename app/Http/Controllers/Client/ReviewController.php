<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function review()
    {
       $clientId = Auth::id();

       $reviews = Review::with('artisan.skill')->where('client_id', $clientId)->latest()->get();
       return view('client.reviews', compact('reviews'));
    }
}
