@extends('layouts.frontend')

@section('content')
<div class="container d-flex align-items-center justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <!-- Title -->
                <h4 class="text-center fw-bold mb-3">{{ __('Email Verification') }}</h4>
                <p class="text-muted text-center mb-4">
                    {{ __('Thanks for signing up! Please verify your email by clicking the link we just sent you. If you didn\'t receive it, we can send another.') }}
                </p>

                <!-- Success Alert -->
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success rounded-pill text-center py-2">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif

                <!-- Actions -->
                <div class="d-flex flex-column gap-3 mt-4">
                    <!-- Resend Verification -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-semibold">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
