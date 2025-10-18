@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')


    <!-- FIND ARTISANS PAGE -->
    <div class="min-h-screen bg-white px-4 md:px-10 py-10">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">Find Trusted Artisans</h1>
            <p class="text-gray-500 text-sm md:text-base mt-2">Discover skilled students right on campus.</p>
        </div>

        <!-- Search + Filters -->
        <div class="bg-white shadow-md rounded-xl border border-green-200 p-6 max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center gap-3">
                <input type="text" id="search-skill" placeholder="Search skill or artisan name..."
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                <button id="search-btn"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-200">
                    Search
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 text-sm mb-1">Location</label>
                    <select id="filter-location"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Locations</option>
                        @foreach ($locations as $hall)
                            <option value="{{ $hall }}" {{ $location == $hall ? 'selected' : '' }}>
                                {{ $hall }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm mb-1">Category</label>
                    <select id="filter-category"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}"
                                {{ request('category') == $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-center mt-6">
                <p class="text-gray-600 text-sm">
                    Didn’t find the skill you’re looking for?
                    <button id="openRequestModal" class="text-green-600 font-medium underline hover:text-green-700">
                        Request a new skill
                    </button>
                </p>
            </div>
        </div>

        <!-- Search Results -->
        <div id="results" class="max-w-5xl mx-auto mt-10">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Search Results</h2>
            <div id="results-list" class="space-y-4">
                @if ($artisans->isEmpty())
                    <p class="text-center text-gray-500">Start by searching a skill...</p>
                @else
                    @foreach ($artisans as $artisan)
                        <div
                            class="border border-gray-200 rounded-xl shadow-sm p-4 flex flex-col md:flex-row items-start md:items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $artisan->avatar ? asset('storage/' . $artisan->avatar) : 'https://via.placeholder.com/60' }}"
                                    alt="{{ $artisan->user->name }}"
                                    class="w-16 h-16 rounded-full border-2 border-green-500">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $artisan->user->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $artisan->skill->name ?? 'N/A' }} •
                                        {{ $artisan->hall_of_residence ?? 'N/A' }}</p>
                                    <p class="text-yellow-500 text-sm">⭐ {{ number_format($artisan->rating ?? 0, 1) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex gap-3">
                                <button
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm">View
                                    Profile</button>
                                <button
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-md text-sm">Book
                                    Now</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>



        <!-- Recommended Artisans -->
        <div class="max-w-5xl mx-auto mt-14">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recommended Artisans</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white border border-green-100 rounded-xl shadow-sm p-4 text-center">
                    <img src="https://via.placeholder.com/80" class="mx-auto rounded-full border-2 border-green-500 mb-3">
                    <h3 class="font-medium text-gray-800">Sam the Barber</h3>
                    <p class="text-gray-500 text-sm">Salon • Eni-Njoku Hall</p>
                    <button class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm">Book
                        Now</button>
                </div>
                <div class="bg-white border border-green-100 rounded-xl shadow-sm p-4 text-center">
                    <img src="https://via.placeholder.com/80" class="mx-auto rounded-full border-2 border-green-500 mb-3">
                    <h3 class="font-medium text-gray-800">Ada the Cleaner</h3>
                    <p class="text-gray-500 text-sm">Cleaning • Moremi Hall</p>
                    <button class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm">Book
                        Now</button>
                </div>
                <div class="bg-white border border-green-100 rounded-xl shadow-sm p-4 text-center">
                    <img src="https://via.placeholder.com/80" class="mx-auto rounded-full border-2 border-green-500 mb-3">
                    <h3 class="font-medium text-gray-800">John the Electrician</h3>
                    <p class="text-gray-500 text-sm">Repairs • El-Kanemi Hall</p>
                    <button class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm">Book
                        Now</button>
                </div>
            </div>
        </div>

        <!-- Request Skill Modal -->
        <div id="requestModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl shadow-lg p-6 w-11/12 md:w-1/3">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Request a New Skill</h3>
                <input type="text" id="requestedSkill" placeholder="Enter skill name..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500" />
                <div class="flex justify-end gap-3">
                    <button id="closeRequestModal"
                        class="px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button id="submitRequest"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('requestModal');
        const openBtn = document.getElementById('openRequestModal');
        const closeBtn = document.getElementById('closeRequestModal');
        const submitBtn = document.getElementById('submitRequest');
        const skillInput = document.getElementById('requestedSkill');
        const searchBtn = document.getElementById('search-btn');
        const searchInput = document.getElementById('search-skill');
        const resultsList = document.getElementById('results-list');
    
        // ======= MODAL HANDLERS =======
        openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    
        // ======= REQUEST NEW SKILL =======
        submitBtn.addEventListener('click', async () => {
            const requestedSkill = skillInput.value.trim();
            if (!requestedSkill) {
                alert('Please enter a skill name.');
                return;
            }
    
            try {
                // You can later connect this to a backend route (e.g., client.add.skill)
                alert(`Skill "${requestedSkill}" requested successfully!`);
                skillInput.value = '';
                modal.classList.add('hidden');
            } catch (error) {
                alert('Error submitting skill request.');
            }
        });
    
        // ======= SEARCH FUNCTION =======
        searchBtn.addEventListener('click', () => {
            const query = new URLSearchParams({
                search: searchInput.value,
                location: document.getElementById('filter-location').value,
                category: document.getElementById('filter-category').value
            });
            window.location = `{{ route('client.artisan') }}?${query.toString()}`;
        });
    
        // Trigger search on pressing Enter
        searchInput.addEventListener('keypress', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchBtn.click();
            }
        });
    </script>
    


@endsection
