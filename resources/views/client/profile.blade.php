@extends('layouts.client')

@section('title', 'My Profile')

@section('content')

    <!-- Client Profile Page -->
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

        <form action="{{ route('client.store') }}" id="profileForm" class="mt-10 max-w-4xl mx-auto" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- Avatar -->
            <div class="flex justify-center mt-6">
                <div class="relative">
                    <img id="avatarPreview"
                        src="{{ $user->client->avatar ? asset('storage/' . $user->client->avatar) : 'https://via.placeholder.com/100' }}"
                        alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-green-500">

                    <label
                        class="absolute bottom-0 right-0 bg-green-600 hover:bg-green-700 text-white text-xs px-2 py-1 rounded-full cursor-pointer">
                        Change
                        <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*" />
                    </label>
                </div>
            </div>



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <input type="text" name="number" value="{{ $user->number }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Hall of Residence -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Hall of Residence</label>
                    <input type="text" name="hall_of_residence" value="{{ $user->client->hall_of_residence ?? '' }}"
                        disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Department</label>
                    <input type="text" name="department" value="{{ $user->client->department ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Faculty -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Faculty</label>
                    <input type="text" name="faculty" value="{{ $user->client->faculty ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Matric Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Matric No</label>
                    <input type="text" name="matric_no" value="{{ $user->client->matric_no ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Room Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Room No</label>
                    <input type="text" name="room_number" value="{{ $user->client->room_number ?? '' }}" disabled
                        class="profile-input w-full border border-gray-300 rounded-lg px-4 py-2
               bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
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

    <!-- JavaScript Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editBtn = document.getElementById('editProfileBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const inputs = document.querySelectorAll('.profile-input');
            const actionButtons = document.getElementById('actionButtons');
            const form = document.getElementById('profileForm');

            // --- Toggle Edit Mode ---
            editBtn.addEventListener('click', () => {
                inputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('bg-gray-100');
                });
                actionButtons.classList.remove('hidden');
                editBtn.classList.add('hidden');
            });

            // --- Cancel Edit Mode ---
            cancelBtn.addEventListener('click', () => resetToViewMode());

            // --- Submit Form via AJAX ---
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!tokenMeta) {
                    showAlert('Missing CSRF token', 'error');
                    return;
                }

                try {
                    const response = await fetch("{{ route('client.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': tokenMeta.getAttribute('content'),
                        },
                        body: formData,
                    });

                    const text = await response.text();
                    let data;

                    try {
                        data = JSON.parse(text);
                    } catch {
                        throw new Error('Response is not JSON — maybe an HTML error page?');
                    }

                    if (data.success) {
                        showAlert('✅ Profile updated successfully!', 'success');
                        resetToViewMode(); // ✅ Auto-reset form after success
                    } else {
                        showAlert(data.message || '❌ Failed to update profile.', 'error');
                    }
                } catch (error) {
                    console.error(error);
                    showAlert('⚠️ Something went wrong. Please try again.', 'error');
                }
            });

            // --- Reset to View Mode ---
            function resetToViewMode() {
                inputs.forEach(input => {
                    input.disabled = true;
                    input.classList.add('bg-gray-100');
                });
                actionButtons.classList.add('hidden');
                editBtn.classList.remove('hidden');
            }

            // --- Alert Message ---
            function showAlert(message, type = 'success') {
                const alertBox = document.createElement('div');

                const colorClass = type === 'success' ?
                    'bg-green-600' :
                    'bg-red-600';

                // Start hidden & translated up for smooth entrance
                alertBox.className = `
    fixed top-6 right-6
    ${colorClass} text-white font-medium
    px-4 py-2 rounded shadow-lg z-50
    transform transition-all duration-500 ease-out
    opacity-0 translate-y-[-10px]
  `;
                alertBox.innerText = message;
                document.body.appendChild(alertBox);

                // Animate in
                setTimeout(() => {
                    alertBox.classList.remove('opacity-0', 'translate-y-[-10px]');
                    alertBox.classList.add('opacity-100', 'translate-y-0');
                }, 50);

                // Fade out & remove
                setTimeout(() => {
                    alertBox.classList.remove('opacity-100', 'translate-y-0');
                    alertBox.classList.add('opacity-0', 'translate-y-[-10px]');
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            }
        });

        // --- Avatar preview update ---
        document.getElementById('avatarInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>




@endsection
