@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-semibold h4 text-dark">
            {{ __('Profile') }}
        </h2>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <!-- Update Profile Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
