<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Artisan Dashboard')</title>
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
           class="fixed top-0 left-0 z-50 w-64 h-full text-white transition-transform duration-300 ease-in-out transform -translate-x-full bg-green-600 md:static md:h-screen md:translate-x-0">
      <div class="p-6">
        <h2 class="mb-10 text-2xl font-bold">Lag Artisans</h2>
        <nav class="space-y-4">
          <a href="" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('dashboard') ? 'bg-green-900' : '' }}">🏠 Dashboard</a>
          <a href="" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('profile') ? 'bg-green-900' : '' }}">👤 Profile</a>
          <a href="" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('messages') ? 'bg-green-900' : '' }}">💬 Messages</a>
          <a href="" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('reviews') ? 'bg-green-900' : '' }}">⭐ Reviews</a>
          <a href="" class="block px-4 py-2 rounded hover:bg-green-700">🚪 Log out</a>
        </nav>
      </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 hidden bg-black bg-opacity-40 md:hidden"></div>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:ml-64">
      @yield('content')
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
