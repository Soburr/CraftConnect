@extends('layouts.client')

@section('title', 'Reviews')

@section('content')


<div class="max-w-3xl p-6 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">My Reviews</h2>

    <!-- No Reviews State -->
    <div class="hidden py-16 text-center" id="noReviews">
      <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png" alt="No Reviews" class="w-32 mx-auto mb-4 opacity-80">
      <p class="text-lg text-gray-600">You haven’t submitted any reviews yet.</p>
    </div>

    <!-- Reviews List -->
    <div class="space-y-6" id="reviewsList">
      <!-- Single Review Card -->
      <div class="p-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
        <div class="flex items-center justify-between mb-2">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">John Doe (Electrician)</h3>
            <p class="text-sm text-gray-500">Service: Ceiling Fan Installation</p>
          </div>
          <p class="text-sm text-gray-400">2 days ago</p>
        </div>

        <!-- Star Rating -->
        <div class="flex items-center mb-2 space-x-1">
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.785.57-1.84-.197-1.54-1.118l1.286-3.955a1 1 0 00-.364-1.118L2.47 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.955z"/>
          </svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <span class="ml-2 text-sm text-gray-600">4.0</span>
        </div>

        <p class="leading-relaxed text-gray-700">
          Great work! He was on time, very professional, and even helped fix a few extra things without charge. Highly recommend.
        </p>
      </div>

      <!-- Another Review Card -->
      <div class="p-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
        <div class="flex items-center justify-between mb-2">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">Jane Smith (Plumber)</h3>
            <p class="text-sm text-gray-500">Service: Pipe Leakage Fix</p>
          </div>
          <p class="text-sm text-gray-400">1 week ago</p>
        </div>

        <!-- Star Rating -->
        <div class="flex items-center mb-2 space-x-1">
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927..."/></svg>
          <span class="ml-2 text-sm text-gray-600">3.0</span>
        </div>

        <p class="leading-relaxed text-gray-700">
          The job was completed but took longer than expected. Communication could be better.
        </p>
      </div>
    </div>
  </div>


@endsection
