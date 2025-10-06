

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #e9f8ec;">
  <div class="container-fluid">
    <!-- Logo as image -->
    <a class="navbar-brand" href="#">
      <img src="{{ asset('Images/logo.png')}}" alt="Logo" width="40" height="40" class="align-text-top d-inline-block">
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <!-- Links -->
        <ul class="mx-auto mb-2 navbar-nav mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>

        <!-- Mobile Button -->
        <div class="mt-3 text-left d-lg-none">
            <a href="#" class="btn btn-success">Get Started</a>
        </div>
      </div>
    </div>

    <!-- Desktop Button -->
    <div class="d-none d-lg-block">
      <a href="#" class="btn btn-success">Get Started</a>
    </div>
  </div>
</nav>

