@extends('layouts.frontend')

@section('content')  
    <div class="container py-2">
        <div class="row g-4">
            <!-- Left Card -->
            <div class="col-md-6">
                <div class="card border-0 text-white rounded-4 overflow-hidden position-relative hero-card">
                    <div id="findModelCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="4500">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item active h-100">
                                <img src="{{ asset('hero-find-model-1-editorial-duo.png') }}" class="card-img object-fit-cover h-100 w-100" alt="DD Models editorial duo">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="{{ asset('hero-find-model-2-male-fashion.png') }}" class="card-img object-fit-cover h-100 w-100" alt="DD Models male fashion portrait">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="{{ asset('hero-find-model-3-trio-steps.png') }}" class="card-img object-fit-cover h-100 w-100" alt="DD Models trio on steps">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="{{ asset('hero-find-model-4-street-style.png') }}" class="card-img object-fit-cover h-100 w-100" alt="DD Models street style duo">
                            </div>
                        </div>
                    </div>
                    <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient hero-card__overlay">
                        <h3 class="fw-bold">Find work as a model</h3>
                        <p class="mb-0">Modeling jobs for newcomers and professional models.</p>
                        {{-- <a href="{{ route('models.jobs') }}" class="btn btn-danger rounded-pill mt-2">
                            For models and talents
                        </a> --}}
                    </div>
                </div>
            </div>

            <!-- Right Card -->
            <div class="col-md-6">
                <div class="card border-0 text-white rounded-4 overflow-hidden position-relative h-100">
                    <img src="{{ asset('model_careers1.jpg') }}" class="card-img h-100 object-fit-cover" alt="Find models and talents">
                    <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient">
                        <h3 class="fw-bold">Find models and talents</h3>
                        <p>Source models, talents and influencers for all types of projects.</p>
                        {{-- <a href="{{ route('professionals.index') }}" class="btn btn-danger rounded-pill mt-2">
                            For professionals
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="section-heading text-center mb-4 fw-bold">Popular Models</h2>

        <!-- Category Tabs -->
        {{-- <div class="d-flex justify-content-center mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#">Unique</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Fashion</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Real people</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Plus sized</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Talents</a></li>
            </ul>
        </div> --}}

        <!-- Models Grid -->
        <div class="row g-4">
            @foreach($photos as $model)
                <div class="col-md-3 col-6">
                    <x-model-card :photo="$model" />
                </div>
            @endforeach
        </div>

        <!-- Button -->
        <div class="text-center mt-4">
            <a href="{{ route('models.index') }}" class="btn btn-dark rounded-pill">Find Models</a>
        </div>
    </div>

    <section class="home-community py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-heading fw-bold mb-2">Community</h2>
                <p class="text-muted mb-0 mx-auto home-section-subtitle">Growing together with talent, professionals, and partners across the industry.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-sm-4">
                    <div class="stat-card h-100">
                        <div class="stat-card__icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <p class="stat-card__number">2,356</p>
                        <p class="stat-card__label mb-0">Models in Agency</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="stat-card h-100">
                        <div class="stat-card__icon">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <p class="stat-card__number">187</p>
                        <p class="stat-card__label mb-0">Industry Professionals</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="stat-card h-100">
                        <div class="stat-card__icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <p class="stat-card__number">12</p>
                        <p class="stat-card__label mb-0">Agencies</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="programs" class="home-programs py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-heading fw-bold mb-2">Our Programs</h2>
                <p class="text-muted mb-0 mx-auto home-section-subtitle">Training paths designed to develop confidence, skill, and career-ready talent.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="program-card h-100">
                        <div class="program-card__icon"><i class="bi bi-stars"></i></div>
                        <h5 class="program-card__title">Self Branding</h5>
                        <p class="program-card__text mb-0">Build and promote your unique image in the industry.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="program-card h-100">
                        <div class="program-card__icon"><i class="bi bi-trophy-fill"></i></div>
                        <h5 class="program-card__title">Pageantry</h5>
                        <p class="program-card__text mb-0">Train for beauty contests with grooming and confidence.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="program-card h-100">
                        <div class="program-card__icon"><i class="bi bi-person-walking"></i></div>
                        <h5 class="program-card__title">Runway</h5>
                        <p class="program-card__text mb-0">Master the walk and stage presence for fashion shows.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="program-card h-100">
                        <div class="program-card__icon"><i class="bi bi-camera-reels-fill"></i></div>
                        <h5 class="program-card__title">Commercial</h5>
                        <p class="program-card__text mb-0">Explore TV, print, and brand modeling opportunities.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="program-card h-100">
                        <div class="program-card__icon"><i class="bi bi-award-fill"></i></div>
                        <h5 class="program-card__title">Etiquette</h5>
                        <p class="program-card__text mb-0">Learn social and professional etiquette for success.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="program-card h-100">
                        <div class="program-card__icon"><i class="bi bi-camera-fill"></i></div>
                        <h5 class="program-card__title">Photography &amp; Portfolio</h5>
                        <p class="program-card__text mb-0">Create a stunning portfolio with expert guidance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="section-heading fw-bold mb-5 text-center">Your safety comes first</h2>
            
            <div class="row g-4 justify-content-center">
                
                <div class="col-6 col-md-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                            <i class="bi bi-shield-check fs-3"></i>
                        </div>
                        <p class="mb-0">Every profile is carefully <br> checked and approved</p>
                    </div>
                </div>
                
                <div class="col-6 col-md-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                            <i class="bi bi-lock fs-3"></i>
                        </div>
                        <p class="mb-0">Secure messaging to protect <br> your private information</p>
                    </div>
                </div>
                
                <div class="col-6 col-md-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                            <i class="bi bi-star fs-3"></i>
                        </div>
                        <p class="mb-0">Trusted connections built <br> on real feedback</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="testimonial-section py-5">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <p class="models-section__eyebrow text-uppercase fw-semibold mb-2">Real journeys</p>
                <h2 class="section-heading fw-bold mb-2">Success Stories</h2>
                <p class="text-muted mb-0 mx-auto testimonial-section__subtitle">Hear from models who have grown with DD Models Agency.</p>
            </div>
        </div>

        <div id="testimonialCarousel" class="carousel slide testimonial-carousel" data-bs-ride="carousel">
            <div class="container carousel-inner">

                @foreach ($testimonials as $index => $testimonial)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="testimonial-slide row align-items-center justify-content-center g-4">
                            <div class="col-md-5 text-center">
                                @if($testimonial->youtube_link)
                                    <div class="testimonial-carousel__media rounded-3 shadow-sm">
                                        <iframe
                                            src="{{ $testimonial->getYoutubeEmbedUrl() }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            class="rounded-3">
                                        </iframe>
                                    </div>
                                @elseif($testimonial->cover_image)
                                    <div class="testimonial-carousel__media rounded-3 shadow-sm">
                                        <img src="{{ asset('storage/' . $testimonial->cover_image) }}"
                                            alt="Cover image for {{ $testimonial->name }}"
                                            class="testimonial-carousel__image rounded-3">
                                    </div>
                                @else
                                    <div class="testimonial-carousel__media rounded-3 shadow-sm">
                                        <div class="testimonial-carousel__placeholder rounded-3">
                                            <i class="bi bi-quote fs-1"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="testimonial-slide__content">
                                    @if($testimonial->ratings)
                                        <div class="testimonial-slide__stars mb-3">
                                            @for ($i = 0; $i < $testimonial->ratings; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                        </div>
                                    @endif

                                    <blockquote class="testimonial-slide__quote">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($testimonial->testimony), 180, '...') }}
                                    </blockquote>

                                    <div class="d-flex align-items-center mt-4">
                                        <div class="flex-shrink-0">
                                            @if($testimonial->profile_picture)
                                                <img src="{{ asset('storage/' . $testimonial->profile_picture) }}"
                                                    alt="{{ $testimonial->name }}"
                                                    class="rounded-circle testimonial-slide__avatar"
                                                    width="52" height="52">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}"
                                                    alt="{{ $testimonial->name }}"
                                                    class="rounded-circle testimonial-slide__avatar"
                                                    width="52" height="52">
                                            @endif
                                        </div>
                                        <div class="ms-3">
                                            <strong class="testimonial-slide__name">{{ $testimonial->name }}</strong>
                                            @if($testimonial->job_title)
                                                <br><small class="text-muted">{{ $testimonial->job_title }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('testimonials') }}" class="btn btn-outline-secondary rounded-pill px-4">View all stories</a>
        </div>
    </section>

    <!-- Clients Section -->
    <section id="clients" class="clients section py-4">
        <div class="container text-center">

            <!-- Section Title -->
            <h3 class="section-heading mb-4 fw-bold">Brands that trust us</h3>

            <!-- Logos Marquee -->
            <div class="d-flex overflow-hidden">
            <div class="clients-marquee d-flex align-items-center">
                
                <img src="{{ asset('brands/darling.jpeg') }}" class="mx-4 img-fluid" alt="Client 1">
                <img src="{{ asset('brands/lush-hair.jpeg') }}" class="mx-4 img-fluid" alt="Client 2">
                <img src="{{ asset('brands/nemu.jpeg') }}" class="mx-4 img-fluid" alt="Client 3">
                <img src="{{ asset('brands/poh.jpeg') }}" class="mx-4 img-fluid" alt="Client 4">
                <img src="{{ asset('brands/touch-of-kenya.jpeg') }}" class="mx-4 img-fluid" alt="Client 5">
                <img src="{{ asset('brands/martell.jpeg') }}" class="mx-4 img-fluid" alt="Client 6">

                <!-- duplicate logos for smooth infinite loop -->
                <img src="{{ asset('brands/darling.jpeg') }}" class="mx-4 img-fluid" alt="Client 1">
                <img src="{{ asset('brands/lush-hair.jpeg') }}" class="mx-4 img-fluid" alt="Client 2">
                <img src="{{ asset('brands/nemu.jpeg') }}" class="mx-4 img-fluid" alt="Client 3">
                <img src="{{ asset('brands/poh.jpeg') }}" class="mx-4 img-fluid" alt="Client 4">
                <img src="{{ asset('brands/touch-of-kenya.jpeg') }}" class="mx-4 img-fluid" alt="Client 5">
                <img src="{{ asset('brands/martell.jpeg') }}" class="mx-4 img-fluid" alt="Client 6">
            </div>
            </div>
        </div>
    </section>
@endsection
