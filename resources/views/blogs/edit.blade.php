@extends('layouts.console')

@section('content')
<div class="container">
    <h2>Edit Blog</h2>

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label>Title</label>
            <input 
                type="text" 
                name="title" 
                class="form-control @error('title') is-invalid @enderror" 
                required 
                value="{{ old('title', $blog->title) }}">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Excerpt --}}
        <div class="mb-3">
            <label>Excerpt (optional)</label>
            <textarea 
                name="excerpt" 
                class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $blog->excerpt) }}</textarea>
            @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Content --}}
        <div class="mb-3">
            <label>Content</label>
            <textarea 
                name="content" 
                class="form-control @error('content') is-invalid @enderror" 
                rows="6" 
                required>{{ old('content', $blog->content) }}</textarea>
            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label for="blogs_category_id" class="form-label">Blog Category *</label>
            <select name="blogs_category_id" class="form-control @error('blogs_category_id') is-invalid @enderror" required>
                <option value="">-- Select Blog Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('blogs_category_id', $blog->blogs_category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('blogs_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label>Image</label><br>
            @if($blog->image)
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" width="200" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Update Blog</button>
    </form>
</div>
<br/>
@endsection
