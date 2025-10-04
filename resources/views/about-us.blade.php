@extends('layouts.frontend')

@section('content')
<div class="container">
  {{-- HERO SECTION --}}
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <h1 class="display-4 fw-bold">About Dare to Dream</h1>
      <p class="lead text-muted">We dare to challenge boundaries, empower youth, and create opportunities in the world of fashion and entertainment.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="{{ asset('about-hero.png') }}" alt="About Dare to Dream" class="img-fluid rounded shadow-sm" style="max-height:340px; object-fit:cover; width:100%;">
    </div>
  </div>

  {{-- OUR PROFILE SECTION --}}
  <div class="row mb-5">
    <div class="col-12">
      <h2 class="fw-bold mb-3">Our Profile</h2>
      <p class="text-muted">
        Dare to Dream Modelling Agency is a talent management company focused on rising above and beyond, pushing boundaries and challenging norms. We aim to help the youth kickstart their modelling careers, fueling their passion and guiding them towards fulfilling their dreams.
      </p>
      <p class="text-muted">
        In this industry, we envision a world where entertainment blossoms inclusively. From artists and brands to musicians, comedians, companies, hotels, and lounges — we believe models are at the heart of it all. Dare to Dream helps market these platforms through talented models, because we believe the entertainment world revolves around them.
      </p>
    </div>
  </div>

  {{-- FOR MODELS & FOR CLIENTS SECTION --}}
  <div class="row text-center mb-5">
    <div class="col-md-6 mb-4">
      <div class="p-4 border rounded h-100">
        <h3 class="fw-bold mb-3">For Models</h3>
        <p class="text-muted">Whether you are starting out or ready for international exposure, Dare to Dream provides mentorship, portfolio building, training, and opportunities to shine on runways and campaigns worldwide.</p>
        <a href="{{ route('register') }}" class="btn btn-primary">Join Us</a>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="p-4 border rounded h-100">
        <h3 class="fw-bold mb-3">For Clients</h3>
        <p class="text-muted">Looking for fresh faces or professional talent for your brand? We connect you with diverse models who embody originality and professionalism for campaigns, events, and productions.</p>
        <a href="{{ route('contact-us') }}" class="btn btn-outline-secondary">Work With Us</a>
      </div>
    </div>
  </div>

  {{-- OUR VALUES SECTION --}}
  <div class="row mb-5">
    <div class="col-md-12">
      <h2 class="fw-bold mb-3">Our Values</h2>
      <div class="row">
        <div class="col-md-6">
          <ul class="list-unstyled">
            <li class="mb-3"><strong>Inclusivity:</strong> All genders, sizes, and backgrounds have a place here.</li>
            <li class="mb-3"><strong>Authenticity:</strong> We embrace uniqueness as the true definition of beauty.</li>
            <li class="mb-3"><strong>Professionalism:</strong> Ethical practices, transparency, and fairness in every contract.</li>
          </ul>
        </div>
        <div class="col-md-6">
          <ul class="list-unstyled">
            <li class="mb-3"><strong>Growth:</strong> Continuous training and development for rising talent.</li>
            <li class="mb-3"><strong>Integrity:</strong> Respect and honesty in all our partnerships and collaborations.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

    {{-- TEAM SECTION --}}
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">Meet the Team</h2>
            <p class="text-muted">The passionate people behind Dare to Dream Modelling Agency.</p>
        </div>


        <div class="col-md-3 col-6 mb-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <img src="{{ asset('team-placeholder.jpg') }}" class="card-img-top rounded" alt="Team Member" style="height:280px; object-fit:cover;">
                <div class="card-body">
                    <h6 class="fw-bold mb-0">Member Name</h6>
                    <p class="text-muted small">Role</p>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-6 mb-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <img src="{{ asset('team-placeholder.jpg') }}" class="card-img-top rounded" alt="Team Member" style="height:280px; object-fit:cover;">
                <div class="card-body">
                    <h6 class="fw-bold mb-0">Member Name</h6>
                    <p class="text-muted small">Role</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6 mb-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <img src="{{ asset('team-placeholder.jpg') }}" class="card-img-top rounded" alt="Team Member" style="height:280px; object-fit:cover;">
                <div class="card-body">
                    <h6 class="fw-bold mb-0">Member Name</h6>
                    <p class="text-muted small">Role</p>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-6 mb-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <img src="{{ asset('team-placeholder.jpg') }}" class="card-img-top rounded" alt="Team Member" style="height:280px; object-fit:cover;">
                <div class="card-body">
                    <h6 class="fw-bold mb-0">Member Name</h6>
                    <p class="text-muted small">Role</p>
                </div>
            </div>
        </div>
    </div>

  {{-- WHY CHOOSE US SECTION --}}
  <div class="row py-5 bg-light rounded">
    <div class="col-md-8">
      <h2 class="fw-bold mb-3">Why Choose Us?</h2>
      <ul class="text-muted">
        <li>Locally rooted with global ambitions.</li>
        <li>A trusted network across fashion, entertainment, and advertising.</li>
        <li>Safe, fair, and supportive environment for models and clients alike.</li>
      </ul>
    </div>
    <div class="col-md-4 d-flex align-items-center justify-content-md-end">
      <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Apply to Become a Model</a>
    </div>
  </div>
</div>
@endsection