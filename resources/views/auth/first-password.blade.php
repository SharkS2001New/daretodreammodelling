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
                    <h1 class="auth-card__title">{{ __('Set your password') }}</h1>
                    <p class="auth-card__subtitle">
                        Your account was created by an administrator. Choose a new password to secure your profile before continuing.
                    </p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger auth-alert">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.first-login.update') }}" class="auth-form">
                    @csrf

                    <div class="auth-form__group">
                        <label for="password" class="form-label">{{ __('New password') }}</label>
                        <input id="password"
                            type="password"
                            name="password"
                            required
                            autofocus
                            autocomplete="new-password"
                            class="form-control auth-form__control @error('password') is-invalid @enderror"
                            placeholder="Enter a secure password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form__group">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm password') }}</label>
                        <input id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="form-control auth-form__control"
                            placeholder="Confirm your password">
                    </div>

                    <button type="submit" class="btn btn-primary auth-form__submit w-100">
                        {{ __('Save password & continue') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center mt-3">
                    @csrf
                    <button type="submit" class="btn btn-link btn-sm text-muted">Log out</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
