<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function booking()
    {
        $bookings = Booking::with(['artisan'])
            ->where('client_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.bookings', compact('bookings'));
    }

    public function store(Request $request, $artisanId)
    {
        Booking::create([
            'client_id' => Auth::id(),
            'artisan_id' => $artisanId,
            'skill_id' => $request->skill_id,
            'booking_date' => Carbon::now(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Booking created successfully');
    }

    public function markComplete(Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $booking->update(['status' => 'completed']);

        return response()->json(['success' => true, 'status' => 'completed']);
    }

    public function cancel(Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => Carbon::now()
        ]);

        return response()->json(['success' => true, 'status' => 'cancelled']);
    }

    public function rebook(Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($booking->status !== 'cancelled' || !$booking->cancelled_at) {
            return response()->json(['success' => false, 'message' => 'Cannot rebook this'], 400);
        }

        // if (Carbon::parse($booking->cancelled_at)->diffInHours(Carbon::now()) > 2) {
        //     return response()->json(['success' => false, 'message' => 'Rebook time expired'], 400);
        // }

        $booking->update([
            'status' => 'in_progress',
            'booking_date' => Carbon::now(),
        ]);

        return response()->json(['success' => true, 'status' => 'in_progress']);
    }

    public function review(Request $request, Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $booking->review()->create([
            'client_id' => Auth::id(),
            'artisan_id' => $booking->artisan_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json(['success' => true, 'message' => 'Review submitted successfully']);
    }
}
