@extends('layouts.frontend')

@section('content')  
    <div class="container py-2">
        <div class="row g-4">
            <!-- Left Card -->
            <div class="col-md-6">
                <div class="card border-0 text-white rounded-4 overflow-hidden position-relative">
                    <img src="{{ asset('find_a_model.jpg') }}" class="card-img object-fit-cover" alt="Find work as a model">
                    <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient">
                        <h3 class="fw-bold">Find work as a model</h3>
                        <p>Modeling jobs for newcomers and professional models.</p>
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
        <h2 class="text-center mb-4 fw-bold">Popular Models</h2>

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
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-1x1"> <!-- makes all squares -->
                            <img src="{{ asset('storage/'.$model->file_path) }}" 
                                class="card-img-top rounded object-fit-cover" 
                                alt="{{ $model->user->name }}">
                        </div>
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 bg-gradient">
                            <h6 class="text-white fw-bold m-0">{{ $model->user->name }}</h6>
                            <small class="text-white-50">
                                {{ $model->user->city ?? '' }}, {{ $model->user->country ?? '' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Button -->
        <div class="text-center mt-4">
            <a href="{{ route('models.index') }}" class="btn btn-dark rounded-pill">Find Models</a>
        </div>
    </div>

    <section class="py-2 bg-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">Community</h2>
            
            <div class="row g-4 justify-content-center">
                
                <div class="col-4 col-md-4">
                    <div class="p-4 bg-light rounded-3 shadow-sm h-100">
                        <h3 class="fw-bold">2,356</h3>
                        <p class="mb-0">Models in Agency</p>
                    </div>
                </div>
                
                <div class="col-4 col-md-4">
                    <div class="p-4 bg-light rounded-3 shadow-sm h-100">
                        <h3 class="fw-bold">187</h3>
                        <p class="mb-0">Industry Professionals</p>
                    </div>
                </div>
                
                <div class="col-4 col-md-4">
                    <div class="p-4 bg-light rounded-3 shadow-sm h-100">
                        <h3 class="fw-bold">12</h3>
                        <p class="mb-0">Agencies</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="programs" class="py-3 bg-light bg-gradient text-white">
        <div class="container text-center">
            <h2 class="text-dark fw-bold mb-3">OUR PROGRAMS</h2>
            <div class="row g-4">
                
                <!-- Self Branding -->
                <div class="col-md-4 col-6">
                    <div class="p-4 bg-secondary rounded-3 shadow-sm h-100">
                        <h5 class="fw-bold">Self Branding</h5>
                        <p class="mb-0">
                            Build and promote your unique image in the industry.
                        </p>
                    </div>
                </div>

                <!-- Pageantry -->
                <div class="col-md-4 col-6">
                    <div class="p-4 bg-secondary rounded-3 shadow-sm h-100">
                        <h5 class="fw-bold">Pageantry</h5>
                        <p class="mb-0">
                            Train for beauty contests with grooming and confidence.
                        </p>
                    </div>
                </div>

                <!-- Runway Modeling -->
                <div class="col-md-4 col-6">
                    <div class="p-4 bg-secondary rounded-3 shadow-sm h-100">
                        <h5 class="fw-bold">Runway</h5>
                        <p class="mb-0">
                            Master the walk and stage presence for fashion shows.
                        </p>
                    </div>
                </div>

                <!-- Commercial Modeling -->
                <div class="col-md-4 col-6">
                    <div class="p-4 bg-secondary rounded-3 shadow-sm h-100">
                        <h5 class="fw-bold">Commercial</h5>
                        <p class="mb-0">
                            Explore TV, print, and brand modeling opportunities.
                        </p>
                    </div>
                </div>

                <!-- Etiquette -->
                <div class="col-md-4 col-6">
                    <div class="p-4 bg-secondary rounded-3 shadow-sm h-100">
                        <h5 class="fw-bold">Etiquette</h5>
                        <p class="mb-0">
                            Learn social and professional etiquette for success.
                        </p>
                    </div>
                </div>

                <!-- Photography & Portfolio -->
                <div class="col-md-4 col-6">
                    <div class="p-4 bg-secondary rounded-3 shadow-sm h-100">
                        <h5 class="fw-bold">Photography & Portfolio</h5>
                        <p class="mb-0">
                            Create a stunning portfolio with expert guidance.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">Your safety comes first</h2>
            
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

    <div class="testimonial-section py-5">
        <h2 class="text-center fw-bold mb-5">Success Stories</h2>
        
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="container carousel-inner">

                @foreach ($testimonials as $index => $testimonial)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row align-items-center justify-content-center">
                            
                            {{-- ✅ Left side: Image or Video --}}
                            <div class="col-md-5 text-center">
                                @if($testimonial->youtube_link)
                                    <div class="ratio ratio-16x9 rounded-3 shadow-sm">
                                        <iframe 
                                            src="{{ $testimonial->getYoutubeEmbedUrl() }}"
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen
                                            class="w-100 h-100 rounded-3">
                                        </iframe>
                                    </div>
                                @elseif($testimonial->cover_image)
                                    <img src="{{ asset('storage/' . $testimonial->cover_image) }}"
                                        alt="Cover image for {{ $testimonial->name }}"
                                        class="img-fluid rounded-3 shadow-sm">
                                @endif
                            </div>

                            {{-- ✅ Right side: Testimonial Text --}}
                            <div class="col-md-6">
                                <blockquote class="fs-5 fw-medium">
                                    <i class="bi bi-quote text-danger fs-2 me-2"></i>
                                    {{ \Illuminate\Support\Str::limit(strip_tags($testimonial->testimony), 150, '...') }}
                                </blockquote>


                                {{-- ✅ Profile Avatar --}}
                                <div class="d-flex align-items-center mt-4">
                                    <div class="flex-shrink-0">
                                        @if($testimonial->profile_picture)
                                            <img src="{{ asset('storage/' . $testimonial->profile_picture) }}"
                                                alt="{{ $testimonial->name }}"
                                                class="rounded-circle"
                                                width="50" height="50">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}"
                                                alt="{{ $testimonial->name }}"
                                                class="rounded-circle"
                                                width="50" height="50">
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <strong>{{ $testimonial->name }}</strong><br>
                                        @if($testimonial->job_title)
                                            <small class="text-muted">{{ $testimonial->job_title }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ✅ Carousel controls --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <i class="bi bi-chevron-double-left text-dark"></i>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <i class="bi bi-chevron-double-right text-dark"></i>
            </button>
        </div>
    </div>

    <!-- Clients Section -->
    <section id="clients" class="clients section py-4">
        <div class="container text-center">

            <!-- Section Title -->
            <h3 class="mb-4 fw-bold">Brands that trust us</h3>

            <!-- Logos Marquee -->
            <div class="d-flex overflow-hidden">
            <div class="clients-marquee d-flex align-items-center">
                
                <img src="{{ asset('assets/img/clients/clients-1.webp') }}" class="mx-4 img-fluid" alt="Client 1">
                <img src="{{ asset('assets/img/clients/clients-2.webp') }}" class="mx-4 img-fluid" alt="Client 2">
                <img src="{{ asset('assets/img/clients/clients-3.webp') }}" class="mx-4 img-fluid" alt="Client 3">
                <img src="{{ asset('assets/img/clients/clients-4.webp') }}" class="mx-4 img-fluid" alt="Client 4">
                <img src="{{ asset('assets/img/clients/clients-5.webp') }}" class="mx-4 img-fluid" alt="Client 5">
                <img src="{{ asset('assets/img/clients/clients-6.webp') }}" class="mx-4 img-fluid" alt="Client 6">

                <!-- duplicate logos for smooth infinite loop -->
                <img src="{{ asset('assets/img/clients/clients-1.webp') }}" class="mx-4 img-fluid" alt="Client 1">
                <img src="{{ asset('assets/img/clients/clients-2.webp') }}" class="mx-4 img-fluid" alt="Client 2">
                <img src="{{ asset('assets/img/clients/clients-3.webp') }}" class="mx-4 img-fluid" alt="Client 3">
                <img src="{{ asset('assets/img/clients/clients-4.webp') }}" class="mx-4 img-fluid" alt="Client 4">
                <img src="{{ asset('assets/img/clients/clients-5.webp') }}" class="mx-4 img-fluid" alt="Client 5">
                <img src="{{ asset('assets/img/clients/clients-6.webp') }}" class="mx-4 img-fluid" alt="Client 6">
            </div>
            </div>
        </div>
    </section>
@endsection

