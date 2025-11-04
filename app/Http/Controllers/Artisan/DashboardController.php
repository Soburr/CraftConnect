<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function viewDashboard()
    {
        $artisan = Artisan::where('user_id', Auth::id())->first();

        if (!$artisan) {
            return redirect()->route('artisan.profile')->with('error', 'Please complete your profile first');
        }

        $totalBookings = Booking::where('artisan_id', $artisan->id)->count();
        
        $completedBookings = Booking::where('artisan_id', $artisan->id)
            ->where('status', 'completed')
            ->count();
        
        $averageRating = Review::where('artisan_id', $artisan->id)->avg('rating') ?? 0;
        
        $activeBookings = Booking::with(['client', 'skill'])
            ->where('artisan_id', $artisan->id)
            ->where('status', 'in_progress')
            ->latest()
            ->take(5)
            ->get();
        
        $recentReviews = Review::with(['client'])
            ->where('artisan_id', $artisan->id)
            ->latest()
            ->take(3)
            ->get();

        return view('artisan.dashboard', compact(
            'artisan',
            'totalBookings',
            'completedBookings',
            'averageRating',
            'activeBookings',
            'recentReviews'
        ));
    }

}
