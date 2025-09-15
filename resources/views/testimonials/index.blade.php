@extends('layouts.frontend')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="text-center mb-2">
        <h1 class="display-5 fw-bold text-dark mb-2">Testimonials</h1>

        @auth
            @if(auth()->user()->is_admin == 1)
                <div class="w-100 d-flex justify-content-end mt-3">
                    <a href="{{ route('testimonials.create') }}" class="btn btn-outline-danger btn-sm">
                        Add New Testimonial
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <div class="row g-4">
        @foreach ($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card p-4 h-100 rounded-4 shadow-sm bg-white position-relative">
                    {{-- ✅ Show YouTube Video OR Cover Image --}}
                    <div class="mb-3">
                        @if($testimonial->youtube_link)
                            <div class="video-container rounded-3 shadow-sm">
                                <iframe 
                                    src="{{ $testimonial->getYoutubeEmbedUrl() }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    class="w-100 h-100 rounded-3"
                                ></iframe>
                            </div>
                        @elseif($testimonial->cover_image)
                            <img src="{{ asset('storage/' . $testimonial->cover_image) }}"
                                alt="Cover image for {{ $testimonial->name }}"
                                class="img-fluid rounded-3 shadow-sm">
                        @endif
                    </div>

                    <div class="mb-3">
                        {!! $testimonial->testimony !!}
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-auto">
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
                        <div>
                            <strong>{{ $testimonial->name }}</strong><br>
                            @if($testimonial->job_title)
                                <small class="text-muted">{{ $testimonial->job_title }}</small>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->is_admin == 1)
                            <div class="position-absolute top-0 end-0 me-2 d-flex gap-1">
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}"
                                class="btn btn-sm btn-outline-primary px-2 py-1"
                                style="font-size: 0.75rem;">
                                    Edit
                                </a>
                        
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger px-2 py-1"
                                            style="font-size: 0.75rem;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth                
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $testimonials->links() }}
    </div>
</div>

@endsection
