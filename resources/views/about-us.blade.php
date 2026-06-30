@extends('layouts.frontend')

@section('content')
<div class="container pb-5">
    {{-- Hero --}}
    <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6">
            <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">Dare To Dream</p>
            <x-page-heading :centered="false" title="About Us" subtitle="" class="mb-3" />
            <p class="text-muted mb-3">
                DD Models Agency is a dynamic talent development and model management platform dedicated to discovering,
                nurturing, and connecting aspiring and professional models with meaningful opportunities. We believe in
                empowering talent through mentorship, training, exposure, and professional guidance while creating
                valuable partnerships with brands, businesses, and industry stakeholders.
            </p>
            <p class="text-muted mb-0">
                Founded by <strong>Vickline Gatwiri</strong>, DD Models is built on the belief that every dream is valid
                and every talent deserves a platform to shine.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="about-hero-frame">
                <img src="{{ asset('about-hero.png') }}"
                    alt="DD Models Agency team"
                    class="about-hero-image">
            </div>
        </div>
    </div>

    {{-- Vision & Mission --}}
    <section class="mb-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="about-profile-panel h-100">
                    <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">Our direction</p>
                    <h2 class="section-heading fw-bold mb-3">Vision</h2>
                    <p class="text-muted mb-0">
                        To become a leading modeling and talent development agency recognized for excellence,
                        professionalism, diversity, and innovation in the fashion and creative industries.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-profile-panel h-100">
                    <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">Our purpose</p>
                    <h2 class="section-heading fw-bold mb-3">Mission</h2>
                    <p class="text-muted mb-0">
                        To empower aspiring and professional models through mentorship, training, exposure, and strategic
                        partnerships while delivering exceptional talent solutions to brands and clients.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Services --}}
    <section class="mb-5">
        <div class="mb-4">
            <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">What we do</p>
            <h2 class="section-heading fw-bold mb-2">Our Services</h2>
        </div>

        <div class="row g-3">
            @foreach ([
                'Model Scouting & Recruitment',
                'Talent Development & Mentorship',
                'Fashion Shows & Runway Coordination',
                'Brand Activations & Promotions',
                'Event Staffing',
                'Photography Collaborations',
                'Casting & Talent Placement',
                'Portfolio Development & Grooming Workshops',
                'Influencer & Brand Ambassador Management',
            ] as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="about-value-card h-100">
                        <div class="about-value-card__icon"><i class="bi bi-check2-circle"></i></div>
                        <p class="fw-semibold mb-0">{{ $service }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- What we bring --}}
    <section class="mb-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="about-profile-panel h-100">
                    <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">For models</p>
                    <h2 class="section-heading fw-bold mb-3">What DD Models Brings to Models</h2>
                    <ul class="list-unstyled mb-0 about-benefit-list">
                        @foreach ([
                            'Professional mentorship and industry guidance',
                            'Exposure to casting calls, fashion shows, photoshoots, and campaigns',
                            'Portfolio and personal brand development',
                            'Networking opportunities with photographers, designers, brands, and agencies',
                            'Confidence-building and career growth support',
                            'Access to a professional and supportive modeling community',
                        ] as $item)
                            <li><i class="bi bi-stars"></i> {{ $item }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill mt-4">Join Us</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-profile-panel h-100">
                    <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">For clients</p>
                    <h2 class="section-heading fw-bold mb-3">What DD Models Brings to Clients</h2>
                    <ul class="list-unstyled mb-0 about-benefit-list">
                        @foreach ([
                            'Access to trained, professional, and reliable talent',
                            'Efficient talent sourcing and coordination',
                            'Professional representation for events and campaigns',
                            'Brand ambassadors who align with brand values',
                            'Diverse talent for different market needs',
                            'Quality service and professional execution',
                        ] as $item)
                            <li><i class="bi bi-stars"></i> {{ $item }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('contact-us') }}" class="btn btn-outline-secondary rounded-pill mt-4">Work With Us</a>
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

    {{-- What Makes DD Models Different --}}
    <section class="about-cta-panel">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="about-section__eyebrow text-uppercase fw-semibold mb-2">Why DD Models</p>
                <h2 class="section-heading fw-bold mb-3">What Makes DD Models Different</h2>
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
