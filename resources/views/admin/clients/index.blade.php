@extends('layouts.admin')

@section('title', 'Clients')

@section('content')

<div class="p-8 space-y-6">
    <h1 class="text-2xl font-bold mb-6">All Clients</h1>

    <!-- Search Form -->
    <form method="GET" class="mb-6 flex items-center space-x-2">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search clients..."
               class="border rounded px-3 py-2 w-1/3">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Search</button>
    </form>

    <!-- Clients Table -->
    <div class="bg-white border border-green-100 rounded-xl shadow-sm p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-green-100 text-green-800 text-sm uppercase">
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Joined</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr class="border-b hover:bg-green-50 transition">
                    <td class="p-2">{{ $client->name }}</td>
                    <td class="p-2 text-gray-600">{{ $client->email }}</td>
                    <td class="p-2 capitalize">
                        <span class="px-2 py-1 rounded {{ $client->status == 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $client->status ?? 'active' }}
                        </span>
                    </td>
                    <td class="p-2">{{ $client->created_at->format('M d, Y') }}</td>
                    <td class="p-2 flex space-x-2">
                        <!-- View -->
                        <a href="{{ route('admin.clients.show', $client->id) }}" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded">View</a>

                        <!-- Delete -->
                        <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No clients found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $clients->links('vendor.pagination.tailwind-green') }}
        </div>
    </div>
</div>

@endsection
