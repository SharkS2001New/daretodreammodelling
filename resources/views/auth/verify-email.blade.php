@extends('layouts.frontend')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-page__inner">
            <div class="auth-card">
                <div class="auth-card__header">
                    <div class="auth-card__icon">
                        <i class="bi bi-envelope-check-fill"></i>
                    </div>
                    <h1 class="auth-card__title">{{ __('Verify your email') }}</h1>
                    <p class="auth-card__subtitle">
                        {{ __('Thanks for signing up! Please check your inbox for the verification link. If you did not receive it, we can send another.') }}
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success auth-alert">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="d-grid gap-2">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary auth-form__submit w-100">
                            {{ __('Resend verification email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary auth-form__secondary w-100">
                            {{ __('Log out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
