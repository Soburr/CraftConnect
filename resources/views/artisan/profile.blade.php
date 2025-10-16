@extends('layouts.artisan')

@section('title', 'My Profile')

@section('content')
    <!-- Artisan Profile Page -->
    <div class="min-h-screen bg-white py-10 px-4 md:px-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">My Profile</h1>
                @php
                    $monthsSinceJoined = $user->created_at->diffInMonths(now());
                @endphp
                <p class="text-sm text-gray-500 mt-4">
                    @if ($monthsSinceJoined >= 6)
                        Lag-Artisan family since {{ $user->created_at->format('F Y') }}
                    @else
                        Joined the Lag-Artisan family {{ $user->created_at->diffForHumans() }}
                    @endif
                </p>
            </div>
            <div>
                <button id="editProfileBtn" type="button"
                    class="mt-3 md:mt-0 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Edit Profile
                </button>
            </div>
        </div>

        <!-- Form -->
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

        <form action="{{ route('artisan.store') }}" id="profileForm" class="mt-10 max-w-4xl mx-auto" method="POST"
            enctype="multipart/form-data">
            @csrf

            <!-- Avatar + Badge -->
            <div class="flex justify-center mt-6 relative">
                <div class="relative inline-block">
                    <img id="avatarPreview"
                        src="{{ $user->artisan->avatar ? asset('storage/' . $user->artisan->avatar) : 'https://via.placeholder.com/100' }}"
                        alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-green-500">

                    <label
                        class="absolute bottom-0 right-0 bg-green-600 hover:bg-green-700 text-white text-xs px-2 py-1 rounded-full cursor-pointer">
                        Change
                        <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*" />
                    </label>

                    <!-- Badge -->
                    @php
                        $rank = $user->artisan->rank ?? 'bronze';
                        $badgeColors = [
                            'bronze' => 'bg-amber-700 text-white',
                            'silver' => 'bg-gray-500 text-white',
                            'gold' => 'bg-yellow-500 text-white',
                            'elite' => 'bg-green-700 text-white',
                        ];

                        $badgeIcons = [
                            'bronze' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4 mr-1 inline text-white"><circle cx="12" cy="8" r="5"/><path d="M10 14v7l2-1 2 1v-7z"/></svg>',
                            'silver' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4 mr-1 inline text-white"><circle cx="12" cy="8" r="5"/><path d="M10 14v7l2-1 2 1v-7z"/></svg>',
                            'gold' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4 mr-1 inline text-white"><path d="M7 3h10v2h2a2 2 0 0 1 2 2v2a5 5 0 0 1-5 5h-1.1a5 5 0 0 1-9.8 0H4a5 5 0 0 1-5-5V7a2 2 0 0 1 2-2h2V3zm10 4v2a3 3 0 0 0 3 3h1V7h-4zM3 7v5h1a3 3 0 0 0 3-3V7H3zM8 21v-2h8v2H8z"/></svg>',
                            'elite' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4 mr-1 inline text-white"><path d="M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/></svg>',
                        ];
                    @endphp

                    <span
                        class="absolute -top-2 -right-2 text-xs font-semibold px-2 py-1 rounded-full shadow flex items-center {{ $badgeColors[$rank] ?? 'bg-amber-700 text-white' }}">
                        {!! $badgeIcons[$rank] !!} {{ ucfirst($rank) }}
                    </span>



                </div>
            </div>


            <!-- Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <input type="text" name="number" value="{{ $user->number }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Hall of Residence -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Hall of Residence</label>
                    <input type="text" name="hall_of_residence" value="{{ $user->artisan->hall_of_residence ?? '' }}"
                        disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Room Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Room No</label>
                    <input type="text" name="room_number" value="{{ $user->artisan->room_number ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Department</label>
                    <input type="text" name="department" value="{{ $user->artisan->department ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Faculty -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Faculty</label>
                    <input type="text" name="faculty" value="{{ $user->artisan->faculty ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Matric Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Matric No</label>
                    <input type="text" name="matric_no" value="{{ $user->artisan->matric_no ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Years Of Experience -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Years Of Experience</label>
                    <input type="number" name="years_of_experience"
                        value="{{ $user->artisan->years_of_experience ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

            </div>

            <!-- Skills Section -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skills</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Skill Category -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Category</label>
                        <select name="category_id" id="categorySelect" disabled
                            class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ isset($user->artisan->category_id) && $user->artisan->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Skill -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Skill</label>
                        <select name="skill_id" id="skillSelect" disabled
                            class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500">
                            <option value="">-- Select Skill --</option>

                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}" data-category-id="{{ $skill->category_id ?? '' }}"
                                    {{ isset($user->artisan->skill_id) && $user->artisan->skill_id == $skill->id ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach

                            <option value="others"
                                {{ isset($user->artisan->skill_id) && $user->artisan->skill_id === 'others' ? 'selected' : '' }}>
                                Others</option>
                        </select>

                        <!-- Custom Skill Input -->
                        <input type="text" id="customSkillInput" name="custom_skill" placeholder="Enter your skill"
                            class="mt-3 hidden w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 profile-input"
                            disabled>
                    </div>

                </div>
            </div>

            <!-- Bio -->
            <div class="mt-6">
                <label class="block text-gray-700 font-medium mb-2">Bio</label>
                <textarea rows="4" name="bio" disabled
                    class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">{{ $user->artisan->bio ?? '' }}</textarea>
            </div>

            <!-- Save/Cancel Buttons -->
            <div id="actionButtons" class="mt-8 text-center hidden">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-200">
                    Save Profile
                </button>
                <button type="button" id="cancelBtn"
                    class="ml-3 border border-green-600 text-green-600 px-6 py-2 rounded-md hover:bg-green-50 transition duration-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editBtn = document.getElementById('editProfileBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const inputs = document.querySelectorAll('.profile-input');
            const actionButtons = document.getElementById('actionButtons');
            const form = document.getElementById('profileForm');

            const categorySelect = document.getElementById('categorySelect');
            const skillSelect = document.getElementById('skillSelect');
            const customSkillInput = document.getElementById('customSkillInput');

            function filterSkillsByCategory() {
                const selectedCategory = categorySelect ? categorySelect.value : '';
                let selectedStillVisible = false;

                Array.from(skillSelect.options).forEach(opt => {
                    if (opt.value === '' || opt.value === 'others') {
                        opt.hidden = false;
                        opt.disabled = false;
                        return;
                    }

                    const optCat = opt.dataset.categoryId ?? '';

                    if (!selectedCategory || selectedCategory === '') {
                        opt.hidden = false;
                        opt.disabled = false;
                    } else {
                        if (String(optCat) === String(selectedCategory)) {
                            opt.hidden = false;
                            opt.disabled = false;
                        } else {
                            opt.hidden = true;
                            opt.disabled = true;
                        }
                    }

                    if (!opt.hidden && opt.selected) selectedStillVisible = true;
                });

                if (!selectedStillVisible) {
                    skillSelect.value = '';
                    customSkillInput.classList.add('hidden');
                    customSkillInput.disabled = true;
                }
            }

            skillSelect.addEventListener('change', () => {
                if (skillSelect.value === 'others') {
                    customSkillInput.classList.remove('hidden');
                    customSkillInput.disabled = false;
                } else {
                    customSkillInput.classList.add('hidden');
                    customSkillInput.disabled = true;
                }
            });

            if (categorySelect) {
                categorySelect.addEventListener('change', () => {
                    filterSkillsByCategory();
                });
            }

            editBtn.addEventListener('click', () => {
                inputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('bg-gray-100');
                });
                actionButtons.classList.remove('hidden');
                editBtn.classList.add('hidden');
                filterSkillsByCategory();
            });

            cancelBtn.addEventListener('click', () => resetToViewMode());

            function resetToViewMode() {
                inputs.forEach(input => {
                    input.disabled = true;
                    input.classList.add('bg-gray-100');
                });
                actionButtons.classList.add('hidden');
                editBtn.classList.remove('hidden');
                customSkillInput.classList.add('hidden');
                customSkillInput.disabled = true;
            }

            filterSkillsByCategory();
        });
    </script>

@endsection
