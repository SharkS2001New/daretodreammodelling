@extends('layouts.frontend')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-page__inner">
            <div class="auth-card">
                <div class="auth-card__header">
                    <div class="auth-card__icon">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <h1 class="auth-card__title">{{ __('Confirm Password') }}</h1>
                    <p class="auth-card__subtitle">{{ __('Please confirm your password before continuing.') }}</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                    @csrf

                    <div class="auth-form__group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="form-control auth-form__control @error('password') is-invalid @enderror"
                            placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary auth-form__submit w-100">
                        {{ __('Confirm') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
