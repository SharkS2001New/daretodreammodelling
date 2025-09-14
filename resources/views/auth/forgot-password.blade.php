@extends('layouts.frontend')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 480px; width: 100%;">
        <div class="card-body p-4">

            {{-- Title --}}
            <h2 class="text-center fw-bold mb-4">{{ __('Forgot Password') }}</h2>

            <p class="text-muted small text-center mb-4">
                {{ __('Enter your email address and we’ll send you a link to reset your password.') }}
            </p>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success text-center rounded-pill py-2">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">{{ __('Email *') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="form-control rounded-pill @error('email') is-invalid @enderror"
                           placeholder="Email address">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger rounded-pill fw-semibold">
                        {{ __('Send Reset Link') }}
                    </button>
                </div>
            </form>

            {{-- Back to login --}}
            <div class="text-center mt-4">
                <p class="mb-1">{{ __('Remember your password?') }}</p>
                <a href="{{ route('login') }}" class="btn btn-dark rounded-pill">
                    {{ __('Back to Login') }}
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
