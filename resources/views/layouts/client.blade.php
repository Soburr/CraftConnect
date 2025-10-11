<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Client Dashboard')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-gray-800 bg-gray-50">

  <!-- Mobile Navbar -->
  <header class="flex items-center justify-between px-4 py-3 text-white bg-green-600 md:hidden">
    <h1 class="text-lg font-bold">Lag Artisans</h1>
    <button id="menu-btn" class="focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </header>

  <div class="flex">

    <!-- Sidebar -->
    <aside id="sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen bg-green-700 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
      <div class="p-6">
        <h2 class="mb-10 text-2xl font-bold">Lag Artisans</h2>
        <nav class="space-y-4">
          <a href="{{ route('client.dashboard') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('client.dashboard') ? 'bg-green-900' : '' }}">Dashboard</a>
          <a href="{{ route('client.profile') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('client.profile') ? 'bg-green-900' : '' }}">Profile</a>
          <a href="{{ route('client.artisan') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('client.artisan') ? 'bg-green-900' : '' }}">Find Artisans</a>
          <a href="{{ route('client.bookings') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('client.bookings') ? 'bg-green-900' : '' }}">My Bookings</a>
          <a href="{{ route('client.reviews') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('client.reviews') ? 'bg-green-900' : '' }}">Reviews</a>
          <a href="#" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('client.messages') ? 'bg-green-900' : '' }}">Messages</a>
        </nav>
      </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 hidden bg-black bg-opacity-40 md:hidden"></div>

    <!-- Main Content -->
    <main class="flex-1 md:ml-64 w-full min-h-screen bg-gray-50 overflow-y-auto">
      <!-- Fixed top header (desktop) -->
      <div class="hidden md:flex items-center justify-between px-6 py-4 bg-green-600 text-white sticky top-0 z-30">
        <div class="text-xl font-semibold">Client Dashboard</div>
        <div class="flex items-center space-x-4">
          <span class="font-medium">Welcome, {{ Auth::user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-3 py-1 text-sm font-semibold bg-white text-green-700 rounded hover:bg-gray-100">
              Logout
            </button>
          </form>
        </div>
      </div>

      <!-- Actual page content -->
      <div class="max-w-5xl mx-auto p-6">
        @yield('content')
      </div>
    </main>
  </div>

  <!-- JS for Sidebar Toggle -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
      document.body.classList.toggle('overflow-hidden');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    });
  </script>

</body>
</html>
