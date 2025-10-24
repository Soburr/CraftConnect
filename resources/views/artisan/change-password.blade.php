@extends('layouts.artisan')

@section('title', 'Change Password')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-white px-4">
    <div class="max-w-md w-full bg-green-50 border border-green-400 rounded-lg p-8 shadow-lg">
        <h2 class="text-2xl font-semibold text-green-700 mb-6 text-center">Change Password</h2>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            {{-- Current Password --}}
            <div class="mb-4">
                <label for="current_password" class="block text-green-700 font-medium mb-1">Current Password</label>
                <input id="current_password" type="password" name="current_password" required
                    class="w-full px-3 py-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('current_password') border-red-500 @enderror"
                    autocomplete="current-password">

                @error('current_password')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-4">
                <label for="password" class="block text-green-700 font-medium mb-1">New Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-3 py-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror"
                    autocomplete="new-password">

                @error('password')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-green-700 font-medium mb-1">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-3 py-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    autocomplete="new-password">
            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded transition">
                Update Password
            </button>
        </form>
    </div>
</div>




@endsection
