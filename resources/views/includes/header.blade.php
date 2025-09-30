<nav class="navbar navbar-expand-lg shadow-sm py-2"><!--  bg-white -->
  <div class="container d-flex align-items-center justify-content-between">
    
    <!-- Logo -->
    {{-- <a class="navbar-brand fw-bold me-auto" href="/">
      Dare to Dream <br>
      <small class="text-muted">Modelling Agency</small>
    </a> --}}
    <a class="navbar-brand fw-bold me-auto d-flex align-items-center" href="/">
      <!-- Logo -->
      <img src="{{ asset('ddmodelslogo.png') }}" 
          alt="Dare to Dream" 
          style="height: 50px; width: auto; margin-right: 5px;">

      <!-- Name + Subtitle -->
      <div class="d-flex flex-column">
        <span style="font-size: 18px">Dare to Dream </span>
        <small class="text-muted">Modelling Agency</small>
      </div>
    </a>

    <!-- Authenticated User Menu -->
    @auth
    <!-- Desktop Navigation Links (Visible only on desktop) -->
    <div class="collapse navbar-collapse d-none d-lg-block">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/about-us">About us</a></li>
        <li class="nav-item"><a class="nav-link" href="/models">Models</a></li>
        <li class="nav-item"><a class="nav-link" href="/testimonials">Testimonials</a></li>
        <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
        {{-- <li class="nav-item"><a class="nav-link" href="/how-it-works">How it Works</a></li> --}}
        <li class="nav-item"><a class="nav-link" href="/modelling-advice">Advice</a></li>
        <li class="nav-item"><a class="nav-link" href="/contact-us">Contact Us</a></li>
      </ul>
    </div>
    @endauth

    <!-- Hamburger -->
    @auth
      <!-- For logged-in users, show sidebar toggle -->
      <button class="navbar-toggler border-0 bg-transparent shadow-none ms-3" type="button" id="sidebarToggle">
        <span class="d-flex flex-column justify-content-between" style="width: 22px; height: 16px;">
          <span class="bg-dark" style="height: 2px; border-radius: 1px;"></span>
          <span class="bg-dark" style="height: 2px; border-radius: 1px;"></span>
          <span class="bg-dark" style="height: 2px; border-radius: 1px;"></span>
        </span>
      </button>
    @else
      <!-- For guests, show standard navbar toggle -->
      <button class="navbar-toggler border-0 bg-transparent shadow-none ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="d-flex flex-column justify-content-between" style="width: 22px; height: 16px;">
          <span class="bg-dark" style="height: 2px; border-radius: 1px;"></span>
          <span class="bg-dark" style="height: 2px; border-radius: 1px;"></span>
          <span class="bg-dark" style="height: 2px; border-radius: 1px;"></span>
        </span>
      </button>
    @endauth

    <!-- Guest Menu -->
    @guest
    <div class="collapse navbar-collapse align-items-center justify-content-center" id="mainNavbar">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/about-us">About us</a></li>
        <li class="nav-item"><a class="nav-link" href="/models">Models</a></li>
        <li class="nav-item"><a class="nav-link" href="/testimonials">Testimonials</a></li>
        <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
        {{-- <li class="nav-item"><a class="nav-link" href="/how-it-works">How it Works</a></li> --}}
        <li class="nav-item"><a class="nav-link" href="/modelling-advice">Advice</a></li>
        <li class="nav-item"><a class="nav-link" href="/contact-us">Contact Us</a></li>
      </ul>

      <!-- Right Section -->
      <div class="d-flex gap-2 align-items-center">
        <a href="{{ route('login') }}" class="btn btn-login">Log in</a>
        <a href="{{ route('register') }}" class="btn btn-signup">Sign up</a>
      </div>
    </div>
    @endguest

    <!-- Authenticated User Menu -->
    @auth
    <div class="d-flex align-items-center ms-3">
      <!-- User Name (hidden on mobile) -->
      <span class="me-3 d-none d-md-block fw-semibold">
        {{ Auth::user()->name }}
      </span>

      <!-- Profile Dropdown -->
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none"
           id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ $publicInfo && $publicInfo->profile_picture 
                        ? asset('storage/'.$publicInfo->profile_picture) 
                        : asset('images/default-profile.png') }}" 
            alt="Profile Picture"
            class="rounded-circle object-fit-cover border"
            width="40"
            height="40">
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow" style="width: max-content" aria-labelledby="userDropdown">
          <li class="px-3 py-2">
            <div class="d-flex align-items-center">
                <img src="{{ $publicInfo && $publicInfo->profile_picture 
                            ? asset('storage/'.$publicInfo->profile_picture) 
                            : asset('images/default-profile.png') }}" 
                alt="Profile Picture"
                class="rounded-circle object-fit-cover border"
                width="40"
                height="40">
              <div>
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{ Auth::user()->user_type }}</small>
              </div>
            </div>
          </li>

          <li><hr class="dropdown-divider"></li>
          @if(auth()->check() && auth()->user()->is_admin == 1)
            <li>
              <a href="{{ url('/console') }}" class="dropdown-item text-primary">
                 <i class="bx bx-broadcast me-2"></i>{{ __('Admin Console') }}</a>
              </a>
            </li>
          @endif
          <li><a class="dropdown-item" href="/profile"><i class="bx bx-user me-2"></i> My Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="bx bx-cog me-2"></i> Settings</a></li>

          <li><hr class="dropdown-divider"></li>

          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="bx bx-power-off me-2"></i> Log Out
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
    @endauth
  </div>
</nav>
