@extends('layouts.console')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="w-100" style="max-width: 850px;">
        <br/>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('seo-metas.index') }}" class="btn btn-primary btn-sm">← Back to List</a>   
        </div>
        <h2 class="mb-4" style="font-size: 22px;font-weight:bold">Update Meta for "<strong>{{ $page }}</strong>"</h2>
    
        <form action="{{ route('seo-metas.update', $page) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Meta Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $title }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Meta Description</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ $description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="keywords" class="form-label">Meta Keywords (Comma Separated)</label>
                <input type="text" class="form-control" id="keywords" name="keywords" value="{{ $keywords }}">
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Update Meta</button>
        </form>
    </div>
</div>
@endsection
