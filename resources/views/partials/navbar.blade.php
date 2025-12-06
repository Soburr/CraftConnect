<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #e9f8ec;">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('Images/logo.png') }}" alt="Logo" width="140" height="140"
                class="align-text-top d-inline-block">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas Sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <!-- Links -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#popular-services') }}">Popular Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.artisan') }}">Find Artisans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.create') }}">Contact</a>
                    </li>
                </ul>

                <!-- Mobile Button -->
                <div class="mt-3 text-left d-lg-none">
                    <a href="javascript:void(0)" class="btn btn-success"
                        onclick="
                        const oc = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasNavbar'));
                        if (oc) oc.hide();

                        document.getElementById('testimonialModal').classList.remove('hidden')">
                        Leave a Testimonial
                    </a>
                </div>

            </div>
        </div>

        <!-- Desktop Button -->
        <div class="d-none d-lg-block">
            <a href="javascript:void(0)" class="btn btn-success"
                onclick="document.getElementById('testimonialModal').classList.remove('hidden')">
                Leave a Testimonial
            </a>
        </div>

    </div>
</nav>


<div id="testimonialModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    style="z-index: 9999;">
    <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg relative">


        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Share Your Experience</h2>

            <button onclick="document.getElementById('testimonialModal').classList.add('hidden')"
                class="text-gray-500 hover:text-red-500 text-xl">
                &times;
            </button>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/testimonials">
            @csrf

            <label class="block mb-2 text-sm font-medium text-gray-700">Your Name</label>
            <input type="text" name="name"
                class="w-full border border-gray-300 rounded-md p-3 focus:ring-green-500 focus:border-green-500"
                placeholder="Enter your name" required>

            <label class="block mb-2 mt-4 text-sm font-medium text-gray-700">Your Testimonial</label>

            <textarea id="testimonialMessage" name="message" rows="4" maxlength="500"
                class="w-full border border-gray-300 rounded-md p-3 focus:ring-green-500 focus:border-green-500"
                placeholder="Write something (max 500 characters)" required></textarea>

            <p id="charCount" class="text-right text-sm text-gray-500 mt-1">0 / 500</p>

            <button type="submit"
                class="mt-4 w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold">
                Submit Testimonial
            </button>
        </form>
    </div>
</div>

<!-- Character Counter Script -->
<script>
    const textarea = document.getElementById('testimonialMessage');
    const counter = document.getElementById('charCount');

    textarea.addEventListener('input', function() {
        counter.textContent = `${this.value.length} / 500`;
    });
</script>
