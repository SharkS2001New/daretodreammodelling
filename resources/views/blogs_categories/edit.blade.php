@extends('layouts.console')

@section('content')
<div class="container" style="max-width: 1000px;">
    <br/>
     <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/dashboard')}}" class="btn btn-primary btn-sm">
            <i class="bi bi-arrow-left"></i> Go back
        </a>        
    </div>
    
    <h2 class="mb-4">Edit Blog Category</h2>

    <form action="{{ route('blogs-categories.update', $blogs_category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $blogs_category->name }}" required>
        </div>
        <div class="mb-3">
            <label>Blog Category Title</label>
            <input type="text" name="blogs_category_title" class="form-control" value="{{ $blogs_category->blogs_category_title }}" required>
        </div>
        <button class="btn btn-primary btn-sm">Update</button>
    </form>
</div>
<br/>
@endsection
