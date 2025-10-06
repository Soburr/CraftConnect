@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <section class="flex items-center justify-center min-h-screen py-12 bg-white">
        <div class="flex w-full max-w-4xl overflow-hidden bg-white rounded-lg shadow-lg">

            <!-- Left side (image + overlay) -->
            <div class="relative items-center justify-center hidden w-1/2 text-white md:flex">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?fit=crop&w=600&q=80" alt="Background"
                    class="absolute inset-0 object-cover w-full h-full">
                <div class="absolute inset-0 bg-[#00ae02] opacity-70"></div>
            </div>

            <!-- Right side (form) -->
            <div class="w-full p-10 md:w-1/2">
                <h2 class="text-3xl font-bold text-[#00ae02] mb-8">
                   @if (isset($role) && $role === 'client')
                        Log in to Hire an Artisan
                   @elseif (isset($role) && $role === 'artisan')
                        Login to offer your skills
                   @else
                        Welcome back
                   @endif
                </h2>

                @if (@session('success'))
                    <div class="p-2 mb-4 text-green-700 bg-green-100 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-2 mb-4 text-red-700 bg-red-100 rounded">
                        <ul class="ml-5 list-disc">
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role ?? '' }}">

                    <input name="email" type="email" placeholder="Email Address" value="{{ old('email') }}"
                        class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2" required>

                    <!-- Password -->
                    <div class="relative">
                        <input id="password" name="password" type="password" placeholder="Password"
                            class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2 pr-10" required>
                        <i id="togglePassword" class="absolute text-gray-500 cursor-pointer fas fa-eye right-2 top-3"></i>
                    </div>

                    <!-- Save password -->
                    <div class="flex items-center">
                        <input id="terms" type="checkbox" class="mr-2">
                        <label for="terms" class="text-sm text-gray-600">
                            Save Password</a>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-[#00ae02] text-white py-2 rounded hover:bg-[#009402] transition">
                        Login
                    </button>

                    <!-- No Account -->
                    <p class="mt-4 text-sm text-center">
                        You do not have an account? <a href="{{ route('register') }}" class="text-green-600">Sign up →</a>
                    </p>
                </form>
            </div>
        </div>
    </section>

    <!-- Password toggle JS -->
    <script>
        function setupToggle(inputId, toggleId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);

            toggle.addEventListener('click', () => {
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                toggle.classList.toggle('fa-eye');
                toggle.classList.toggle('fa-eye-slash');
            });
        }

        setupToggle('password', 'togglePassword');
        setupToggle('repeatPassword', 'toggleRepeatPassword');
    </script>

@endsection
