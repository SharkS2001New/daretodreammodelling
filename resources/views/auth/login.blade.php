@extends('layouts.frontend')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-page__inner">
            <div class="auth-card">
                <div class="auth-card__header">
                    <div class="auth-card__icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <h1 class="auth-card__title">{{ __('Log In') }}</h1>
                    <p class="auth-card__subtitle">Welcome back. Sign in to access your DD Models profile.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success auth-alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="auth-form__group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="form-control auth-form__control @error('email') is-invalid @enderror"
                            placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form__group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group auth-form__password-group">
                            <input id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="form-control auth-form__control @error('password') is-invalid @enderror"
                                placeholder="Enter your password">
                            <button type="button" class="btn auth-form__toggle" id="togglePassword" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    @if (Route::has('password.request'))
                        <div class="auth-form__links text-end">
                            <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary auth-form__submit w-100">
                        {{ __('Log in') }}
                    </button>
                </form>

                <div class="auth-divider">
                    <span>{{ __('Or continue with') }}</span>
                </div>

                <div class="auth-social">
                    <a href="#" class="auth-social__btn auth-social__btn--facebook" aria-label="Log in with Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="auth-social__btn auth-social__btn--google" aria-label="Log in with Google">
                        <i class="bi bi-google"></i>
                    </a>
                    <a href="#" class="auth-social__btn auth-social__btn--apple" aria-label="Log in with Apple">
                        <i class="bi bi-apple"></i>
                    </a>
                </div>

                <div class="auth-card__footer">
                    <p class="mb-2">{{ __('Not a member yet?') }}</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary auth-form__secondary w-100">
                        {{ __('Create an account') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !isPassword);
        icon.classList.toggle('bi-eye-slash', isPassword);
    });
</script>
@endsection
