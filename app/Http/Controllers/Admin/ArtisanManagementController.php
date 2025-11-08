<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ArtisanManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $artisans = User::where('role', 'artisan')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->with('artisan.skill')
            ->latest()
            ->paginate(10);

        return view('admin.artisans.index', compact('artisans', 'search'));
    }

    public function show($id)
    {
        $artisan = User::with(['artisan.skill', 'artisan.bookings', 'artisan.reviews'])
            ->where('role', 'artisan')
            ->findOrFail($id);

        return view('admin.artisans.show', compact('artisan'));
    }

    public function suspend($id)
    {
        $artisan = User::findOrFail($id);
        $artisan->status = 'suspended';
        $artisan->save();

        return back()->with('success', 'Artisan suspended successfully.');
    }

    public function block($id)
    {
        $artisan = User::findOrFail($id);
        $artisan->status = 'blocked';
        $artisan->save();

        return back()->with('success', 'Artisan blocked successfully.');
    }

    public function destroy($id)
    {
        $artisan = User::findOrFail($id);
        $artisan->delete();

        return back()->with('success', 'Artisan deleted successfully.');
    }


}
