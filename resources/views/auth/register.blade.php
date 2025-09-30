@extends('layouts.frontend')

@section('content')
<div class="d-flex justify-content-center align-items-center p-2">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 480px; width: 100%;">
        <div class="card-body p-4">

            {{-- Title --}}
            <h2 class="text-center fw-bold mb-4">{{ __('Sign Up') }}</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">{{ __('Full Name *') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                           class="form-control rounded-pill @error('name') is-invalid @enderror" 
                           placeholder="Enter your full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">{{ __('Email *') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                           class="form-control rounded-pill @error('email') is-invalid @enderror" 
                           placeholder="Email address">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">{{ __('Password *') }}</label>
                    <input id="password" type="password" name="password" required 
                           class="form-control rounded-pill @error('password') is-invalid @enderror" 
                           placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">{{ __('Confirm Password *') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                           class="form-control rounded-pill @error('password_confirmation') is-invalid @enderror" 
                           placeholder="Confirm Password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-danger rounded-pill fw-semibold">
                        {{ __('Sign Up') }}
                    </button>
                </div>
            </form>

            {{-- Divider --}}
            <div class="text-center text-muted my-3">— or sign up with —</div>

            {{-- Social Logins --}}
            <div class="d-flex justify-content-center gap-2 mb-3">
                <a href="#" class="btn btn-primary rounded-pill"><i class="bi bi-facebook"></i> Facebook</a>
                <a href="#" class="btn btn-danger rounded-pill"><i class="bi bi-google"></i> Google</a>
                <a href="#" class="btn btn-dark rounded-pill"><i class="bi bi-apple"></i> Apple</a>
            </div>

            {{-- Login Redirect --}}
            <div class="text-center mt-3">
                <p class="mb-0">Already a member?</p>
                <a href="{{ route('login') }}" class="btn btn-dark rounded-pill mt-2">
                    {{ __('Log In') }}
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
