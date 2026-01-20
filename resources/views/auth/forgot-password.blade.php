@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

    <section class="flex items-center justify-center min-h-screen py-12 bg-white">
        <div class="w-full max-w-md p-10 bg-white rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-[#00ae02] mb-4">Forgot Password?</h2>
            <p class="mb-8 text-sm text-gray-600">
                No worries! Enter your email address and we'll send you a link to reset your password.
            </p>

            @if (session('status'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                    <ul class="ml-5 list-disc">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
                    <input name="email" type="email" placeholder="Enter your email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:border-[#00ae02] focus:ring-2 focus:ring-[#00ae02] focus:ring-opacity-50 outline-none" required>
                </div>

                <button type="submit"
                    class="w-full bg-[#00ae02] text-white py-3 rounded hover:bg-[#009402] transition font-medium">
                    Send Reset Link
                </button>

                <p class="mt-4 text-sm text-center">
                    Remember your password? <a href="{{ route('login') }}" class="text-[#00ae02] hover:underline">Back to Login</a>
                </p>
            </form>
        </div>
    </section>

@endsection