<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="text-gray-800 bg-gray-50">

    <!-- Mobile Navbar -->
    <header class="flex items-center justify-between px-4 py-3 text-white bg-green-600 md:hidden">
        <h1 class="text-lg font-bold">Lag Artisans</h1>
        <button id="menu-btn" class="focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <div class="flex">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen text-white transition-transform duration-300 ease-in-out transform -translate-x-full bg-green-700 md:translate-x-0">
            <div class="p-6">
                <h2 class="mb-10 text-2xl font-bold">Lag Artisans</h2>
                <nav class="space-y-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('admin.dashboard') ? 'bg-green-900' : '' }}">Overview</a>
                    <a href="{{ route('admin.artisans.index') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('admin.artisans.index') ? 'bg-green-900' : '' }}">Artisans</a>
                    <a href="{{ route('admin.clients.index') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('admin.clients.index') ? 'bg-green-900' : '' }}">Clients</a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('admin.categories.index') ? 'bg-green-900' : '' }}">Categories
                        Management</a>
                    <a href="{{ route('admin.skills.index') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('admin.skills.index') ? 'bg-green-900' : '' }}">Skills Management</a>
                    <a href="{{ route('admin.testimonials.index') }}" class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('admin.testimonials.index') ? 'bg-green-900' : '' }}">Testimonials</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 text-sm font-semibold text-green-700 bg-white rounded hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 hidden bg-black bg-opacity-40 md:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 w-full min-h-screen overflow-y-auto md:ml-64 bg-gray-50">
            <!-- Fixed top header (desktop) -->
            <div
                class="sticky top-0 z-30 items-center justify-between hidden px-6 py-4 text-white bg-green-600 md:flex">
                <div class="text-xl font-semibold">Admin Dashboard</div>
                <div class="flex items-center space-x-4">
                    <span class="font-medium">Welcome, {{ Auth::user()->name }}</span>
                </div>
            </div>

            <!-- Actual page content -->
            <div class="max-w-5xl p-6 mx-auto">
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
