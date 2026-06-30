@extends('layouts.frontend')

@section('content')
<section id="blog" class="blog section pb-5">
    <div class="container">
        <x-page-heading
            subtitle="Modelling advice, industry insights, and updates from the DD Models team."
            class="mb-4"
        />

        {{-- Featured quote --}}
        <div class="featured-quote-card blog-quote-card p-4 p-md-5 rounded-4 shadow-sm mb-5">
            <div class="text-center">
                <div class="blog-quote-card__icon mb-3">
                    <i class="bi bi-quote"></i>
                </div>
                <blockquote class="quote-text fst-italic fw-normal fs-4 mb-4 mb-md-0">
                    "Success is not final, failure is not fatal: it is the courage to continue that counts."
                </blockquote>
                <footer class="quote-author mt-3">
                    <span class="fw-bold">Winston Churchill</span>
                    <span class="text-muted mx-2">/</span>
                    <span class="text-muted">October 29, 1941</span>
                </footer>
            </div>
        </div>

        <div class="row g-4">
            {{-- Sidebar --}}
            <div class="col-lg-4 order-1 order-lg-2">
                <div class="blog-sidebar">
                    <div class="blog-sidebar-card">
                        <p class="blog-section__eyebrow text-uppercase fw-semibold mb-2">Browse</p>
                        <h2 class="h5 fw-bold mb-3">Categories</h2>
                        <div class="blog-category-list">
                            <a href="{{ route('blog.index', ['category' => 'ALL']) }}"
                                class="blog-category-pill {{ $selectedCategory === 'ALL' ? 'is-active' : '' }}">
                                All
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('blog.index', ['category' => $category->name]) }}"
                                    class="blog-category-pill {{ $selectedCategory === $category->name ? 'is-active' : '' }}">
                                    {{ $category->blogs_category_title ?? ucfirst($category->name) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Posts --}}
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <p class="blog-section__eyebrow text-uppercase fw-semibold mb-1">Latest</p>
                        <h2 class="h4 fw-bold mb-0">Posts</h2>
                    </div>
                    @auth
                        <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm rounded-pill">
                            Add Blog
                        </a>
                    @endauth
                </div>

                @forelse($blogs as $blog)
                    <article class="blog-card mb-4">
                        <div class="row g-0 align-items-stretch">
                            <div class="col-md-5">
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-card__image-link d-block h-100">
                                    <div class="blog-card__image-wrap h-100">
                                        @if($blog->image)
                                            <img src="{{ asset($blog->image) }}"
                                                alt="{{ $blog->title }}"
                                                class="blog-card__image">
                                        @else
                                            <div class="blog-card__placeholder">
                                                <i class="bi bi-journal-text"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-7">
                                <div class="blog-card__body h-100">
                                    @if($blog->category)
                                        <span class="blog-card__category">
                                            {{ $blog->category->blogs_category_title ?? ucfirst($blog->category->name) }}
                                        </span>
                                    @endif

                                    <h3 class="blog-card__title">
                                        <a href="{{ route('blogs.show', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>

                                    <div class="blog-card__meta">
                                        @if($blog->published_at)
                                            <span><i class="bi bi-calendar3"></i> {{ $blog->published_at->format('M d, Y') }}</span>
                                        @endif
                                        @if($blog->read_time)
                                            <span><i class="bi bi-clock"></i> {{ $blog->read_time }} min read</span>
                                        @endif
                                    </div>

                                    <p class="blog-card__excerpt">
                                        {{ Str::limit($blog->excerpt, 140) }}
                                    </p>

                                    @if($blog->model || $blog->photographer || $blog->magazine || $blog->brand)
                                        <div class="blog-card__credits">
                                            @if($blog->model)
                                                <span>Model: <strong>{{ $blog->model }}</strong></span>
                                            @endif
                                            @if($blog->photographer)
                                                <span>Photographer: <strong>{{ $blog->photographer }}</strong></span>
                                            @endif
                                            @if($blog->magazine)
                                                <span>Magazine: <strong>{{ $blog->magazine }}</strong></span>
                                            @endif
                                            @if($blog->brand)
                                                <span>Brand: <strong>{{ $blog->brand }}</strong></span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-auto">
                                        <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-card__read-more">
                                            Read more <i class="bi bi-arrow-right"></i>
                                        </a>

                                        @auth
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                    Edit
                                                </a>
                                                <form action="{{ route('blogs.destroy', $blog->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this blog item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="blog-empty-state text-center py-5">
                        <i class="bi bi-journal-x fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">No blog posts found in this category yet.</p>
                    </div>
                @endforelse

                @if($blogs->hasPages())
                    <div class="mt-4">
                        {{ $blogs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
