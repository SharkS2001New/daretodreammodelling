<nav class="navbar navbar-expand-lg shadow-sm site-navbar">
  @php
    $navLinkClass = function (...$patterns) {
        foreach ($patterns as $pattern) {
            if (request()->is($pattern)) {
                return 'active';
            }
        }

        return '';
    };
  @endphp
  <div class="container-fluid site-header__inner">

    <a class="navbar-brand d-flex align-items-center flex-shrink-0" href="/">
      <img src="{{ asset('ddmodelslogo.png') }}"
           alt="Dare to Dream"
           class="site-navbar__logo">
      <div class="d-flex flex-column">
        <span class="site-navbar__title">Dare to Dream</span>
        <small class="text-muted">Modelling Agency</small>
      </div>
    </a>

    @auth
      <button class="navbar-toggler d-lg-none border-0 bg-transparent shadow-none ms-auto" type="button" id="sidebarToggle" aria-label="Open menu">
        <span class="d-flex flex-column justify-content-between site-navbar__toggler-icon">
          <span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span>
        </span>
      </button>
    @else
      <button class="navbar-toggler d-lg-none border-0 bg-transparent shadow-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Open menu">
        <span class="d-flex flex-column justify-content-between site-navbar__toggler-icon">
          <span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span>
        </span>
      </button>
    @endauth

    @auth
      <div class="collapse navbar-collapse d-none d-lg-flex flex-lg-grow-1" id="mainNavbar">
    @else
      <div class="collapse navbar-collapse flex-lg-grow-1" id="mainNavbar">
    @endauth
        <ul class="navbar-nav site-nav mx-lg-auto">
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('/') }}" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('about-us', 'about-us/*') }}" href="/about-us">About us</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('upcoming-activities', 'upcoming-activities/*') }}" href="{{ route('upcoming-activities') }}">Activities</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('models', 'models/*', 'model/*') }}" href="/models">Models</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('testimonials', 'testimonials/*') }}" href="/testimonials">Testimonials</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('blog', 'blog/*') }}" href="/blog">Blog</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('modelling-advice', 'modelling-advice/*') }}" href="/modelling-advice">Advice</a></li>
          <li class="nav-item"><a class="nav-link {{ $navLinkClass('contact-us', 'contact-us/*') }}" href="/contact-us">Contact Us</a></li>
        </ul>

        @guest
          <div class="d-flex gap-2 align-items-center justify-content-center w-100 pt-3 d-lg-none">
            <a href="{{ route('login') }}" class="btn btn-login flex-fill">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-signup flex-fill">Sign up</a>
          </div>
        @endguest
      </div>

    <div class="site-nav-actions d-flex align-items-center gap-2 flex-shrink-0">
      @include('includes.theme-toggle')

      @guest
        <a href="{{ route('login') }}" class="btn btn-login d-none d-lg-inline-block">Log in</a>
        <a href="{{ route('register') }}" class="btn btn-signup d-none d-lg-inline-block">Sign up</a>
      @else
        <span class="d-none d-md-block fw-semibold site-nav-actions__name">
          {{ Auth::user()->name }}
        </span>

        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-decoration-none"
             id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ $authPublicInfo && $authPublicInfo->profile_picture
                          ? asset('storage/'.$authPublicInfo->profile_picture)
                          : asset('images/default-profile.png') }}"
              alt="Profile Picture"
              class="rounded-circle object-fit-cover border"
              width="40"
              height="40">
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow" style="width: max-content" aria-labelledby="userDropdown">
            <li class="px-3 py-2">
              <div class="d-flex align-items-center">
                  <img src="{{ $authPublicInfo && $authPublicInfo->profile_picture
                              ? asset('storage/'.$authPublicInfo->profile_picture)
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
            @else
              <li>
                <a href="{{ url('/dashboard') }}" class="dropdown-item text-primary">
                   <i class="bx bx-broadcast me-2"></i>{{ __('My Modelling Dashboard') }}</a>
                </a>
              </li>
            @endif
            <li><a class="dropdown-item" href="/account"><i class="bx bx-user me-2"></i> My Profile</a></li>
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
      @endguest
    </div>
  </div>
</nav>
