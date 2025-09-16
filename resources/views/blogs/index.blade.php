@extends('layouts.frontend')

@section('content')
<section id="blog" class="blog section">
  <div class="container" data-aos="fade-up">
    
    <!-- Featured Quote Section -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="featured-quote-card p-5 rounded-4 shadow-sm position-relative overflow-hidden">
          <!-- Background pattern or image (optional) -->
          <div class="quote-background"></div>
          
          <!-- Quote Content -->
          <div class="position-relative z-1 text-center">
            <div class="quote-icon mb-3">
              <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" class="text-danger opacity-25">
                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
              </svg>
            </div>
            
            <h2 class="quote-text fst-italic fw-normal display-6 mb-4">
              "Success is not final, failure is not fatal: it is the courage to continue that counts."
            </h2>

            <div class="quote-author">
              <span class="fw-bold text-dark">Winston Churchill</span>
              <span class="text-muted mx-2">/</span>
              <span class="text-muted">October 29, 1941</span>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      
      <!-- Left Column: Blog Posts -->
      <div class="col-lg-8">
        <div class="row mb-2">
          <div class="col-md-3 col-12">
            <h3 class="fw-bold mb-4">LATEST POSTS</h3>
          </div>
          <div class="col-md-9">
            @auth
                @if(auth()->user())
                    <div class="w-100 d-flex justify-content-end mt-3">
                        <a href="{{ route('blogs.create') }}" class="btn btn-success btn-sm">
                            Add Blogs
                        </a>
                    </div>
                @endif
            @endauth
          </div>
        </div>

        @foreach($blogs as $blog)
          <div class="d-flex mb-4 pb-4">
            
            <!-- Blog Image -->
            <div class="flex-shrink-0 me-3" style="width: 200px;">
              <a href="{{ route('blogs.show', $blog->slug) }}">
                <img src="{{ asset($blog->image) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $blog->title }}">
              </a>
            </div>

            <!-- Blog Content -->
            <div class="flex-grow-1">
              <div class="text-uppercase text-danger small fw-bold mb-1">
                {{ strtoupper($blog->category->blogs_category_title ?? '') }}
              </div>
              <h5 class="fw-bold">
                <a href="{{ route('blogs.show', $blog->slug) }}" class="text-dark text-decoration-none">
                  {{ $blog->title }}
                </a>
              </h5>
              <small class="text-muted d-block mb-2">
                {{ $blog->published_at ? $blog->published_at->format('F d, Y') : '' }}
              </small>
              <p class="mb-2">
                {{ Str::limit($blog->excerpt, 120) }}
              </p>
              <a href="{{ route('blogs.show', $blog->slug) }}" class="fw-bold text-danger">
                Read More
              </a>
              @auth
                @if(auth()->user())
                  <div class="mt-1 d-flex justify-content-end gap-2">
                      <a href="{{ route('blogs.edit', $blog->id) }}"
                          class="btn btn-sm btn-outline-primary">
                          Edit
                      </a>
                      <form action="{{ route('blogs.destroy', $blog->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this blog item?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger">
                              Delete
                          </button>
                      </form>
                  </div>
                @endif
              @endauth
            </div>
          </div>
        @endforeach

        <!-- Pagination -->
        <div class="mt-4">
          {{ $blogs->links() }}
        </div>
      </div>

      <!-- Right Column: Sidebar -->
      <div class="col-lg-4">

        <!-- Categories Filter -->
        <div class="mb-4 p-3 border">
          <h5 class="fw-bold mb-3">CATEGORIES</h5>
          <form method="GET" action="{{ route('blog.index') }}">
              <select name="category" onchange="this.form.submit()" class="form-select">
                <option value="ALL" {{ $selectedCategory === 'ALL' ? 'selected' : '' }}>All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}" 
                        {{ $selectedCategory === $category->name ? 'selected' : '' }}>
                        {{ strtoupper($category->name) }}
                    </option>
                @endforeach
              </select>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection