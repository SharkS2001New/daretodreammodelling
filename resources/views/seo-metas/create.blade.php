@extends('layouts.console')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="w-100" style="max-width: 850px;">
    <br/>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('seo-metas.index') }}" class="btn btn-primary btn-sm">← Back to List</a>   
    </div>
    <h2 class="mb-4" style="font-size: 22px;font-weight:bold">Add New Meta Page</h2>

    <form action="{{ route('seo-metas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="page" class="form-label">Page URL <small class="text-muted">(e.g., "about-us", "contact-us", "girls-academy")</small></label>
            <input type="text" class="form-control" id="page" name="page" required>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Meta Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Meta Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="keywords" class="form-label">Meta Keywords (Comma Separated)</label>
            <input type="text" class="form-control" id="keywords" name="keywords">
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Create</button>
    </form>
</div>
</div>
@endsection
