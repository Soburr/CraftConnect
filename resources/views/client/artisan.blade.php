@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
<div class="min-h-screen px-4 py-10 bg-white md:px-10">

    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-semibold text-gray-800 md:text-3xl">Find Trusted Artisans</h1>
        <p class="mt-2 text-sm text-gray-500 md:text-base">Discover skilled students right on campus.</p>
    </div>

    <!-- Search + Filters -->
    <div class="max-w-4xl p-6 mx-auto bg-white border border-green-200 shadow-md rounded-xl">
        <form method="GET" action="{{ route('client.artisan') }}" class="flex flex-col gap-3 md:flex-row md:items-center">
            <input
                type="text"
                name="search"
                id="search-skill"
                placeholder="Search skill or artisan name..."
                value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            />
            <button
                type="submit"
                id="search-btn"
                class="px-6 py-2 text-white transition duration-200 bg-green-600 rounded-md hover:bg-green-700">
                Search
            </button>
        </form>

        <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
            <div>
                <label class="block mb-1 text-sm text-gray-700">Location</label>
                <select name="location" id="filter-location"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Locations</option>
                    @foreach ($locations as $hall)
                        <option value="{{ $hall }}" {{ $location == $hall ? 'selected' : '' }}>
                            {{ $hall }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm text-gray-700">Category</label>
                <select name="category" id="filter-category"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div id="results" class="max-w-5xl mx-auto mt-10">
        <h2 class="mb-4 text-lg font-semibold text-gray-800">Search Results</h2>
        <div id="results-list" class="space-y-4">
            @forelse ($artisans as $artisan)
                <div
                    class="flex flex-col items-start justify-between p-4 border border-gray-200 shadow-sm rounded-xl md:flex-row md:items-center">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $artisan->avatar ? asset('storage/' . $artisan->avatar) : 'https://via.placeholder.com/60' }}"
                            alt="{{ $artisan->user->name }}"
                            class="w-16 h-16 border-2 border-green-500 rounded-full">
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $artisan->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $artisan->skill->name ?? 'N/A' }} •
                                {{ $artisan->hall_of_residence ?? 'N/A' }}</p>
                            <p class="text-sm text-yellow-500">⭐ {{ number_format($artisan->rating ?? 0, 1) }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-4 md:mt-0">
                        <button
                            class="view-profile-btn bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm"
                            data-name="{{ $artisan->user->name }}"
                            data-skill="{{ $artisan->skill->name ?? 'N/A' }}"
                            data-phone="{{ $artisan->user->number ?? 'N/A' }}"
                            data-email="{{ $artisan->user->email }}"
                            data-hall="{{ $artisan->hall_of_residence ?? 'N/A' }}"
                            data-avatar="{{ $artisan->avatar ? asset('storage/' . $artisan->avatar) : 'https://via.placeholder.com/150' }}"
                            data-rating="{{ number_format($artisan->rating ?? 0, 1) }}">
                            View Profile
                        </button>
                        <form method="POST" action="{{ route('client.book-artisan', $artisan->user->id) }}">
                            @csrf
                            <input type="hidden" name="skill_id" value="{{ $artisan->skill_id }}">
                            <button type="submit"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-md text-sm">
                                Book Now
                            </button>
                        </form>

                    </div>
                </div>
                @empty
                @if (request()->filled('search') || request()->filled('category') || request()->filled('location'))
                    <div class="py-16 text-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png"
                             alt="No Results"
                             class="w-32 mx-auto mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">No artisans found</h3>
                        <p class="mt-2 text-gray-500">Didn’t find the skill you’re looking for?</p>
                        <button id="openRequestModal"
                            class="mt-1 font-medium text-green-600 underline hover:text-green-700">
                            Request a new skill
                        </button>
                    </div>
                @else
                    <div class="py-20 text-center text-gray-500">
                        <h3 class="mb-2 text-xl font-semibold text-gray-800">Search for an artisan</h3>
                        <p class="text-sm text-gray-500">Start by typing a skill or name above.</p>
                    </div>
                @endif
            @endforelse

        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-40">
        <div class="relative w-11/12 p-6 bg-white shadow-lg rounded-xl md:w-1/3">
            <button id="closeProfileModal"
                class="absolute text-xl text-gray-600 top-3 right-3 hover:text-gray-900">&times;</button>

            <div class="text-center">
                <img id="modal-avatar" src="https://via.placeholder.com/120"
                    class="w-24 h-24 mx-auto mb-4 border-4 border-green-500 rounded-full">
                <h3 id="modal-name" class="text-xl font-semibold text-gray-800">Name</h3>
                <p id="modal-skill" class="mt-1 font-medium text-green-600">Skill</p>

                <div class="mt-4 space-y-1 text-sm text-gray-600">
                    <p>Phone: <span id="modal-phone">N/A</span></p>
                    <p>Email: <span id="modal-email">N/A</span></p>
                    <p>Hall of Residence: <span id="modal-hall">N/A</span></p>
                    <p>Rating: ⭐ <span id="modal-rating">0.0</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Skill Modal -->
    <div id="requestModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-40">
        <div class="w-11/12 p-6 bg-white shadow-lg rounded-xl md:w-1/3">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Request a New Skill</h3>

            <input type="text" id="requestedSkill" placeholder="Enter skill name..."
                class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />

            <select id="requestedCategory"
                class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <div class="flex justify-end gap-3">
                <button id="closeRequestModal"
                    class="px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">Cancel</button>
                <button id="submitRequest"
                    class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">Submit</button>
            </div>
        </div>
    </div>

</div>

<script>
    // Profile Modal Logic
    const modal = document.getElementById('profileModal');
    const closeModal = document.getElementById('closeProfileModal');

    document.querySelectorAll('.view-profile-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('modal-name').textContent = btn.dataset.name;
            document.getElementById('modal-skill').textContent = btn.dataset.skill;
            document.getElementById('modal-phone').textContent = btn.dataset.phone;
            document.getElementById('modal-email').textContent = btn.dataset.email;
            document.getElementById('modal-hall').textContent = btn.dataset.hall;
            document.getElementById('modal-rating').textContent = btn.dataset.rating;
            document.getElementById('modal-avatar').src = btn.dataset.avatar;
            modal.classList.remove('hidden');
        });
    });

    closeModal.addEventListener('click', () => modal.classList.add('hidden'));

    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    });

    // Request Skill Modal Logic
    const requestModal = document.getElementById('requestModal');
    const openRequestModal = document.getElementById('openRequestModal');
    const closeRequestModal = document.getElementById('closeRequestModal');
    const submitRequest = document.getElementById('submitRequest');

    if (openRequestModal) {
        openRequestModal.addEventListener('click', () => requestModal.classList.remove('hidden'));
    }

    closeRequestModal.addEventListener('click', () => requestModal.classList.add('hidden'));

    window.addEventListener('click', (e) => {
        if (e.target === requestModal) requestModal.classList.add('hidden');
    });

    submitRequest.addEventListener('click', () => {
        const skillName = document.getElementById('requestedSkill').value.trim();
        const category = document.getElementById('requestedCategory').value;

        if (!skillName) {
            alert('Please enter a skill name.');
            return;
        }

        if (!category) {
            alert('Please select a category before submitting.');
            return;
        }

        alert(`Skill "${skillName}" requested under category ID "${category}" ✅`);
        requestModal.classList.add('hidden');
        document.getElementById('requestedSkill').value = '';
        document.getElementById('requestedCategory').value = '';
    });
</script>
@endsection
