@extends('layouts.frontend')

@section('content')
<div class="container pb-5">
    <x-page-heading subtitle="Hear from models and clients who have worked with DD Models Agency." class="mb-4" />

    @auth
        @if(auth()->user()->is_admin == 1)
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('testimonials.create') }}" class="btn btn-primary btn-sm rounded-pill">
                    Add testimonial
                </a>
            </div>
        @endif
    @endauth

    <div class="row g-4">
        @forelse ($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <article class="testimonial-card h-100 position-relative">
                    <div class="testimonial-card__media mb-3">
                        @if($testimonial->youtube_link)
                            <div class="testimonial-card__video ratio ratio-16x9 rounded-3 overflow-hidden">
                                <iframe
                                    src="{{ $testimonial->getYoutubeEmbedUrl() }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    class="rounded-3">
                                </iframe>
                            </div>
                        @elseif($testimonial->cover_image)
                            <div class="testimonial-card__cover-wrap">
                                <img src="{{ asset('storage/' . $testimonial->cover_image) }}"
                                    alt="Cover image for {{ $testimonial->name }}"
                                    class="testimonial-card__cover w-100">
                            </div>
                        @else
                            <div class="testimonial-card__placeholder">
                                <i class="bi bi-quote fs-1"></i>
                            </div>
                        @endif
                    </div>

                    @if($testimonial->ratings)
                        <div class="testimonial-slide__stars mb-2">
                            @for ($i = 0; $i < $testimonial->ratings; $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>
                    @endif

                    <div class="testimonial-card__quote mb-3">
                        {!! $testimonial->testimony !!}
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-auto">
                        <img src="{{ $testimonial->profile_picture ? asset('storage/' . $testimonial->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->name) }}"
                            alt="{{ $testimonial->name }}"
                            class="rounded-circle testimonial-slide__avatar"
                            width="48" height="48">
                        <div>
                            <strong>{{ $testimonial->name }}</strong>
                            @if($testimonial->job_title)
                                <br><small class="text-muted">{{ $testimonial->job_title }}</small>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->is_admin == 1)
                            <div class="testimonial-card__admin-actions">
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="models-empty-state text-center py-5">
                    <i class="bi bi-chat-quote fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted mb-0">Success stories will appear here soon.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($testimonials->hasPages())
        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
    @endif
</div>
@endsection
