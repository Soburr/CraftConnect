<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function booking()
    {
        $bookings = Booking::where('artisan_id', Auth::user()->artisan->id)
            ->with(['client', 'skill'])
            ->latest()
            ->get();

        return view('artisan.bookings', compact('bookings'));
    }

}
