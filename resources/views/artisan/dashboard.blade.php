@extends('layouts.artisan')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">

        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-green-600">👋 Hi, {{ Auth::user()->name ?? 'Artisan' }}!</h2>

            @php
                $artisan = Auth::user()->artisan;
                $monthsSinceJoined = Auth::user()->created_at->diffInMonths(now());
            @endphp

            <p class="text-sm text-gray-500 mt-2">
                @if ($monthsSinceJoined >= 6)
                    Lag-Artisan family since {{ Auth::user()->created_at->format('F Y') }}
                @else
                    Joined the Lag-Artisan family {{ Auth::user()->created_at->diffForHumans() }}
                @endif
            </p>

            @if ($artisan)
                <div class="mt-4">
                    <span
                        class="inline-block px-4 py-2 text-sm font-semibold rounded-full
                        @if ($artisan->tier === 'Elite') bg-purple-100 text-purple-700
                        @elseif($artisan->tier === 'Gold') bg-yellow-100 text-yellow-700
                        @elseif($artisan->tier === 'Silver') bg-gray-200 text-gray-700
                        @else bg-orange-100 text-orange-700 @endif">
                        @if ($artisan->tier === 'Elite')
                            👑
                        @elseif($artisan->tier === 'Gold')
                            🥇
                        @elseif($artisan->tier === 'Silver')
                            🥈
                        @else
                            🥉
                        @endif
                        Your Current Tier: {{ $artisan->tier }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Dashboard Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            <!-- Total Bookings Card -->
            <a href="{{ route('artisan.bookings') }}" class="block">
                <div class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Bookings</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $totalBookings }}</h3>
                    </div>
                </div>
            </a>

            <!-- Completed Jobs Card -->
            <a href="{{ route('artisan.bookings') }}" class="block">
                <div class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Completed Jobs</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $completedBookings }}</h3>
                    </div>
                </div>
            </a>

            <!-- Average Rating Card -->
            <a href="{{ route('artisan.reviews') }}" class="block">
                <div class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.905c.969 0 1.371 1.24.588 1.81l-3.97 2.88a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.97-2.88a1 1 0 00-1.176 0l-3.97 2.88c-.785.57-1.84-.196-1.54-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.88c-.783-.57-.38-1.81.588-1.81h4.905a1 1 0 00.95-.69l1.518-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Average Rating</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ number_format($averageRating, 1) }} ⭐</h3>
                    </div>
                </div>
            </a>

            <!-- Score Card -->
            <button type="button" onclick="openScoreModal()" class="w-full text-left">
                <div
                    class="bg-white shadow-md rounded-xl p-6 flex items-center space-x-4 hover:shadow-lg transition cursor-pointer">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm flex items-center">
                            Your Score
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ number_format($artisan->score ?? 0, 1) }}</h3>
                    </div>
                </div>
            </button>

        </div>

        <!-- Active Bookings Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4 flex items-center text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Active Bookings
            </h2>

            @if ($activeBookings->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No active bookings at the moment</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($activeBookings as $booking)
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $booking->client->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $booking->skill->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                                <span
                                    class="inline-block text-xs font-medium px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                    In Progress
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Reviews Section -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4 flex items-center text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.905c.969 0 1.371 1.24.588 1.81l-3.97 2.88a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.97-2.88a1 1 0 00-1.176 0l-3.97 2.88c-.785.57-1.84-.196-1.54-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.88c-.783-.57-.38-1.81.588-1.81h4.905a1 1 0 00.95-.69l1.518-4.674z" />
                </svg>
                Recent Reviews
            </h2>

            @if ($recentReviews->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No reviews yet</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($recentReviews as $review)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $review->client->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <span class="text-yellow-400">★</span>
                                        @else
                                            <span class="text-gray-300">★</span>
                                        @endif
                                    @endfor
                                    <span class="text-sm text-gray-600 ml-1">({{ $review->rating }})</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($review->review, 100) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <div class="mb-4 bg-white shadow-sm rounded-2xl" id="new-post-card">
    <div class="p-5 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">📸 Share a New Post</h3>
        <p class="mt-1 text-sm text-gray-500">Show off recent work or updates — visible to everyone on the feed.</p>
    </div>

    <form id="new-post-form" class="p-5" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div id="new-post-alert" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <div class="mb-4">
            <label for="new-post-title" class="block mb-1 text-sm font-medium text-gray-700">
                Title <span class="text-gray-400">(optional)</span>
            </label>
            <input type="text" id="new-post-title" name="title" maxlength="255"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="e.g. Custom wardrobe install">
        </div>

        <div class="mb-4">
            <label for="new-post-caption" class="block mb-1 text-sm font-medium text-gray-700">
                Caption <span class="text-gray-400">(optional)</span>
            </label>
            <textarea id="new-post-caption" name="caption" rows="3" maxlength="2000"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Say a bit about this work..."></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">
                Image <span class="text-red-500">*</span>
            </label>
            <label for="new-post-image"
                class="flex flex-col items-center justify-center w-full h-40 transition border-2 border-dashed rounded-lg cursor-pointer border-gray-300 hover:border-green-500"
                id="new-post-dropzone">
                <span id="new-post-dropzone-text" class="text-sm text-gray-500">Click to choose an image (max 5MB)</span>
                <img id="new-post-preview" src="" alt="" class="hidden object-contain w-full h-full p-2">
            </label>
            <input type="file" id="new-post-image" name="image" accept="image/*" class="hidden" required>
            <p id="new-post-image-error" class="hidden mt-1 text-sm text-red-600"></p>
        </div>

        <button type="submit" id="new-post-submit"
            class="inline-flex items-center justify-center w-full px-4 py-2 font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 disabled:opacity-60 disabled:cursor-not-allowed">
            <span id="new-post-submit-text">Post</span>
        </button>
    </form>
</div>

<div id="my-posts-feed" class="space-y-4">
    @forelse ($myPosts ?? [] as $post)
        <div class="overflow-hidden bg-white border shadow-sm rounded-2xl" id="post-{{ $post->id }}">
            <img src="{{ $post->image_url }}" class="object-cover w-full h-56" alt="{{ $post->title ?? 'Post image' }}">
            <div class="p-4">
                <div class="flex items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}" class="w-10 h-10 rounded-full">
                    <div class="ml-3">
                        <h4 class="font-semibold">{{ $post->user->name }}</h4>
                        <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @if ($post->title)
                    <h5 class="mb-2 font-semibold">{{ $post->title }}</h5>
                @endif
                @if ($post->caption)
                    <p class="mb-2 text-sm text-gray-600">{{ $post->caption }}</p>
                @endif
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span>❤️ {{ $post->likesCount() }}</span>
                    <span>💬 {{ $post->commentsCount() }}</span>
                </div>
            </div>
        </div>
    @empty
        <p id="my-posts-empty" class="py-6 text-sm text-center text-gray-400">
            You haven't shared any posts yet — your posts will show up here.
        </p>
    @endforelse
</div>

<script>
(function () {
    const form = document.getElementById('new-post-form');
    const imageInput = document.getElementById('new-post-image');
    const dropzoneText = document.getElementById('new-post-dropzone-text');
    const preview = document.getElementById('new-post-preview');
    const imageError = document.getElementById('new-post-image-error');
    const alertBox = document.getElementById('new-post-alert');
    const submitBtn = document.getElementById('new-post-submit');
    const submitText = document.getElementById('new-post-submit-text');
    const feed = document.getElementById('my-posts-feed');

    const MAX_BYTES = 5 * 1024 * 1024;

    function getCsrf() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.getAttribute('content');
        const input = form.querySelector('input[name="_token"]');
        return input ? input.value : '';
    }

    function showAlert(msg, type) {
        alertBox.textContent = msg;
        alertBox.className = 'mb-4 px-4 py-3 rounded-lg text-sm ' +
            (type === 'error' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700');
    }

    function setImageError(msg) {
        imageError.textContent = msg || '';
        imageError.classList.toggle('hidden', !msg);
    }

    function escape(str) {
        const d = document.createElement('div');
        d.textContent = str ?? '';
        return d.innerHTML;
    }

    imageInput.addEventListener('change', function () {
        const file = imageInput.files[0];
        setImageError(null);
        if (!file) { preview.classList.add('hidden'); dropzoneText.classList.remove('hidden'); return; }
        if (!file.type.startsWith('image/')) { setImageError('Please choose an image file.'); imageInput.value = ''; return; }
        if (file.size > MAX_BYTES) { setImageError('Image must be 5MB or smaller.'); imageInput.value = ''; return; }
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); dropzoneText.classList.add('hidden'); };
        reader.readAsDataURL(file);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        alertBox.classList.add('hidden');
        setImageError(null);
        if (!imageInput.files[0]) { setImageError('Please choose an image to post.'); return; }

        submitBtn.disabled = true;
        submitText.textContent = 'Posting…';

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' },
            body: new FormData(form),
        })
        .then(r => r.json().then(data => ({ ok: r.ok, status: r.status, data })))
        .then(({ ok, status, data }) => {
            if (ok && data.success) {
                const empty = document.getElementById('my-posts-empty');
                if (empty) empty.remove();
                const p = data.post;
                feed.insertAdjacentHTML('afterbegin', `
                    <div class="overflow-hidden bg-white border shadow-sm rounded-2xl" id="post-${p.id}">
                        <img src="${p.image_url}" class="object-cover w-full h-56" alt="${escape(p.title || 'Post image')}">
                        <div class="p-4">
                            <div class="flex items-center mb-3">
                                <img src="${p.user.avatar_url}" class="w-10 h-10 rounded-full">
                                <div class="ml-3">
                                    <h4 class="font-semibold">${escape(p.user.name)}</h4>
                                    <small class="text-gray-500">${escape(p.created_at_human)}</small>
                                </div>
                            </div>
                            ${p.title ? `<h5 class="mb-2 font-semibold">${escape(p.title)}</h5>` : ''}
                            ${p.caption ? `<p class="mb-2 text-sm text-gray-600">${escape(p.caption)}</p>` : ''}
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>❤️ 0</span><span>💬 0</span>
                            </div>
                        </div>
                    </div>`);
                showAlert('Post shared successfully.', 'success');
                form.reset();
                preview.classList.add('hidden'); preview.src = '';
                dropzoneText.classList.remove('hidden');
                return;
            }
            if (status === 422 && data.errors) {
                showAlert(Object.values(data.errors)[0][0], 'error'); return;
            }
            showAlert(data.message || 'Something went wrong.', 'error');
        })
        .catch(() => showAlert('Network error — please try again.', 'error'))
        .finally(() => { submitBtn.disabled = false; submitText.textContent = 'Post'; });
    });
})();
</script>

    <!-- Score Explanation Modal -->
    <div id="scoreModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Understanding Your Score</h3>
                    </div>
                    <button onclick="closeScoreModal()"
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-6">
                <!-- Current Score Display -->
                <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-6 text-center">
                    <p class="text-gray-600 text-sm mb-2">Your Current Score</p>
                    <h2 class="text-5xl font-bold text-purple-700">{{ number_format($artisan->score ?? 0, 1) }}</h2>
                    <p class="text-purple-600 font-semibold mt-2 text-lg">{{ $artisan->tier ?? 'Bronze' }} Tier</p>
                </div>

                <!-- How Score is Calculated -->
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        How Your Score is Calculated
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="bg-yellow-100 p-2 rounded-lg mt-1">
                                <span class="text-xl">⭐</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Average Rating × 20</p>
                                <p class="text-sm text-gray-600">Your average star rating multiplied by 20</p>
                                <p class="text-xs text-purple-600 font-medium mt-1">Example: 4.5 stars × 20 = 90 points</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 p-2 rounded-lg mt-1">
                                <span class="text-xl">📝</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Total Reviews × 2</p>
                                <p class="text-sm text-gray-600">Number of reviews you've received multiplied by 2</p>
                                <p class="text-xs text-purple-600 font-medium mt-1">Example: 15 reviews × 2 = 30 points</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <p class="text-sm font-semibold text-purple-800">Formula: (Average Rating × 20) + (Total Reviews ×
                            2)</p>
                    </div>
                </div>

                <!-- Tier System -->
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Tier Requirements
                    </h4>
                    <div class="space-y-3">
                        <!-- Elite -->
                        <div
                            class="flex items-center justify-between p-3 rounded-lg {{ $artisan->tier === 'Elite' ? 'bg-purple-100 border-2 border-purple-400' : 'bg-gray-50' }}">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">👑</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Elite</p>
                                    <p class="text-xs text-gray-600">Score ≥ 200 & Rating ≥ 4.8</p>
                                </div>
                            </div>
                            @if ($artisan->tier === 'Elite')
                                <span
                                    class="text-xs font-semibold text-purple-700 bg-purple-200 px-2 py-1 rounded-full">Current</span>
                            @endif
                        </div>

                        <!-- Gold -->
                        <div
                            class="flex items-center justify-between p-3 rounded-lg {{ $artisan->tier === 'Gold' ? 'bg-yellow-100 border-2 border-yellow-400' : 'bg-gray-50' }}">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">🥇</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Gold</p>
                                    <p class="text-xs text-gray-600">Score ≥ 150 & Rating ≥ 4.5</p>
                                </div>
                            </div>
                            @if ($artisan->tier === 'Gold')
                                <span
                                    class="text-xs font-semibold text-yellow-700 bg-yellow-200 px-2 py-1 rounded-full">Current</span>
                            @endif
                        </div>

                        <!-- Silver -->
                        <div
                            class="flex items-center justify-between p-3 rounded-lg {{ $artisan->tier === 'Silver' ? 'bg-gray-200 border-2 border-gray-400' : 'bg-gray-50' }}">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">🥈</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Silver</p>
                                    <p class="text-xs text-gray-600">Score ≥ 50 & Rating ≥ 4.0</p>
                                </div>
                            </div>
                            @if ($artisan->tier === 'Silver')
                                <span
                                    class="text-xs font-semibold text-gray-700 bg-gray-300 px-2 py-1 rounded-full">Current</span>
                            @endif
                        </div>

                        <!-- Bronze -->
                        <div
                            class="flex items-center justify-between p-3 rounded-lg {{ $artisan->tier === 'Bronze' ? 'bg-orange-100 border-2 border-orange-400' : 'bg-gray-50' }}">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">🥉</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Bronze</p>
                                    <p class="text-xs text-gray-600">Starting tier</p>
                                </div>
                            </div>
                            @if ($artisan->tier === 'Bronze')
                                <span
                                    class="text-xs font-semibold text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Current</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tips to Improve Score -->
                <div class="bg-gradient-to-br from-green-50 to-blue-50 border border-green-200 rounded-xl p-6">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        How to Increase Your Score
                    </h4>
                    <ul class="space-y-2">
                        <li class="flex items-start space-x-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <p class="text-sm text-gray-700"><strong>Deliver excellent service</strong> - Happy clients
                                leave better reviews</p>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <p class="text-sm text-gray-700"><strong>Complete more jobs</strong> - More completed bookings
                                = more review opportunities</p>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <p class="text-sm text-gray-700"><strong>Be professional & punctual</strong> - Reliability
                                earns higher ratings</p>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <p class="text-sm text-gray-700"><strong>Communicate clearly</strong> - Keep clients informed
                                throughout the job</p>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-600 mt-1">✓</span>
                            <p class="text-sm text-gray-700"><strong>Ask for reviews</strong> - Politely remind satisfied
                                clients to leave feedback</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 p-6 rounded-b-2xl">
                <button onclick="closeScoreModal()"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition">
                    Got it!
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openScoreModal() {
            document.getElementById('scoreModal').classList.remove('hidden');
            document.getElementById('scoreModal').classList.add('flex');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }

        function closeScoreModal() {
            document.getElementById('scoreModal').classList.add('hidden');
            document.getElementById('scoreModal').classList.remove('flex');
            document.body.style.overflow = 'auto'; // Restore scroll
        }

        // Close modal when clicking outside
        document.getElementById('scoreModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeScoreModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeScoreModal();
            }
        });
    </script>
@endsection
