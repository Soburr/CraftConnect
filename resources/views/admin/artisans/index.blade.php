@extends('layouts.admin')

@section('title', 'Artisans')

@section('content')

<div class="p-8">
    <h1 class="text-2xl font-bold mb-6">All Artisans</h1>

    <form method="GET" class="mb-4">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search artisans..."
               class="border rounded px-3 py-2 w-1/3">
        <button class="bg-green-600 text-white px-4 py-2 rounded">Search</button>
    </form>

    <table class="min-w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Skill</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($artisans as $artisan)
            <tr class="border-t">
                <td class="p-3">{{ $artisan->name }}</td>
                <td class="p-3">{{ $artisan->email }}</td>
                <td class="p-3">{{ $artisan->artisan->skill->name ?? 'N/A' }}</td>
                <td class="p-3 capitalize">{{ $artisan->status }}</td>
                <td class="p-3 text-center">
                    <a href="{{ route('admin.artisans.show', $artisan->id) }}" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="p-3 text-center text-gray-500">No artisans found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $artisans->links() }}</div>
</div>

@endsection
