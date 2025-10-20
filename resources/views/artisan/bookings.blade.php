@extends('layouts.artisan')

@section('title', 'My Bookings')

@section('content')
<div class="min-h-screen bg-white px-4 md:px-10 py-10">

  <!-- Header -->
  <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">My Bookings</h1>
    <p class="text-gray-500 text-sm mt-1">View and track your ongoing and completed bookings.</p>
  </div>

  <!-- Bookings List -->
  <div class="space-y-4">
    @forelse($bookings as $booking)
      <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 hover:shadow-md transition">
        <div class="flex flex-col md:flex-row justify-between md:items-center">

          <!-- Left Section -->
          <div>
            <h2 class="text-lg font-semibold text-gray-800">
              {{ $booking->skill->name ?? 'Service' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
              <span class="font-medium text-gray-700">Client:</span>
              {{ $booking->client->name }}
            </p>
            <p class="text-sm text-gray-500">
              <span class="font-medium text-gray-700">Location:</span>
              {{ $booking->client->clientProfile->hall_of_residence ?? 'Not Provided' }}
            </p>
            <p class="text-sm text-gray-500">
              <span class="font-medium text-gray-700">Date:</span>
              {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
            </p>
          </div>

          <!-- Right Section -->
          <div class="mt-3 md:mt-0 text-right">
            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full {{ $booking->status_color }}">
              {{ ucfirst($booking->status_label) }}
            </span>

            @if($booking->status === 'in_progress')
              <p class="text-xs text-gray-400 mt-1">Waiting for client completion</p>
            @elseif($booking->status === 'completed')
              <p class="text-xs text-green-600 mt-1">✅ Job completed successfully</p>
            @elseif($booking->status === 'cancelled')
              <p class="text-xs text-red-600 mt-1">❌ Job cancelled</p>
            @endif
          </div>

        </div>
      </div>
    @empty
      <div class="text-center py-16">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png" alt="No Bookings" class="w-32 mx-auto mb-4 opacity-70">
        <p class="text-gray-500 text-sm">You have no bookings yet.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection
