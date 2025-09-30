@extends('layouts.frontend')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-20 p-2">
    <div class="card shadow-lg rounded-4 border-0" style="max-width: 480px; width:100%;">
        <div class="card-body">

            {{-- Title --}}
            <h3 class="text-center mb-4 fw-bold">{{ __('Log In') }}</h3>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">{{ __('Email *') }}</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required autofocus 
                           autocomplete="username"
                           class="form-control rounded-pill px-3 py-2 @error('email') is-invalid @enderror"
                           placeholder="Email address...">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">{{ __('Password *') }}</label>
                    <div class="input-group">
                        <input id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="form-control rounded-start-pill px-3 py-2 @error('password') is-invalid @enderror"
                            placeholder="Password...">
                        <button type="button" class="btn btn-outline-secondary rounded-end-pill" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-danger rounded-pill fw-semibold">
                        {{ __('Log in') }}
                    </button>
                </div>

                {{-- Forgot password --}}
                @if (Route::has('password.request'))
                    <div class="text-center mb-3">
                        <a href="{{ route('password.request') }}" class="small text-decoration-none">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif

                <hr>

                {{-- Social login --}}
                <p class="text-center text-muted mb-3">{{ __('Or log in with') }}</p>
                <div class="d-flex justify-content-center gap-3 mb-3">
                    <a href="#" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-facebook me-1"></i> f
                    </a>
                    <a href="#" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-google me-1"></i> G
                    </a>
                    <a href="#" class="btn btn-dark rounded-pill px-4">
                        <i class="bi bi-apple me-1"></i> 
                    </a>
                </div>

                {{-- Register --}}
                <div class="text-center mt-4">
                    <p class="fw-semibold mb-1">{{ __('Not a member yet?') }}</p>
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-pill px-4">
                        {{ __('Sign up') }}
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let input = document.getElementById('password');
        let icon = this.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });
</script>
@endsection
