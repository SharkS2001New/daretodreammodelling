@extends('layouts.frontend')

@section('content')
<div class="container pb-5">
    {{-- Hero --}}
    <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6">
            <x-page-heading :centered="false" class="mb-3" />
            <p class="text-muted mb-0">
                We are a Nairobi-based talent management agency helping aspiring models develop, shine, and succeed —
                while connecting brands with professional, diverse talent.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="about-hero-frame">
                <img src="{{ asset('about-hero.png') }}"
                    alt="Dare to Dream models team"
                    class="about-hero-image">
            </div>
        </div>
    </div>

    {{-- Our Profile --}}
    <section class="about-profile-panel mb-5">
        <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">Who we are</p>
        <h2 class="section-heading fw-bold mb-3">Our Profile</h2>
        <p class="text-muted mb-3">
            DD Models Agency is a talent management agency dedicated to creating opportunities for aspiring models
            and building meaningful connections between talent and brands.
        </p>
        <p class="about-tagline mb-0 fw-medium">
            DD Models Agency – Dare To Dream. Develop. Shine. Succeed. ✨
        </p>
    </section>

    {{-- For Models, Clients & Activities --}}
    <section class="mb-5">
        <div class="text-center mb-4">
            <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">What we offer</p>
            <h2 class="section-heading fw-bold mb-2">Built for models and brands</h2>
            <p class="text-muted mb-0 mx-auto about-section-subtitle">Whether you want to grow your career or find the right talent, we are here to help.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="about-offer-card h-100 text-center">
                    <div class="about-offer-card__icon"><i class="bi bi-person-plus-fill"></i></div>
                    <h3 class="about-offer-card__title">For Models</h3>
                    <p class="about-offer-card__text">Whether you are starting out or ready for international exposure, Dare to Dream provides mentorship, portfolio building, training, and opportunities to shine on runways and campaigns worldwide.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill">Join Us</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-offer-card h-100 text-center">
                    <div class="about-offer-card__icon"><i class="bi bi-building"></i></div>
                    <h3 class="about-offer-card__title">For Clients</h3>
                    <p class="about-offer-card__text">Looking for fresh faces or professional talent for your brand? We connect you with diverse models who embody originality and professionalism for campaigns, events, and productions.</p>
                    <a href="{{ route('contact-us') }}" class="btn btn-outline-secondary rounded-pill">Work With Us</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="about-offer-card h-100 text-center">
                    <div class="about-offer-card__icon"><i class="bi bi-calendar-event"></i></div>
                    <h3 class="about-offer-card__title">Upcoming Activities</h3>
                    <p class="about-offer-card__text">From model auditions and workshops to fashion showcases and brand activations — see what is coming up at DD Models Agency.</p>
                    <a href="{{ route('upcoming-activities') }}" class="btn btn-outline-secondary rounded-pill">View Activities</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Values --}}
    <section class="mb-5">
        <div class="mb-4">
            <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">What we stand for</p>
            <h2 class="section-heading fw-bold mb-2">Our Values</h2>
            <p class="text-muted mb-0">The principles that guide every partnership, casting, and training session.</p>
        </div>

        <div class="row g-3">
            <div class="col-md-6 col-lg-4">
                <div class="about-value-card h-100">
                    <div class="about-value-card__icon"><i class="bi bi-people-fill"></i></div>
                    <h3 class="h6 fw-bold mb-2">Inclusivity</h3>
                    <p class="text-muted small mb-0">All genders, sizes, and backgrounds have a place here.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="about-value-card h-100">
                    <div class="about-value-card__icon"><i class="bi bi-heart-fill"></i></div>
                    <h3 class="h6 fw-bold mb-2">Authenticity</h3>
                    <p class="text-muted small mb-0">We embrace uniqueness as the true definition of beauty.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="about-value-card h-100">
                    <div class="about-value-card__icon"><i class="bi bi-briefcase-fill"></i></div>
                    <h3 class="h6 fw-bold mb-2">Professionalism</h3>
                    <p class="text-muted small mb-0">Ethical practices, transparency, and fairness in every contract.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="about-value-card h-100">
                    <div class="about-value-card__icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h3 class="h6 fw-bold mb-2">Growth</h3>
                    <p class="text-muted small mb-0">Continuous training and development for rising talent.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="about-value-card h-100">
                    <div class="about-value-card__icon"><i class="bi bi-shield-check"></i></div>
                    <h3 class="h6 fw-bold mb-2">Integrity</h3>
                    <p class="text-muted small mb-0">Respect and honesty in all our partnerships and collaborations.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- My Team --}}
    <section id="meet-the-team" class="mb-5">
        <div class="mb-4">
            <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">The people</p>
            <h2 class="section-heading fw-bold mb-2">My Team</h2>
            <p class="text-muted mb-0">The people behind DD Models Agency.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 team-card text-center">
                    <img src="{{ asset('founder-vickline-gatwiri.png') }}" class="card-img-top team-card__photo" alt="Vickline Gatwiri">
                    <div class="card-body p-4">
                        <p class="team-card__role text-uppercase fw-semibold mb-1">Founder & Director</p>
                        <h3 class="h5 fw-bold mb-2">Vickline Gatwiri</h3>
                        <p class="text-muted small mb-0">A passionate fashion enthusiast, talent manager, and entrepreneur dedicated to creating opportunities for aspiring models and building meaningful connections between talent and brands.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 team-card text-center">
                    <img src="{{ asset('team-caroline-mwongeli.png') }}" class="card-img-top team-card__photo" alt="Caroline Mwongeli">
                    <div class="card-body p-4">
                        <p class="team-card__role text-uppercase fw-semibold mb-1">Manager / Model</p>
                        <h3 class="h5 fw-bold mb-2">Caroline Mwongeli</h3>
                        <p class="text-muted small mb-0">Supporting talent development and representing the agency with professionalism on and off the runway.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 team-card text-center">
                    <img src="{{ asset('team-lyn-mulati.png') }}" class="card-img-top team-card__photo" alt="Lyn Mulati">
                    <div class="card-body p-4">
                        <p class="team-card__role text-uppercase fw-semibold mb-1">Model Coach / Trainer</p>
                        <h3 class="h5 fw-bold mb-2">Lyn Mulati</h3>
                        <p class="text-muted small mb-0">Guiding models through training, runway preparation, and the skills needed to grow with confidence in the industry.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 team-card text-center">
                    <img src="{{ asset('team-newton-mutharimi.png') }}" class="card-img-top team-card__photo" alt="Newton Mutharimi">
                    <div class="card-body p-4">
                        <p class="team-card__role text-uppercase fw-semibold mb-1">Male Coach / Fashion Designer</p>
                        <h3 class="h5 fw-bold mb-2">Newton Mutharimi</h3>
                        <p class="text-muted small mb-0">Coaching male talent and shaping standout looks through fashion design, styling, and industry-ready presentation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="about-cta-panel">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">Why DD Models</p>
                <h2 class="section-heading fw-bold mb-3">Why Choose Us?</h2>
                <p class="text-muted mb-0">
                    DD Models goes beyond traditional model representation by focusing on talent development, mentorship,
                    professionalism, and long-term growth. We build strong relationships between talent and brands, ensuring
                    value creation for both parties while maintaining high standards of excellence and integrity.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Apply to Become a Model</a>
            </div>
        </div>
    </section>
</div>
@endsection
