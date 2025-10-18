<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

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


        $query = Artisan::with(['user', 'skill.category']);

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
}
