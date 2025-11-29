@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<section class="bg-green-50 py-16">
   <div class="max-w-4xl mx-auto px-6">

      <h2 class="text-3xl font-bold text-center text-green-700 mb-10">
        Contact Us
      </h2>

      <div class="bg-white shadow-lg rounded-xl p-8">
         @if (session('success'))
             <div class="mb-4 p-3 bg-gray-100 text-green-800 rounded">
                {{ session('success') }}
             </div>
         @endif

         <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" 
                           class="w-full border rounded-lg p-3 focus:ring-green-500 focus:border-green-500"
                           placeholder="Enter first name" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" 
                           class="w-full border rounded-lg p-3 focus:ring-green-500 focus:border-green-500"
                           placeholder="Enter last name" required>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" 
                       class="w-full border rounded-lg p-3 focus:ring-green-500 focus:border-green-500"
                       placeholder="example@gmail.com" required>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Message</label>
                <textarea name="message" rows="5"
                       class="w-full border rounded-lg p-3 focus:ring-green-500 focus:border-green-500"
                       placeholder="Write Your Message...." required></textarea>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg">
                    Send Message
                </button>
            </div>
         </form>
      </div>
   </div>
</section>

@endsection