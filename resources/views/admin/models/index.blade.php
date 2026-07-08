@extends('layouts.console')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manage Models') }}
    </h2>
@endsection

@section('content')
<div class="py-2">
    <div class="container mb-3" style="max-width: 1100px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <a href="{{ route('console') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Back to console
                </a>
            </div>
            <a href="{{ route('console.models.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus"></i> Register model
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success py-2 px-3 mb-3 mt-3">{{ session('success') }}</div>
        @endif
    </div>

    <div class="container" style="max-width: 1100px;">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Model</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($models as $model)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $model->avatarUrl(48) }}" alt="" width="40" height="40" class="rounded-circle object-fit-cover">
                                            <div>
                                                <strong>{{ $model->displayName() }}</strong>
                                                @if($model->user_type)
                                                    <div class="text-muted small">{{ $model->user_type }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $model->email }}</td>
                                    <td>{{ $model->publicInfo?->location ?? '—' }}</td>
                                    <td class="text-end">
                                        <div class="d-flex flex-wrap gap-1 justify-content-end">
                                            <a href="{{ route('models.show', $model->slug) }}" class="btn btn-sm btn-outline-primary">View profile</a>
                                            <a href="{{ route('console.models.settings', $model) }}" class="btn btn-sm btn-primary">Settings</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No models found.
                                        <a href="{{ route('console.models.create') }}">Register the first model</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
