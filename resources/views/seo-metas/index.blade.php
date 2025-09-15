@extends('layouts.console')

@section('content')
<div class="container">
    <br/>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="/console" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Go back
                </a>        
            </div>
        </div>
        <div class="col-md-8">
            <h1 class="mb-4" style="font-size: 22px;font-weight:bold">Seo Meta Tags</h1>
        </div>
        <div class="col-md-2">
            <div class="mb-4 text-end">
                <a href="{{ route('seo-metas.create') }}" class="btn btn-primary btn-sm">+ Create New Page Meta</a>
            </div>
        </div>
    </div>

    <div style="max-height: 82vh; overflow-y: auto;">
        @foreach($metas as $key => $meta)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h5 class="card-title text-primary">Page: <strong>{{ ucfirst($key) }}</strong></h5>
                            <p><strong>Title:</strong> {{ $meta['title'] ?? '—' }}</p>
                            <p><strong>Description:</strong> {{ $meta['description'] ?? '—' }}</p>
                            <p><strong>Keywords:</strong> {{ $meta['keywords'] ?? '—' }}</p>
                        </div>
                        <div class="col-md-2 text-end">
                            <br/>
                            <a href="{{ route('seo-metas.edit', $key) }}" class="btn btn-sm btn-outline-success">Edit</a>
                            <form action="{{ route('seo-metas.destroy', $key) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>    
</div>
@endsection
