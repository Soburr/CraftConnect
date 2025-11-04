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
            <td class="py-3 px-4">{{ $booking->artisan->user->name ?? 'N/A' }}</td>
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
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold flex items-center text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-3-3h-4M9 20H4v-2a3 3 0 013-3h4m1-4a4 4 0 110-8 4 4 0 010 8z" />
            </svg>
            Recommended Artisans
        </h2>
        <button id="toggleViewAll" class="text-sm text-green-600 hover:text-green-700 focus:outline-none">
            <span id="viewAllText">View All →</span>
        </button>
    </div>

    @if($recommendedArtisans->isEmpty())
        <p class="text-center text-gray-500 py-8">No artisans available yet</p>
    @else
        <div id="recommendedGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recommendedArtisans as $index => $artisan)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 text-center flex flex-col h-full hover:shadow-md transition {{ $index >= 3 ? 'hidden extra-artisan' : '' }}">
                    <!-- Artisan Avatar -->
                    <img src="{{ $artisan->avatar ? asset('storage/' . $artisan->avatar) : 'https://via.placeholder.com/80' }}"
                         alt="{{ $artisan->user->name }}"
                         class="w-20 h-20 mx-auto bg-gray-200 rounded-full mb-3 object-cover border-2 border-green-500">

                    <!-- Top Badge -->
                    @if($index === 0)
                        <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-yellow-500 rounded-full mb-2">
                            🏆 Top Rated
                        </span>
                    @else
                        <div class="h-7 mb-2"></div> {{-- Spacer to maintain height --}}
                    @endif

                    <!-- Name -->
                    <p class="font-semibold text-gray-800">{{ $artisan->user->name }}</p>

                    <!-- Skill -->
                    <p class="text-sm text-gray-500 mb-2">{{ $artisan->skill->name ?? 'N/A' }}</p>

                    <!-- Rating Stars -->
                    <div class="flex justify-center items-center space-x-1 my-2">
                        @php
                            $rating = $artisan->reviews_avg_rating ?? 0;
                            $fullStars = floor($rating);
                        @endphp

                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                <span class="text-yellow-400 text-base">★</span>
                            @else
                                <span class="text-gray-300 text-base">★</span>
                            @endif
                        @endfor
                        <span class="text-xs text-gray-500 ml-1">({{ number_format($rating, 1) }})</span>
                    </div>

                    <!-- Tier Badge -->
                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full mb-3
                        @if($artisan->tier === 'Elite') bg-purple-100 text-purple-700
                        @elseif($artisan->tier === 'Gold') bg-yellow-100 text-yellow-700
                        @elseif($artisan->tier === 'Silver') bg-gray-100 text-gray-700
                        @else bg-orange-100 text-orange-700
                        @endif">
                        {{ $artisan->tier }}
                    </span>

                    <!-- Book Now Button - Pushed to bottom -->
                    <form method="POST" action="{{ route('client.book-artisan', $artisan->id) }}" class="mt-auto">
                        @csrf
                        <input type="hidden" name="skill_id" value="{{ $artisan->skill_id }}">
                        <button type="submit" class="w-full px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Book Now
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- JavaScript for View All toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('toggleViewAll');
        const viewAllText = document.getElementById('viewAllText');
        const extraArtisans = document.querySelectorAll('.extra-artisan');
        let isExpanded = false;

        toggleBtn?.addEventListener('click', () => {
            isExpanded = !isExpanded;

            extraArtisans.forEach(artisan => {
                if (isExpanded) {
                    artisan.classList.remove('hidden');
                } else {
                    artisan.classList.add('hidden');
                }
            });

            viewAllText.textContent = isExpanded ? '← Show Less' : 'View All →';
        });
    });
</script>

</div>

@endsection
