@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <section class="flex items-center justify-center min-h-screen py-12 bg-white">
        <div class="flex w-full max-w-4xl overflow-hidden bg-white rounded-lg shadow-lg">

            <!-- Left side (image + overlay) -->
            <div class="relative items-center justify-center hidden w-1/2 text-white md:flex">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?fit=crop&w=600&q=80" alt="Background"
                    class="absolute inset-0 object-cover w-full h-full">
                <div class="absolute inset-0 bg-[#00ae02] opacity-70"></div>
                <div class="relative z-10 px-6 text-center">
                    <h2 class="mb-2 text-3xl font-bold">Join Us</h2>
                    <p class="text-lg">Create an account and explore amazing opportunities!</p>
                </div>
            </div>

            <!-- Right side (form) -->
            <div class="w-full p-10 md:w-1/2">
                <h2 class="text-3xl font-bold text-[#00ae02] mb-8">Sign Up</h2>

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
                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf

                    <input type="text" placeholder="Full Name" name="name"
                        class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2" value="{{ old('name') }}" required>

                    <input type="email" placeholder="Email Address" name="email"
                        class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2" value="{{ old('email') }}" required>

                    <input type="number" placeholder="Phone Number" name="number"
                        class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2" value="{{ old('number') }}" required>

                    <div>
                        <select name="role" id="role"
                        class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2" required>
                        <option value="" disabled hidden>Register As</option>
                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="artisan" {{ old('role') == 'artisan' ? 'selected' : '' }}>Artisan</option>
                    </select>

                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input id="password" type="password" placeholder="Password" name="password"
                            class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2 pr-10">
                        <i id="togglePassword" class="absolute text-gray-500 cursor-pointer fas fa-eye right-2 top-3"></i>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <input id="repeatPassword" type="password" placeholder="Confirm Password"
                            name="password_confirmation"
                            class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2 pr-10">
                        <i id="toggleRepeatPassword"
                            class="absolute text-gray-500 cursor-pointer fas fa-eye right-2 top-3"></i>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-center">
                        <input id="terms" type="checkbox" class="mr-2">
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-green-600">Terms of Use</a>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-[#00ae02] text-white py-2 rounded hover:bg-[#009402] transition">
                        Sign Up
                    </button>

                    <!-- Already registered -->
                    <p class="mt-4 text-sm text-center">
                        Already have an account? <a href="{{ route('login') }}" class="text-green-600">Sign in →</a>
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
