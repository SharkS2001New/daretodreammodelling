@extends('layouts.frontend')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <!-- Title -->
                <h4 class="text-center fw-bold mb-4">{{ __('Reset Password') }}</h4>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="mb-3">
                        <input id="email" type="email"
                               class="form-control rounded-pill px-3 py-2 @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $request->email) }}"
                               required autofocus autocomplete="username"
                               placeholder="Enter your email...">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input id="password" type="password"
                               class="form-control rounded-pill px-3 py-2 @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="New password...">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <input id="password_confirmation" type="password"
                               class="form-control rounded-pill px-3 py-2 @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="Confirm new password...">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
