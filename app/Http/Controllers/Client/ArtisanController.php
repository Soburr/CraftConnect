<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $location = $request->input('location');

        $categories = Category::all();
        $locations = Artisan::select('hall_of_residence')->distinct()->pluck('hall_of_residence');

        if (!$search && !$category && !$location) {
            $artisans = collect();
            return view('client.artisan', compact('artisans', 'categories', 'locations', 'search', 'category', 'location'));
        }


        $query = Artisan::with(['user', 'skill.category'])->withAvg('reviews', 'rating');;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('skill', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('user', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($category) {
            $query->whereHas('skill', function ($q) use ($category) {
                $q->where('category_id', $category);
            });
        }

        if ($location) {
            $query->where('hall_of_residence', $location);
        }

        $artisans = $query->get();

        return view('client.artisan', compact('artisans', 'categories', 'locations', 'search', 'category', 'location'));
    }

    public function bookArtisan($artisanId) {
    Booking::create([
        'client_id' => Auth::id(),
        'artisan_id' => $artisanId,
        'skill_id' => request('skill_id'),
        'booking_date' => now(),
        'status' => 'in_progress',
    ]);

    return redirect()->route('client.bookings')->with('success', 'Booking created successfully!');
}

}
