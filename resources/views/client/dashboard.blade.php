@extends('layouts.client')

@section('title', 'Client Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">

      <!-- Greeting -->
  <div class="text-center mb-10">
    <h2 class="text-2xl font-bold text-green-600">👋 Hi, {{ Auth::user()->name ?? 'Client' }}!</h2>
    <p class="text-gray-600">Find trusted student-artisans on campus.</p>
  </div>


  <!-- Dashboard Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Artisans Card -->
        <a href="{{ route('client.artisan') }}" class="block">
        <div class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition">
            <div class="bg-blue-100 p-3 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-3-3h-4M9 20H4v-2a3 3 0 013-3h4m1-4a4 4 0 110-8 4 4 0 010 8z" />
              </svg>
            </div>
            <div>
              <h3 class="text-gray-500 text-sm">Find Artisans</h3>
            </div>
          </div>
        </a>

    <!-- Bookings Card -->
    <a href="{{ route('client.bookings') }}" class="block">
    <div class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition">
      <div class="bg-green-100 p-3 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
      <div>
        <p class="text-gray-500 text-sm">My Bookings</p>
        <h3 class="text-xl font-semibold text-gray-800">{{ $completedBookings }}</h3>
      </div>
    </div>
    </a>

    <!-- Reviews Card -->
    <a href="{{ route('client.reviews') }}" class="block">
    <div class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition">
      <div class="bg-yellow-100 p-3 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.905c.969 0 1.371 1.24.588 1.81l-3.97 2.88a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.97-2.88a1 1 0 00-1.176 0l-3.97 2.88c-.785.57-1.84-.196-1.54-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.88c-.783-.57-.38-1.81.588-1.81h4.905a1 1 0 00.95-.69l1.518-4.674z" />
        </svg>
      </div>
      <div>
        <p class="text-gray-500 text-sm">Reviews</p>
        <h3 class="text-xl font-semibold text-gray-800">{{ $totalReviews }}</h3>
      </div>
    </div>
    </a>


  </div>

  <!-- Recent Bookings Table -->
  <div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-lg font-semibold mb-4 flex items-center text-green-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      Recent Bookings
    </h2>
    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="border-b text-gray-600">
          <th class="py-3 px-4">Name</th>
          <th class="py-3 px-4">Skill</th>
          <th class="py-3 px-4">Date</th>
          <th class="py-3 px-4">Review</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($recent as $booking)
        <tr class="border-b hover:bg-gray-50">
            <td class="py-3 px-4">{{ $booking->artisan->name ?? 'N/A' }}</td>
            <td class="py-3 px-4">{{ $booking->skill->name ?? 'N/A' }}</td>
            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
            <td class="py-3 px-4">{{ \Illuminate\Support\Str::limit($booking->review->review ?? 'No review', 10, '...') }}</td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>

  <!-- Recommended Artisans -->
  <div class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-semibold mb-4 flex items-center text-green-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-3-3h-4M9 20H4v-2a3 3 0 013-3h4m1-4a4 4 0 110-8 4 4 0 010 8z" />
      </svg>
      Recommended Artisans
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="text-center">
        <div class="w-20 h-20 mx-auto bg-gray-200 rounded-full mb-3"></div>
        <p class="font-semibold">Chioma</p>
        <p class="text-sm text-gray-500">Makeup Artist</p>
        <p class="text-yellow-500">★★★★☆</p>
        <button class="mt-2 px-4 py-2 text-sm bg-green-600 text-white rounded">View Profile</button>
      </div>
      <div class="text-center">
        <div class="w-20 h-20 mx-auto bg-gray-200 rounded-full mb-3"></div>
        <p class="font-semibold">Tunde</p>
        <p class="text-sm text-gray-500">Electrician</p>
        <p class="text-yellow-500">★★★☆☆</p>
        <button class="mt-2 px-4 py-2 text-sm bg-green-600 text-white rounded">View Profile</button>
      </div>
      <div class="text-center">
        <div class="w-20 h-20 mx-auto bg-gray-200 rounded-full mb-3"></div>
        <p class="font-semibold">Tunde</p>
        <p class="text-sm text-gray-500">Electrician</p>
        <p class="text-yellow-500">★★★☆☆</p>
        <button class="mt-2 px-4 py-2 text-sm bg-green-600 text-white rounded">View Profile</button>
      </div>

    </div>
  </div>

</div>

@endsection
