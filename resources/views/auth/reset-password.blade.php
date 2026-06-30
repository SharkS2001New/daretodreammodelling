@extends('layouts.frontend')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-page__inner">
            <div class="auth-card">
                <div class="auth-card__header">
                    <div class="auth-card__icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h1 class="auth-card__title">{{ __('Reset Password') }}</h1>
                    <p class="auth-card__subtitle">{{ __('Choose a new password for your DD Models account.') }}</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="auth-form__group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                            required autofocus autocomplete="username"
                            class="form-control auth-form__control @error('email') is-invalid @enderror"
                            placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form__group">
                        <label for="password" class="form-label">{{ __('New password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="form-control auth-form__control @error('password') is-invalid @enderror"
                            placeholder="Enter new password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form__group">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="form-control auth-form__control"
                            placeholder="Confirm new password">
                    </div>

                    <button type="submit" class="btn btn-primary auth-form__submit w-100">
                        {{ __('Reset password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
