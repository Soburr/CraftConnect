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

  <!-- Desktop Fixed Top Header -->
  <div class="hidden md:flex items-center justify-between px-6 py-4 bg-green-600 text-white fixed top-0 left-64 right-0 z-40 h-16">
    <div class="text-xl font-semibold">Client Dashboard</div>
    <div class="flex items-center space-x-4">
      <button class="relative">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
      </button>
      <span class="font-medium">Welcome, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-3 py-1 text-sm font-semibold bg-white text-green-700 rounded hover:bg-gray-100">Logout</button>
      </form>
    </div>
  </div>

  <div class="flex pt-0 md:pt-16">

    <!-- Sidebar -->
    <aside id="sidebar"
           class="fixed top-0 left-0 z-50 w-64 h-full text-white transition-transform duration-300 ease-in-out transform -translate-x-full bg-green-600 md:static md:h-screen md:translate-x-0">
      <div class="p-6">
        <h2 class="mb-10 text-2xl font-bold">Lag Artisans</h2>
        <nav class="space-y-4">
          <a href="{{ route('client.dashboard') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('dashboard') ? 'bg-green-900' : '' }}"> Dashboard</a>
          <a href="{{ route('client.profile') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('client.profile') ? 'bg-green-900' : '' }}"> Profile</a>
          <a href="{{ route('client.artisan') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('profile') ? 'bg-green-900' : '' }}"> Find Artisans</a>
          <a href="{{ route('client.bookings') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('profile') ? 'bg-green-900' : '' }}"> My Bookings</a>
          <a href="{{ route('client.reviews') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('profile') ? 'bg-green-900' : '' }}"> Reviews</a>
          <a href="" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('messages') ? 'bg-green-900' : '' }}"> Messages</a>
        </nav>
      </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 hidden bg-black bg-opacity-40 md:hidden"></div>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:ml-64 w-full md:mt-16 bg-gray-50 h-[calc(100vh-4rem)] overflow-y-auto">
        <div class="w-full max-w-5xl ">
            @yield('content')
        </div>
      </main>
  </div>

  <!-- JS for Toggle -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    });
  </script>

</body>
</html>
