@extends('layouts.frontend')

@section('content')
<section id="blog-single" class="blog-single section">
  <div class="container" data-aos="fade-up">
    <article class="blog-article">
      <div class="row">
        <div class="col-md-4">
          <img src="{{ asset($blog->image) }}" class="img-fluid mb-3" alt="{{ $blog->title }}">
        </div>
        <div class="col-md-8">
          <h2>{{ $blog->title }}</h2>
          <div class="blog-meta">
            <i class="bi bi-calendar"></i> {{ $blog->published_at?->format('F d, Y') }}
            <i class="bi bi-tag ms-3"></i> {{ $blog->category->blogs_category_title }}
          </div>
          <div class="mt-3">
            {!! nl2br(e($blog->content)) !!}
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
@endsection
