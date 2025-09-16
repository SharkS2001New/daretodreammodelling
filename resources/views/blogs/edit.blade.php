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

        {{-- Optional fields --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Model (optional)</label>
                <input 
                    type="text" 
                    name="model" 
                    class="form-control @error('model') is-invalid @enderror" 
                    value="{{ old('model', $blog->model) }}">
                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Photographer (optional)</label>
                <input 
                    type="text" 
                    name="photographer" 
                    class="form-control @error('photographer') is-invalid @enderror" 
                    value="{{ old('photographer', $blog->photographer) }}">
                @error('photographer') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Magazine (optional)</label>
                <input 
                    type="text" 
                    name="magazine" 
                    class="form-control @error('magazine') is-invalid @enderror" 
                    value="{{ old('magazine', $blog->magazine) }}">
                @error('magazine') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Brand (optional)</label>
                <input 
                    type="text" 
                    name="brand" 
                    class="form-control @error('brand') is-invalid @enderror" 
                    value="{{ old('brand', $blog->brand) }}">
                @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
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
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" width="200" class="mb-2 rounded">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                    <label class="form-check-label" for="remove_image">
                        Remove current image
                    </label>
                </div>
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            <div class="form-text">Leave empty to keep current image. Max size: 2MB</div>
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Blog</button>
        <a href="{{ route('blog.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<br/>
@endsection