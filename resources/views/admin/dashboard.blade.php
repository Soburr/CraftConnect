@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Admin Dashboard Overview -->
<div class="min-h-screen px-4 py-10 bg-white md:px-10">

    <!-- Header -->
    <div class="flex flex-col items-start justify-between mb-10 md:flex-row md:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-800 md:text-3xl">Dashboard Overview</h1>
        <p class="mt-1 text-sm text-gray-500">Welcome back, Super Admin 👋</p>
      </div>
      <button onclick="window.location.reload()" class="px-5 py-2 mt-4 text-white transition bg-green-600 rounded-lg shadow md:mt-0 hover:bg-green-700">
        Refresh Stats
      </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 mb-12 md:grid-cols-4">
      <!-- Total Artisans -->
      <div class="p-6 border border-green-200 shadow-sm bg-green-50 rounded-xl">
        <h2 class="mb-2 text-sm text-gray-600">Total Artisans</h2>
        <p class="text-3xl font-semibold text-green-700">{{ $totalArtisans ?? '0' }}</p>
      </div>

      <!-- Total Clients -->
      <div class="p-6 border border-green-200 shadow-sm bg-green-50 rounded-xl">
        <h2 class="mb-2 text-sm text-gray-600">Total Clients</h2>
        <p class="text-3xl font-semibold text-green-700">{{ $totalClients ?? '0' }}</p>
      </div>

      <!-- Total Bookings -->
      <div class="p-6 border border-green-200 shadow-sm bg-green-50 rounded-xl">
        <h2 class="mb-2 text-sm text-gray-600">Total Bookings</h2>
        <p class="text-3xl font-semibold text-green-700">{{ $totalBookings ?? '0' }}</p>
      </div>

      <!-- Total Reviews -->
      <div class="p-6 border border-green-200 shadow-sm bg-green-50 rounded-xl">
        <h2 class="mb-2 text-sm text-gray-600">Total Reviews</h2>
        <p class="text-3xl font-semibold text-green-700">{{ $totalReviews ?? '0' }}</p>
      </div>
    </div>

    <!-- New Signups -->
    <div class="p-6 mb-10 bg-white border border-green-100 shadow-sm rounded-xl">
      <h2 class="mb-4 text-lg font-semibold text-gray-800">New Signups This Week</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="text-sm text-green-800 uppercase bg-green-100">
            <tr>
              <th class="p-3">Name</th>
              <th class="p-3">Email</th>
              <th class="p-3">Role</th>
              <th class="p-3">Date Joined</th>
            </tr>
          </thead>
          <tbody>
            @forelse($newSignups ?? [] as $user)
            <tr class="transition border-b border-gray-100 hover:bg-green-50">
              <td class="p-3">{{ $user->name }}</td>
              <td class="p-3 text-gray-600">{{ $user->email }}</td>
              <td class="p-3 text-gray-600 capitalize">{{ $user->role }}</td>
              <td class="p-3 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="p-4 text-center text-gray-500">No new signups this week</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Top Rated Artisans -->
    <div class="p-6 mb-10 bg-white border border-green-100 shadow-sm rounded-xl">
      <h2 class="mb-4 text-lg font-semibold text-gray-800">Top-Rated Artisans</h2>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @forelse($topArtisans ?? [] as $artisan)
        <div class="flex items-center p-5 space-x-4 border border-green-100 bg-green-50 rounded-xl">
          <img src="{{ $artisan->avatar ? asset('storage/' . $artisan->avatar) : 'https://via.placeholder.com/60' }}" class="object-cover border-2 border-green-500 rounded-full w-14 h-14" alt="">
          <div>
            <h3 class="font-semibold text-gray-800">{{ $artisan->user->name }}</h3>
            <p class="text-sm text-gray-500">{{ optional($artisan->skill)->name ?? 'No Skill Listed' }}</p>
            <div class="flex items-center mt-1">
              <span class="mr-1 text-sm text-yellow-500">★</span>
              <span class="text-sm text-gray-600">{{ number_format($artisan->reviews_avg_rating ?? 0, 1) }}</span>
            </div>
          </div>
        </div>
        @empty
        <p class="text-sm text-gray-500">No top artisans found yet</p>
        @endforelse
      </div>
    </div>

    <!-- Weekly Signups Chart -->
    <div class="p-6 mb-10 bg-white border border-green-100 shadow-sm rounded-xl">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Weekly User Signups</h2>
        <p class="text-sm text-gray-500">Showing activity from the past 7 days</p>
      </div>
      <canvas id="weeklyChart" height="100"></canvas>
    </div>

    <!-- Monthly Growth Chart -->
    <div class="p-6 bg-white border border-green-100 shadow-sm rounded-xl">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Monthly Growth (Artisans vs Clients)</h2>
        <p class="text-sm text-gray-500">Showing user registrations this year</p>
      </div>
      <canvas id="monthlyGrowthChart" height="100"></canvas>
    </div>
  </div>

  <!-- Include Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // Weekly chart
    const weeklyCtx = document.getElementById('weeklyChart');
    new Chart(weeklyCtx, {
      type: 'line',
      data: {
        labels: @json($chartLabels),
        datasets: [{
          label: 'New Signups',
          data: @json($chartData),
          borderColor: '#16a34a',
          backgroundColor: 'rgba(22,163,74,0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointBackgroundColor: '#16a34a'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#374151' } },
          y: { beginAtZero: true, ticks: { color: '#374151', stepSize: 1 } }
        }
      }
    });

    // Monthly growth chart
    const monthlyCtx = document.getElementById('monthlyGrowthChart');
    new Chart(monthlyCtx, {
      type: 'bar',
      data: {
        labels: @json($months),
        datasets: [
          {
            label: 'Artisans',
            data: @json($artisanGrowth),
            backgroundColor: 'rgba(34,197,94,0.7)'
          },
          {
            label: 'Clients',
            data: @json($clientGrowth),
            backgroundColor: 'rgba(34,197,94,0.3)'
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true }
        }
      }
    });
  </script>


@endsection
