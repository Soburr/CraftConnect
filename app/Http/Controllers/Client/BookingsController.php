<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

    public function markComplete(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->update(['status' => 'completed']);
        return response()->json(['success' => true, 'status' => 'completed']);
    }

    public function cancel(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->update(['status' => 'cancelled']);
        return response()->json(['success' => true, 'status' => 'cancelled']);
    }

    public function rebook(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->update(['status' => 'in-progress']);
        return response()->json(['success' => true, 'status' => 'in-progress']);
    }

    public function review(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'client_id' => Auth::id(),
            'artisan_id' => $booking->artisan_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['success' => true, 'message' => 'Review submitted']);
    }

    private function authorizeBooking(Booking $booking)
    {
        abort_unless($booking->client_id === Auth::id(), 403);
    }
}
