@extends('layouts.admin')

@section('title', 'Client Details')

@section('content')
<div class="min-h-screen bg-white p-6 space-y-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Clients Details</h1>
        <a href="{{ route('admin.clients.index') }}" class="text-green-600 hover:underline">← Back to List</a>
    </div>

    <!-- Basic Profile Details -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-6 shadow-sm">
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">{{ $client->name }}</h1>
        <p class="text-gray-600 mb-1"><strong>Email:</strong> {{ $client->email }}</p>
        <p class="text-gray-600 mb-1"><strong>Phone:</strong> {{ $client->number ?? '-' }}</p>
        <p class="text-gray-600 mb-1"><strong>Status:</strong>
            <span class="capitalize">{{ $client->status ?? 'active' }}</span>
        </p>
        <p class="text-gray-600 mb-1"><strong>Hostel:</strong> {{ $client->hall_of_residence ?? '-' }}</p>
    </div>

    <!-- Bookings -->
    <div class="bg-white border border-green-100 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Bookings</h2>
        @if($clientBookings->count())
            <table class="w-full text-left border-collapse">
                <thead class="bg-green-100 text-green-800 text-sm uppercase">
                    <tr>
                        <th class="p-2">Artisan</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientBookings as $booking)
                    <tr class="border-b hover:bg-green-50 transition">
                        <td class="p-2">{{ $booking->artisan->user->name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $booking->created_at->format('M d, Y') }}</td>
                        <td class="p-2 capitalize">{{ $booking->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination with brand colors -->
            <div class="mt-4">
                {{ $clientBookings->links('vendor.pagination.tailwind-green') }}
            </div>
        @else
            <p class="text-gray-500">No bookings found.</p>
        @endif
    </div>

    <!-- Reviews -->
    <div class="bg-white border border-green-100 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Reviews</h2>
        @if($clientReviews->count())
            <div class="space-y-4">
                @foreach($clientReviews as $review)
                    <div class="border-b py-2">
                        <p><strong>Artisan:</strong> {{ $review->artisan->user->name ?? 'N/A' }}</p>
                        <p><strong>Rating:</strong> ⭐ {{ $review->rating }}</p>
                        <p>{{ $review->review ?? '-' }}</p>
                        <p class="text-gray-400 text-sm">Reviewed on: {{ $review->created_at->format('M d, Y') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $clientReviews->links('vendor.pagination.tailwind-green') }}
            </div>
        @else
            <p class="text-gray-500">No reviews found.</p>
        @endif
    </div>

</div>
@endsection
