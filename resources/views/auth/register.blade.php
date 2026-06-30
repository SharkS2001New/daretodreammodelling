@extends('layouts.frontend')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="auth-page__inner">
            <div class="auth-card">
                <div class="auth-card__header">
                    <div class="auth-card__icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h1 class="auth-card__title">{{ __('Sign Up') }}</h1>
                    <p class="auth-card__subtitle">Create your profile and start your journey with DD Models Agency.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="auth-form__group">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <input id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="form-control auth-form__control @error('name') is-invalid @enderror"
                            placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form__group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
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
                                class="form-control auth-form__control @error('password') is-invalid @enderror"
                                placeholder="Create a password">
                            <button type="button" class="btn auth-form__toggle" id="togglePassword" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form__group">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="input-group auth-form__password-group">
                            <input id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                class="form-control auth-form__control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Confirm your password">
                            <button type="button" class="btn auth-form__toggle" id="togglePasswordConfirm" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary auth-form__submit w-100">
                        {{ __('Create account') }}
                    </button>
                </form>

                <div class="auth-divider">
                    <span>{{ __('Or sign up with') }}</span>
                </div>

                <div class="auth-social">
                    <a href="#" class="auth-social__btn auth-social__btn--facebook" aria-label="Sign up with Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="auth-social__btn auth-social__btn--google" aria-label="Sign up with Google">
                        <i class="bi bi-google"></i>
                    </a>
                    <a href="#" class="auth-social__btn auth-social__btn--apple" aria-label="Sign up with Apple">
                        <i class="bi bi-apple"></i>
                    </a>
                </div>

                <div class="auth-card__footer">
                    <p class="mb-2">{{ __('Already have an account?') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary auth-form__secondary w-100">
                        {{ __('Log in') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function bindPasswordToggle(buttonId, inputId) {
        document.getElementById(buttonId).addEventListener('click', function () {
            const input = document.getElementById(inputId);
            const icon = this.querySelector('i');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isPassword);
            icon.classList.toggle('bi-eye-slash', isPassword);
        });
    }

    bindPasswordToggle('togglePassword', 'password');
    bindPasswordToggle('togglePasswordConfirm', 'password_confirmation');
</script>
@endsection
