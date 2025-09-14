@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold h4">{{ __('Dashboard') }}</h2>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <p class="mb-0 text-muted">
                {{ __("You're logged in!") }}
            </p>
        </div>
    </div>
</div>
@endsection
