@extends('layouts.console')

@section('content')
<div class="container">
    <h2>Create Blog</h2>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label>Excerpt (optional)</label>
            <textarea name="excerpt" class="form-control">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
        </div>

           <!-- Optional fields -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Model (optional)</label>
                <input type="text" name="model" class="form-control" value="{{ old('model') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Photographer (optional)</label>
                <input type="text" name="photographer" class="form-control" value="{{ old('photographer') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Magazine (optional)</label>
                <input type="text" name="magazine" class="form-control" value="{{ old('magazine') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Brand (optional)</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="blogs_category_id" class="form-label">Blog Category *</label>
            <select name="blogs_category_id" class="form-control" required>
                <option value="">-- Select Blog Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('blogs_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('blogs_category_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Create Blog</button>
    </form>
</div>
<br/>
@endsection
z