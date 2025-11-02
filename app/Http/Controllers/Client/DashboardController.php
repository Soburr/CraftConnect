<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboard()
    {
        $clientId = auth()->id();

        $totalBookings = Booking::where('client_id', $clientId)->count();

        $completedBookings = Booking::where('client_id', $clientId)->where('status', 'completed')->count();

        $totalReviews = Review::where('client_id', $clientId)->count();

        $pendingBookings = Booking::where('client_id', $clientId)->where('status', 'pending')->count();
        return view('client.dashboard', compact(
            'totalBookings',
            'completedBookings',
            'totalReviews',
            'pendingBookings'
        ));
    }

    public function recentBookings()
    {
        $clientId = auth()->id();

        $totalBookings = Booking::where('client_id', $clientId)->count();
        $totalReviews = Review::where('client_id', $clientId)->count();
        $completedBookings = Booking::where('client_id', $clientId)->where('status', 'completed')->count();
        $pendingBookings = Booking::where('client_id', $clientId)->where('status', 'pending')->count();
        $recent = Booking::with(['artisan', 'skill'])->where('client_id', $clientId)->orderBy('booking_date', 'desc')->take(3)->get();
        return view('client.dashboard', compact(
            'totalBookings',
            'totalReviews',
            'recent',
            'completedBookings',
            'pendingBookings'
        ));
    }

}
