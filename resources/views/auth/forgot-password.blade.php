@extends('layouts.frontend')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-page__inner">
            <div class="auth-card">
                <div class="auth-card__header">
                    <div class="auth-card__icon">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <h1 class="auth-card__title">{{ __('Forgot Password') }}</h1>
                    <p class="auth-card__subtitle">{{ __('Enter your email and we will send you a link to reset your password.') }}</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success auth-alert">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                    @csrf

                    <div class="auth-form__group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="form-control auth-form__control @error('email') is-invalid @enderror"
                            placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary auth-form__submit w-100">
                        {{ __('Send reset link') }}
                    </button>
                </form>

                <div class="auth-card__footer">
                    <p class="mb-2">{{ __('Remember your password?') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary auth-form__secondary w-100">
                        {{ __('Back to login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
