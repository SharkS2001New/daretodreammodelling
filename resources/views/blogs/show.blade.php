@extends('layouts.frontend')

@section('content')
<section id="blog-single" class="blog-single section pb-5">
    <div class="container">
        <a href="{{ route('blog.index') }}" class="blog-back-link">
            <i class="bi bi-arrow-left"></i> Back to Blog
        </a>

        <article class="blog-article">
            <header class="blog-article__header">
                @if($blog->category)
                    <span class="blog-card__category">
                        {{ $blog->category->blogs_category_title ?? ucfirst($blog->category->name) }}
                    </span>
                @endif

                <h1 class="blog-article__title">{{ $blog->title }}</h1>

                <div class="blog-article__meta">
                    @if($blog->published_at)
                        <span><i class="bi bi-calendar3"></i> {{ $blog->published_at->format('F d, Y') }}</span>
                    @endif
                    @if($blog->read_time)
                        <span><i class="bi bi-clock"></i> {{ $blog->read_time }} min read</span>
                    @endif
                    @if($blog->user)
                        <span><i class="bi bi-person"></i> {{ $blog->user->name }}</span>
                    @endif
                </div>
            </header>

            @if($blog->image)
                <div class="blog-article__hero">
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-article__image">
                </div>
            @endif

            @if($blog->excerpt)
                <p class="blog-article__excerpt">{{ $blog->excerpt }}</p>
            @endif

            <div class="blog-article__content">
                {!! $blog->content !!}
            </div>

            @if($blog->model || $blog->photographer || $blog->magazine || $blog->brand)
                <div class="blog-article__credits">
                    <p class="blog-section__eyebrow text-uppercase fw-semibold mb-2">Credits</p>
                    <div class="row g-3">
                        @if($blog->model)
                            <div class="col-sm-6 col-lg-3">
                                <div class="blog-credit-item">
                                    <span class="blog-credit-item__label">Model</span>
                                    <span class="blog-credit-item__value">{{ $blog->model }}</span>
                                </div>
                            </div>
                        @endif
                        @if($blog->photographer)
                            <div class="col-sm-6 col-lg-3">
                                <div class="blog-credit-item">
                                    <span class="blog-credit-item__label">Photographer</span>
                                    <span class="blog-credit-item__value">{{ $blog->photographer }}</span>
                                </div>
                            </div>
                        @endif
                        @if($blog->magazine)
                            <div class="col-sm-6 col-lg-3">
                                <div class="blog-credit-item">
                                    <span class="blog-credit-item__label">Magazine</span>
                                    <span class="blog-credit-item__value">{{ $blog->magazine }}</span>
                                </div>
                            </div>
                        @endif
                        @if($blog->brand)
                            <div class="col-sm-6 col-lg-3">
                                <div class="blog-credit-item">
                                    <span class="blog-credit-item__label">Brand</span>
                                    <span class="blog-credit-item__value">{{ $blog->brand }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </article>
    </div>
</section>
@endsection
