<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Artisan Dashboard')</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png?v=4') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png?v=4') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png?v=4') }}">

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
                    <a href="{{ route('artisan.dashboard') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('artisan.dashboard') ? 'bg-green-900' : '' }}">Overview</a>
                    <a href="{{ route('artisan.profile') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('artisan.profile') ? 'bg-green-900' : '' }}">Profile</a>

                    <a href="{{ route('artisan.bookings') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('artisan.bookings') ? 'bg-green-900' : '' }}">My
                        Bookings</a>
                    <a href="{{ route('artisan.reviews') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('artisan.reviews') ? 'bg-green-900' : '' }}">Reviews</a>
                    <a href="{{ route('password.edit') }}"
                        class="block py-2 px-4 rounded hover:bg-green-800 {{ request()->routeIs('password.edit') ? 'bg-green-900' : '' }}">
                        Change Password</a>
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
                <div class="text-xl font-semibold">Artisan Dashboard</div>
                <div class="flex items-center space-x-4">
                    <span class="font-medium">Welcome, {{ Auth::user()->name }}</span>
                    {{-- <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 text-sm font-semibold text-green-700 bg-white rounded hover:bg-gray-100">
                            Logout
                        </button>
                    </form> --}}
                </div>
            </div>

            <!-- Actual page content -->
            <div class="max-w-5xl p-6 mx-auto">
                <!-- Profile Completion Alert -->
                @if (session('profile_incomplete'))
                    <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded"
                        role="alert">
                        <strong class="font-bold">Action Required!</strong>
                        <span class="block sm:inline">{{ session('profile_incomplete') }}</span>
                        <a href="{{ route('artisan.profile') }}"
                            class="font-semibold underline hover:text-red-900">Update Profile Now</a>
                        <button onclick="this.parentElement.style.display='none'"
                            class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="w-6 h-6 text-red-500 fill-current" role="button"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                            </svg>
                        </button>
                    </div>
                @endif
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
