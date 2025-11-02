@extends('layouts.client')

@section('title', 'Reviews')

@section('content')


<div class="max-w-3xl p-6 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">My Reviews</h2>
    @if ($reviews->isEmpty())
    <div class="py-16 text-center">
      <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png" alt="No Reviews" class="w-32 mx-auto mb-4 opacity-80">
      <p class="text-lg text-gray-600">You haven’t submitted any reviews yet.</p>
    </div>
  @else
    <div class="space-y-6">
      @foreach ($reviews as $review)
        <div class="p-5 bg-white border border-gray-100 shadow-sm rounded-2xl">
          <div class="flex items-center justify-between mb-2">
            <div>
              <h3 class="text-lg font-semibold text-gray-800"> Artisan name:
                {{ $review->artisan->user->name }}
              </h3>
              <p class="text-sm text-gray-500">Service: {{ $review->skill->name ?? 'Nil' }}</p>
            </div>
            <p class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
          </div>

          {{-- Star Rating --}}
          <div class="flex items-center mb-2 space-x-2">
            <span class="text-sm font-medium text-gray-700">{{ number_format($review->rating, 1) }}</span>
            <div class="flex items-center space-x-1">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $review->rating)
                        {{-- Filled Star --}}
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @else
                        {{-- Empty Star --}}
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endif
                @endfor
            </div>
        </div>


          <p class="leading-relaxed text-gray-700">{{ $review->review }}</p>
        </div>
      @endforeach
    </div>
  @endif

      </div>


@endsection
