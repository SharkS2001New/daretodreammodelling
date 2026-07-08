@extends('layouts.console')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Register Model') }}
    </h2>
@endsection

@section('content')
<div class="py-2">
    <div class="container account-page pb-5" style="max-width: 700px;">
        <div class="mb-3">
            <a href="{{ route('console.models.index') }}" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left"></i> All models
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger account-alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="account-panel">
            <div class="account-section__header mb-4">
                <h2 class="account-section__title h5">Create model account</h2>
                <p class="account-section__subtitle mb-0">
                    Register a new model on their behalf. They will be asked to set their own password on first login.
                </p>
            </div>

            <form method="POST" action="{{ route('console.models.store') }}" class="account-form">
                @csrf

                <div class="auth-form__group">
                    <label for="name" class="form-label">Full name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="form-control auth-form__control @error('name') is-invalid @enderror"
                        placeholder="e.g. Jane Doe">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-form__group">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="form-control auth-form__control @error('email') is-invalid @enderror"
                        placeholder="model@example.com">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="auth-form__group">
                    <label for="password" class="form-label">Temporary password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password" required
                        class="form-control auth-form__control @error('password') is-invalid @enderror">
                    <div class="form-text">The model must change this password when they log in for the first time.</div>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="auth-form__group">
                            <label for="password_confirmation" class="form-label">Confirm password <span class="text-danger">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="form-control auth-form__control">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <p class="text-muted small mb-3">Optional — you can also fill these in on the settings page after creating the account.</p>

                <div class="auth-form__group">
                    <label for="display_name" class="form-label">Display name</label>
                    <input type="text" id="display_name" name="display_name" value="{{ old('display_name') }}"
                        class="form-control auth-form__control" placeholder="Public name on profile">
                </div>

                <div class="auth-form__group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                        class="form-control auth-form__control" placeholder="e.g. Nairobi, Kenya">
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">Create model account</button>
                    <a href="{{ route('console.models.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
