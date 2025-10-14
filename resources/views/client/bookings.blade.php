@extends('layouts.client')

@section('title', 'My Bookings')

@section('content')

<!-- MY BOOKINGS PAGE -->
<div class="min-h-screen px-4 py-10 bg-white md:px-10">
    <!-- Header -->
    <div class="mb-8 text-center">
      <h1 class="text-2xl font-semibold text-gray-800 md:text-3xl">My Bookings</h1>
      <p class="mt-2 text-sm text-gray-500 md:text-base">View and manage artisans you’ve contacted</p>
    </div>

    <!-- Bookings Container -->
    <div class="max-w-5xl mx-auto space-y-5" id="bookingsContainer">
      <!-- Booking Card -->
      <div class="flex flex-col justify-between p-5 bg-white border border-green-200 shadow-sm booking-card rounded-xl md:flex-row md:items-center" data-status="in-progress">
        <div class="flex items-center space-x-4">
          <img src="https://via.placeholder.com/70" class="object-cover w-16 h-16 border-2 border-green-500 rounded-full" alt="Artisan">
          <div>
            <h3 class="font-semibold text-gray-800">Mary the Tailor</h3>
            <p class="text-sm text-gray-500">Tailoring • Madam Tinubu Hall</p>
            <span class="status-badge inline-block mt-1 text-xs font-medium text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">In Progress</span>
          </div>
        </div>

        <div class="flex flex-wrap gap-3 mt-4 md:mt-0">
          <button class="chat-btn bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm transition">Chat on WhatsApp</button>
          <button class="complete-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-1.5 rounded-md text-sm transition">Mark as Complete</button>
          <button class="cancel-btn bg-red-100 hover:bg-red-200 text-red-700 px-4 py-1.5 rounded-md text-sm transition">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div id="noBookings" class="hidden mt-20 text-center text-gray-500">
      <p class="text-lg">No bookings yet</p>
      <p class="mt-1 text-sm text-gray-400">Start by finding artisans to hire on campus.</p>
      <a href="/client/find-artisans" class="inline-block px-5 py-2 mt-3 text-sm text-white transition bg-green-600 rounded-md hover:bg-green-700">Find Artisans</a>
    </div>
  </div>

  <!-- REVIEW MODAL -->
  <div id="reviewModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-40">
    <div class="w-11/12 p-6 bg-white shadow-lg rounded-xl md:w-1/3">
      <h3 class="mb-4 text-lg font-semibold text-center text-gray-800">Leave a Review</h3>

      <!-- Star Rating -->
      <div id="starRating" class="flex justify-center mb-4 space-x-2">
        <svg class="w-8 h-8 text-gray-300 cursor-pointer star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.383 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.921-.755 1.688-1.54 1.118l-3.383-2.46a1 1 0 00-1.176 0l-3.383 2.46c-.785.57-1.84-.197-1.54-1.118l1.287-3.967a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
        <svg class="w-8 h-8 text-gray-300 cursor-pointer star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.383 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.921-.755 1.688-1.54 1.118l-3.383-2.46a1 1 0 00-1.176 0l-3.383 2.46c-.785.57-1.84-.197-1.54-1.118l1.287-3.967a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
        <svg class="w-8 h-8 text-gray-300 cursor-pointer star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.383 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.921-.755 1.688-1.54 1.118l-3.383-2.46a1 1 0 00-1.176 0l-3.383 2.46c-.785.57-1.84-.197-1.54-1.118l1.287-3.967a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
        <svg class="w-8 h-8 text-gray-300 cursor-pointer star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.383 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.921-.755 1.688-1.54 1.118l-3.383-2.46a1 1 0 00-1.176 0l-3.383 2.46c-.785.57-1.84-.197-1.54-1.118l1.287-3.967a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
        <svg class="w-8 h-8 text-gray-300 cursor-pointer star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.383 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.921-.755 1.688-1.54 1.118l-3.383-2.46a1 1 0 00-1.176 0l-3.383 2.46c-.785.57-1.84-.197-1.54-1.118l1.287-3.967a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
      </div>

      <!-- Review Text -->
      <textarea id="reviewText" rows="4" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Share your experience..."></textarea>

      <div class="flex justify-end gap-3">
        <button id="closeReviewModal" class="px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100">Cancel</button>
        <button id="submitReview" class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">Submit</button>
      </div>
    </div>
  </div>

  <!-- JS Logic -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const bookings = document.querySelectorAll('.booking-card');
    const reviewModal = document.getElementById('reviewModal');
    const closeReviewModal = document.getElementById('closeReviewModal');
    const submitReview = document.getElementById('submitReview');
    const stars = document.querySelectorAll('.star');
    let currentBooking = null;
    let selectedRating = 0;

    // ⭐ STAR RATING LOGIC
    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        selectedRating = index + 1;
        updateStars();
      });
      star.addEventListener('mouseover', () => highlightStars(index + 1));
      star.addEventListener('mouseleave', updateStars);
    });

    function highlightStars(rating) {
      stars.forEach((s, i) => {
        s.classList.toggle('text-yellow-400', i < rating);
        s.classList.toggle('text-gray-300', i >= rating);
      });
    }

    function updateStars() {
      stars.forEach((s, i) => {
        s.classList.toggle('text-yellow-400', i < selectedRating);
        s.classList.toggle('text-gray-300', i >= selectedRating);
      });
    }

    // BOOKING LOGIC
    bookings.forEach(card => {
      const statusBadge = card.querySelector('.status-badge');
      const completeBtn = card.querySelector('.complete-btn');
      const cancelBtn = card.querySelector('.cancel-btn');
      const chatBtn = card.querySelector('.chat-btn');

      completeBtn?.addEventListener('click', () => {
        statusBadge.textContent = 'Completed';
        statusBadge.className = 'status-badge inline-block mt-1 text-xs font-medium text-green-700 bg-green-100 px-2 py-0.5 rounded-full';
        card.dataset.status = 'completed';
        completeBtn.remove();
        cancelBtn.remove();

        const reviewBtn = document.createElement('button');
        reviewBtn.textContent = 'Leave Review';
        reviewBtn.className = 'review-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-1.5 rounded-md text-sm';
        reviewBtn.addEventListener('click', () => openReviewModal(card));
        card.querySelector('.flex.gap-3')?.appendChild(reviewBtn);
      });

      cancelBtn?.addEventListener('click', () => {
        statusBadge.textContent = 'Cancelled';
        statusBadge.className = 'status-badge inline-block mt-1 text-xs font-medium text-red-700 bg-red-100 px-2 py-0.5 rounded-full';
        card.dataset.status = 'cancelled';
        cancelBtn.remove();
        completeBtn.remove();

        const rebookBtn = document.createElement('button');
        rebookBtn.textContent = 'Rebook';
        rebookBtn.className = 'rebook-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-1.5 rounded-md text-sm';
        rebookBtn.addEventListener('click', () => {
          statusBadge.textContent = 'In Progress';
          statusBadge.className = 'status-badge inline-block mt-1 text-xs font-medium text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full';
          card.dataset.status = 'in-progress';
          rebookBtn.remove();

          const newComplete = document.createElement('button');
          newComplete.textContent = 'Mark as Complete';
          newComplete.className = 'complete-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-1.5 rounded-md text-sm';
          newComplete.addEventListener('click', () => completeBtn.click());

          const newCancel = document.createElement('button');
          newCancel.textContent = 'Cancel';
          newCancel.className = 'cancel-btn bg-red-100 hover:bg-red-200 text-red-700 px-4 py-1.5 rounded-md text-sm';
          newCancel.addEventListener('click', () => cancelBtn.click());

          card.querySelector('.flex.gap-3')?.append(newComplete, newCancel);
        });
        card.querySelector('.flex.gap-3')?.appendChild(rebookBtn);
      });

      chatBtn?.addEventListener('click', () => {
        window.open('https://wa.me/2348012345678', '_blank');
      });
    });

    // REVIEW MODAL HANDLING
    function openReviewModal(card) {
      currentBooking = card;
      reviewModal.classList.remove('hidden');
    }

    closeReviewModal.addEventListener('click', () => {
      reviewModal.classList.add('hidden');
    });

    submitReview.addEventListener('click', () => {
      const text = document.getElementById('reviewText').value.trim();
      if (!selectedRating) {
        alert('Please select a star rating.');
        return;
      }
      if (text) {
        alert(`Review submitted successfully! Rating: ${selectedRating} stars`);
        document.getElementById('reviewText').value = '';
        selectedRating = 0;
        updateStars();
        reviewModal.classList.add('hidden');

        if (currentBooking) {
          const reviewBtn = currentBooking.querySelector('.review-btn');
          reviewBtn.textContent = 'Reviewed ✅';
          reviewBtn.disabled = true;
          reviewBtn.classList.add('opacity-60', 'cursor-not-allowed');
        }
      } else {
        alert('Please write a review before submitting.');
      }
    });
  });
  </script>

@endsection
