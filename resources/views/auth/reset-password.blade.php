@extends('layouts.app')

@section('title', 'Reset Password')

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
                <h2 class="text-3xl font-bold text-[#00ae02] mb-8">Reset Password</h2>
                <p class="mb-8 text-sm text-gray-600">
                    Enter your new password below.
                </p>

                @if ($errors->any())
                    <div class="p-2 mb-4 text-red-700 bg-red-100 rounded">
                        <ul class="ml-5 list-disc">
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.reset.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <input name="email" type="email" value="{{ old('email', $email) }}" placeholder="Email Address"
                        class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2" required readonly>

                    <!-- Password -->
                    <div class="relative">
                        <input id="password" name="password" type="password" placeholder="New Password"
                            class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2 pr-10" required>
                        <i id="togglePassword" class="absolute text-gray-500 cursor-pointer fas fa-eye right-2 top-3"></i>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password"
                            class="w-full border-b border-gray-300 focus:border-[#00ae02] outline-none py-2 pr-10" required>
                        <i id="togglePasswordConfirm" class="absolute text-gray-500 cursor-pointer fas fa-eye right-2 top-3"></i>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-[#00ae02] text-white py-2 rounded hover:bg-[#009402] transition">
                        Reset Password
                    </button>
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
        setupToggle('password_confirmation', 'togglePasswordConfirm');
    </script>

@endsection
