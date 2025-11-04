<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function viewDashboard()
    {
        $user = Auth::user()->load('client');

        $clientId = $user->client->id;
        $totalBookings = Booking::where('client_id', $clientId)->count();
        $completedBookings = Booking::where('client_id', $clientId)->where('status', 'completed')->count();
        $totalReviews = Review::where('client_id', $clientId)->count();
        $pendingBookings = Booking::where('client_id', $clientId)->where('status', 'pending')->count();

        $recent = Booking::with(['artisan.user', 'skill'])
            ->where('client_id', $clientId)
            ->orderBy('booking_date', 'desc')
            ->take(3)
            ->get();

        $recommendedArtisans = Artisan::with(['user', 'skill'])
            ->withAvg('reviews', 'rating')
            ->where('score', '>', 0)
            ->orderByDesc('score')
            ->take(10)
            ->get();

        return view('client.dashboard', compact(
            'totalBookings',
            'completedBookings',
            'totalReviews',
            'pendingBookings',
            'recent',
            'recommendedArtisans',
            'user'
        ));
    }

}
