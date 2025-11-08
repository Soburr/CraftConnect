@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="p-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Artisan Details</h1>
        <a href="{{ route('admin.artisans.index') }}" class="text-green-600 hover:underline">← Back to List</a>
    </div>

    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
        <div class="grid grid-cols-2 gap-4">
            <p><strong>Name:</strong> {{ $artisan->name }}</p>
            <p><strong>Email:</strong> {{ $artisan->email }}</p>
            <p><strong>Skill:</strong> {{ $artisan->artisan->skill->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong>
                <span class="capitalize px-3 py-1 rounded text-white
                    {{ $artisan->status == 'suspended' ? 'bg-yellow-500' : ($artisan->status == 'blocked' ? 'bg-red-600' : 'bg-green-600') }}">
                    {{ $artisan->status }}
                </span>
            </p>
            <p><strong>Joined:</strong> {{ $artisan->created_at->format('M d, Y') }}</p>
        </div>

        <div class="mt-4 flex space-x-3">
            <form action="{{ route('admin.artisans.suspend', $artisan->id) }}" method="POST">
                @csrf
                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Suspend
                </button>
            </form>

            <form action="{{ route('admin.artisans.block', $artisan->id) }}" method="POST">
                @csrf
                <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Block
                </button>
            </form>

            <form action="{{ route('admin.artisans.destroy', $artisan->id) }}" method="POST">
                @csrf @method('DELETE')
                <button class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Bookings -->
    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Bookings</h2>
        @if ($artisan->artisan->bookings->count() > 0)
            <table class="min-w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Client</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($artisan->artisan->bookings as $booking)
                    <tr class="border-t">
                        <td class="p-3">{{ $booking->client->name ?? 'N/A' }}</td>
                        <td class="p-3">{{ $booking->created_at->format('M d, Y') }}</td>
                        <td class="p-3 capitalize">{{ $booking->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No bookings found for this artisan.</p>
        @endif
    </div>

    <!-- Reviews -->
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-xl font-semibold mb-4">Reviews</h2>
        @if ($artisan->artisan->reviews->count() > 0)
            <ul class="space-y-4">
                @foreach ($artisan->artisan->reviews as $review)
                    <li class="border-b pb-3">
                        <p><strong>Client:</strong> {{ $review->client->name ?? 'N/A' }}</p>
                        <p><strong>Rating:</strong> ⭐ {{ $review->rating }}</p>
                        <p><strong>Review:</strong> {{ $review->review }}</p>
                        <p class="text-gray-500 text-sm">Posted on {{ $review->created_at->format('M d, Y') }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No reviews available for this artisan.</p>
        @endif
    </div>
</div>
@endsection
