@extends('layouts.frontend')

@section('content')
<div class="container pb-5">
    <x-page-heading class="mb-4" />

    <section class="activities-intro-panel mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="activities-section__eyebrow text-uppercase fw-semibold mb-2">Events & opportunities</p>
                <h2 class="section-heading fw-bold mb-3">Grow with DD Models</h2>
                <p class="text-muted mb-0">
                    From auditions and workshops to runway showcases and brand activations, our calendar is built to
                    help models gain experience, build confidence, and connect with the industry.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="activities-highlight">
                    <div class="activities-highlight__icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <p class="fw-medium mb-1">Stay connected</p>
                    <p class="text-muted small mb-0">Follow us on Instagram and TikTok for the latest event announcements.</p>
                </div>
            </div>
        </div>
    </section>

    @php
        $activities = [
            ['icon' => 'bi-person-check-fill', 'title' => 'Model Auditions', 'description' => 'Open calls for new faces ready to begin their modelling journey with DD Models Agency.'],
            ['icon' => 'bi-mortarboard-fill', 'title' => 'Talent Development Workshops', 'description' => 'Training sessions covering runway, confidence, etiquette, and professional industry skills.'],
            ['icon' => 'bi-stars', 'title' => 'Fashion Showcases', 'description' => 'Runway and presentation events that give models real stage experience in front of audiences and brands.'],
            ['icon' => 'bi-megaphone-fill', 'title' => 'Brand Activations', 'description' => 'Live campaigns and promotional events connecting models with brands across Kenya.'],
            ['icon' => 'bi-camera-fill', 'title' => 'Photoshoots', 'description' => 'Professional shoots to help models build strong portfolios and visual presence.'],
            ['icon' => 'bi-people-fill', 'title' => 'Networking Events', 'description' => 'Industry meet-ups bringing together models, creatives, and business partners.'],
            ['icon' => 'bi-heart-fill', 'title' => 'Community Engagement Programs', 'description' => 'Outreach initiatives that inspire youth and give back to the community through fashion and talent.'],
        ];
    @endphp

    <section class="mb-5">
        <div class="text-center mb-4">
            <p class="activities-section__eyebrow text-uppercase fw-semibold mb-2">Our calendar</p>
            <h2 class="section-heading fw-bold mb-2">What we host</h2>
            <p class="text-muted mb-0 mx-auto activities-section-subtitle">Experiences designed to develop talent and open doors in the modelling industry.</p>
        </div>

        <div class="row g-4">
            @foreach ($activities as $activity)
                <div class="col-md-6 col-lg-4">
                    <div class="activity-card h-100">
                        <div class="activity-card__icon">
                            <i class="bi {{ $activity['icon'] }}"></i>
                        </div>
                        <h3 class="activity-card__title">{{ $activity['title'] }}</h3>
                        <p class="activity-card__text mb-0">{{ $activity['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="activities-cta-panel">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="activities-section__eyebrow text-uppercase fw-semibold mb-2">Get involved</p>
                <h2 class="section-heading fw-bold mb-3">Want to take part?</h2>
                <p class="text-muted mb-0">
                    Whether you are an aspiring model or a brand looking to partner on an event, our team would love to hear from you.
                </p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap gap-2 justify-content-lg-end">
                <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Join as a Model</a>
                <a href="{{ route('contact-us') }}" class="btn btn-outline-secondary rounded-pill px-4">Get in Touch</a>
            </div>
        </div>
    </section>
</div>
@endsection
