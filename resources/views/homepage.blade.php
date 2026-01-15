@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

    <section class="pt-25" style="background-color: #e9f8ec; padding-top: calc(4rem + 56px);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h1 style="font-size: 30px; font-family: 'Poppins', sans-serif;" class="mb-4 fw-bold">Connect With An
                        Artisan Today!</h1>
                    <p class="mb-5 lead">
                        Discover, Book and work with Skilled UNILAG Student-Artisans Right on Campus — Quick, Reliable and affordable.
                    </p>

                    <div class="flex-wrap gap-3 d-flex">
                        <div>
                            @if (auth()->user())
                              @php
                                  $dashboardRoute = auth()->user()->role === 'artisan' ? route('artisan.dashboard') : route('client.dashboard');
                              @endphp
                                <a href="{{ $dashboardRoute }}" class="px-4 button btn btn-success btn-lg">
                                    <span class="py-1 px-3.5 inline-block text-[16px] md:text-[22px]">Dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('login', ['role' => 'client']) }}"
                                    class="px-4 btn btn-success btn-lg">Hire an artisan</a>
                                <a href="{{ route('login', ['role' => 'artisan']) }}"
                                    class="px-4 btn btn-outline-success btn-lg">Offer your skills</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 col-md-5 d-flex justify-content-center justify-content-md-end mt-md-0 ">
                    <img src="{{ asset('Images/pic.png') }}" alt="artisans"
                        style="max-width: 90%; max-height: 380px; height: auto; ">
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-16 text-center text-green-600 bg-white">
        <h2 class="mb-12 text-2xl font-semibold md:text-3xl">
            How it works
        </h2>

        <div class="flex flex-col items-center justify-center gap-10 md:flex-row md:items-start md:gap-16">
            <!-- Step 1 -->
            <div class="max-w-xs mx-auto">
                <div
                    class="flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white bg-green-600 rounded-full w-14 h-14">
                    1
                </div>
                <p>
                    <span class="font-semibold">Browse Services</span><br>
                    Explore UNILAG student-artisans offering skills across categories — from repairs and fashion to tech and
                    tutoring.
                </p>
            </div>

            <!-- Curved Arrow -->
            <div class="flex items-center justify-center rotate-90 md:rotate-0" aria-hidden="true">
                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c10 0 18 6 24 16l-4-2m4 2l-4 2" />
                </svg>
            </div>

            <!-- Step 2 -->
            <div class="max-w-xs mx-auto">
                <div
                    class="flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white bg-green-600 rounded-full w-14 h-14">
                    2
                </div>
                <p>
                    <span class="font-semibold">Book an Artisan</span><br>
                    Choose the artisan that fits your need, check their availability, and send a booking request.
                </p>
            </div>

            <!-- Curved Arrow -->
            <div class="flex items-center justify-center rotate-90 md:rotate-0" aria-hidden="true">
                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c10 0 18 6 24 16l-4-2m4 2l-4 2" />
                </svg>
            </div>

            <!-- Step 3 -->
            <div class="max-w-xs mx-auto">
                <div
                    class="flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white bg-green-600 rounded-full w-14 h-14">
                    3
                </div>
                <p>
                    <span class="font-semibold">Agree & Get it Done</span><br>
                    Chat with the artisan via a secured channel, agree on payment, and get the service delivered.
                </p>
            </div>
        </div>
    </section>


    <!-- Popular Services -->
    <section id="popular-services" class="py-12 bg-green-600">
        <div class="px-4 mx-auto max-w-7xl">
            <h2 class="mb-8 text-3xl font-bold text-center text-white">Popular Services</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <!-- Service Card -->
                <div
                    class="flex flex-col p-4 transition-all transform bg-white shadow rounded-2xl hover:shadow-lg hover:scale-105">
                    <img src="{{ asset('Images/service1.jpg') }}" alt="Plumber"
                        class="object-cover w-full h-48 rounded-lg">
                    <div class="flex flex-col flex-grow mt-4">
                        <h3 class="text-lg font-bold">Carpentry works</h3>
                        {{-- <p class="font-semibold text-gray-700">₦2,000</p> --}}
                        <a href="{{ route('client.artisan') }}"
                            class="w-full py-2 mt-auto font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 block text-center">Book
                            Now</a>
                    </div>
                </div>

                <!-- Service Card -->
                <div
                    class="flex flex-col p-4 transition-all transform bg-white shadow rounded-2xl hover:shadow-lg hover:scale-105">
                    <img src="{{ asset('Images/service2.jpg') }}" alt="Hairdresser"
                        class="object-cover w-full h-48 rounded-lg">
                    <div class="flex flex-col flex-grow mt-4">
                        <h3 class="text-lg font-bold">Gadgets repair</h3>
                        {{-- <p class="font-semibold text-gray-700">₦2,000</p> --}}
                        <a href="{{ route('client.artisan') }}"
                            class="w-full py-2 mt-auto font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 block text-center">Book
                            Now</a>
                    </div>
                </div>

                <!-- Service Card -->
                <div
                    class="flex flex-col p-4 transition-all transform bg-white shadow rounded-2xl hover:shadow-lg hover:scale-105">
                    <img src="{{ asset('Images/service3.jpg') }}" alt="Plumber"
                        class="object-cover w-full h-48 rounded-lg">
                    <div class="flex flex-col flex-grow mt-4">
                        <h3 class="text-lg font-bold">Hair styling</h3>
                        {{-- <p class="font-semibold text-gray-700">₦2,000</p> --}}
                        <a href="{{ route('client.artisan') }}"
                            class="w-full py-2 mt-auto font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 block text-center">Book
                            Now</a>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- Testimonials -->
    <section class="py-12 bg-white">
        <div class="px-4 mx-auto max-w-7xl">
            <h2 class="mb-8 text-3xl font-bold text-center">What Our Clients Are Saying</h2>

            <div class="relative overflow-hidden">
                <div id="testimonial-track" class="flex transition-transform duration-700">

                    <!-- Testimonial -->
                    @forelse ($testimonials as $testimonial)
                    <div class="min-w-full px-6">
                        <div class="p-6 text-center bg-green-100 shadow rounded-xl">
                            <p class="italic text-gray-700">"{{ $testimonial->message }}"</p>
                            <div class="mt-4 font-semibold">{{ $testimonial->name }}</div>
                              <div class="text-sm text-gray-500">{{ $testimonial->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="min-w-full px-6">
                        <div class="p-6 text-center bg-green-100 shadow rounded-xl">
                            <p class="italic text-gray-700">"Such a great platform, connecting with an artisan was so easy"</p>
                            <div class="mt-4 font-semibold">Oladele Elizabeth</div>
                            <div class="text-sm text-gray-500">faculty of engineering</div>
                              <div class="text-sm text-gray-500">Nov 12, 2025</div>
                        </div>
                    </div>

                    <div class="min-w-full px-6">
                        <div class="p-6 text-center bg-green-100 shadow rounded-xl">
                            <p class="italic text-gray-700">"Easy to use"</p>
                            <div class="mt-4 font-semibold">Anifowoshe Precious</div>
                            <div class="text-sm text-gray-500">faculty of science</div>
                              <div class="text-sm text-gray-500">Nov 21, 2025</div>
                        </div>
                    </div>

                    <div class="min-w-full px-6">
                        <div class="p-6 text-center bg-green-100 shadow rounded-xl">
                            <p class="italic text-gray-700">"It took an artisan less than 5 minutes to reach out. This is very cool."</p>
                            <div class="mt-4 font-semibold">Williams</div>
                            <div class="text-sm text-gray-500">faculty of arts</div>
                              <div class="text-sm text-gray-500">Nov 22, 2025</div>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Dots -->
                <div class="flex justify-center mt-4 space-x-2">
                    <span class="w-3 h-3 bg-gray-300 rounded-full cursor-pointer dot"></span>
                    <span class="w-3 h-3 bg-gray-300 rounded-full cursor-pointer dot"></span>
                    <span class="w-3 h-3 bg-gray-300 rounded-full cursor-pointer dot"></span>
                </div>
            </div>
        </div>
    </section>

    <script>
        const track = document.getElementById("testimonial-track");
        const dots = document.querySelectorAll(".dot");
        let index = 0;
        let interval;

        function showSlide(i) {
            index = i;
            track.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((dot, j) => {
                dot.classList.toggle("bg-green-600", j === index);
                dot.classList.toggle("bg-gray-300", j !== index);
            });
        }

        function startSlider() {
            interval = setInterval(() => {
                showSlide((index + 1) % dots.length);
            }, 4000);
        }

        dots.forEach((dot, i) => {
            dot.addEventListener("click", () => {
                clearInterval(interval);
                showSlide(i);
                startSlider();
            });
        });

        // Auto start
        showSlide(0);
        startSlider();
    </script>


@endsection
