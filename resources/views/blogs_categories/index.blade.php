@extends('layouts.console')

@section('content')
<div class="container" style="max-width: 1000px;">
    <br/>
     <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/console')}}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Go back
        </a>        
    </div>
    
    <h2 class="mb-4">Blog Categories</h2>

    <a href="{{ route('blogs-categories.create') }}" class="btn btn-primary btn-sm mb-3">Add Blog Category</a>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->blogs_category_title }}</td>
                    <td>
                        <a href="{{ route('blogs-categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('blogs-categories.destroy', $cat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br/>
@endsection
