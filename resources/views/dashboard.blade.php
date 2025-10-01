@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold h4 mb-0">{{ __('Dashboard') }}</h2> 

        @if(auth()->check() && auth()->user()->is_admin == 1)
            <a href="{{ url('/console') }}" class="btn btn-outline-primary btn-sm">
                {{ __('View Admin Console') }} 
            </a>
        @endif
    </div>

    {{-- Show Email Verification Notice --}}
    @if (! auth()->user()->hasVerifiedEmail())
        <div class="alert alert-light d-flex align-items-center justify-content-between">
            <div>
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ __("We've sent you a link to confirm your email.") }}
                <a href="{{ route('verification.send') }}" class="fw-bold">{{ __('Send again') }}</a>
                <br>
                {{ __('Is this your email?') }}
                <strong>{{ auth()->user()->email }}</strong>
                <a href="{{ route('profile.edit') }}" class="fw-bold">{{ __('Edit email') }}</a>
            </div>
        </div>
    @endif

    {{-- Profile Completion Section --}}
    <div class="card shadow-sm border-0">
        <div class="card-body" style="background-color:#ffffff; border-radius:10px;">
            <h5 class="fw-bold mb-4">
                Hi {{ auth()->user()->name }}, please complete these steps to set up your Profile.
            </h5>

            <div class="d-flex align-items-center mb-4">
                {{-- Progress bar --}}
                <div class="flex-grow-1 me-3">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: 0%; background-color:#212121;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                {{-- Percentage --}}
                <div>
                    <p class="fw-bold mb-0">0%</p>
                </div>
            </div>

            {{-- Checklist buttons in one row --}}
            <div class="row text-center">
                <div class="col-md-4 mb-2">
                    <a href="/account/public" class="btn w-100 fw-bold text-white py-3"
                    style="background-color:#26A69A; border-radius:10px;">
                        ✍️ Write about you
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                    <a href="/account/public" class="btn w-100 fw-bold text-white py-3"
                    style="background-color:#26A69A; border-radius:10px;">
                        📸 Upload profile photo
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                    <a href="{{ route('models.show', ['slug' => Auth::user()->slug, 'tab' => 'photos']) }}" 
                    class="btn w-100 fw-bold text-white py-3"
                    style="background-color:#26A69A; border-radius:10px;">
                    🖼️ Upload 3 photos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
