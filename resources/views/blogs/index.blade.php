@extends('layouts.frontend')

@section('content')
<section id="blog" class="blog section">
  <div class="container" data-aos="fade-up">
    <div class="row mb-2">
      <div class="col-md-3 col-12">
          <form method="GET" action="{{ route('blog.index') }}" class="mb-4">
              <select name="category" onchange="this.form.submit()" class="form-select fw-bold">
                <option value="ALL" {{ $selectedCategory === 'ALL' ? 'selected' : '' }}>ALL</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}" 
                        {{ $selectedCategory === $category->name ? 'selected' : '' }}>
                        {{ strtoupper($category->name) }}
                    </option>
                @endforeach
              </select>
          </form>
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
    
    <div class="row gy-4">
      @foreach($blogs as $blog)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="blog-card">
            <div class="card-image">
              <img src="{{ asset($blog->image) }}" class="img-fluid" alt="{{ $blog->title }}">
              <div class="card-category">{{ $blog->category->blogs_category_title }}</div>
            </div>
            <div class="card-content">
              <h4><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a></h4>
              <p>{{ $blog->excerpt }}</p>
              <div class="card-meta">
                <div class="meta-item">
                  <i class="bi bi-calendar"></i>
                  <span>{{ $blog->published_at ? $blog->published_at->format('F d, Y') : '' }}</span>
                </div>
                <div class="meta-item">
                  <i class="bi bi-clock"></i>
                  <span>{{ $blog->read_time ?? '5 min read' }} Minutes</span>
                </div>
              </div>
              <a href="{{ route('blogs.show', $blog->slug) }}" class="card-link">
                <span>Read Article</span>
                <i class="bi bi-arrow-right"></i>
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
        </div>
      @endforeach
    </div>

    <div class="mt-4">
      {{ $blogs->links() }}
    </div>
  </div>
</section>
@endsection
