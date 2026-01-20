<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use App\Models\Artisan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // ====== Basic Stats ======
        $totalArtisans = User::where('role', 'artisan')->count();
        $totalClients = User::where('role', 'client')->count();
        $totalBookings = Booking::count();
        $totalReviews = Review::count();

        // ====== New Signups (This Week) ======
        $newSignups = User::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // ====== Top Rated Artisans ======
        $topArtisans = Artisan::with([
            'user',
            'skill'
        ])
        ->withAvg('reviews', 'rating')
        ->where('score', '>', 0)
        ->orderByDesc('score')
        ->take(3)
        ->get();

        // ====== Weekly Signup Chart ======
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $chartLabels[] = $day->format('D');
            $chartData[] = User::whereDate('created_at', $day)->count();
        }

        // ====== Monthly Growth Chart (Artisans vs Clients) ======
        $months = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'))->toArray();

        $artisanGrowth = [];
        $clientGrowth = [];

        foreach (range(1, 12) as $month) {
            $artisanGrowth[] = User::where('role', 'artisan')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count();

            $clientGrowth[] = User::where('role', 'client')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalArtisans',
            'totalClients',
            'totalBookings',
            'totalReviews',
            'newSignups',
            'topArtisans',
            'chartLabels',
            'chartData',
            'months',
            'artisanGrowth',
            'clientGrowth'
        ));
    }
}
