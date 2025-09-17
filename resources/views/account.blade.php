@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-semibold h3 text-dark">
            {{ __('Account') }}
        </h2>
    </div>

    <div class="row g-4">
        <!-- Personal Information -->
        <div class="col-md-6">
            <a href="{{ url('/account/personal') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-vcard fs-3 me-2"></i>
                        <h5 class="mb-0">Personal information</h5>
                    </div>
                    <p class="text-muted mb-0">Provide personal information which will not be shown publicly on your profile</p>
                </div>
            </a>
        </div>

        <!-- Public Information -->
        <div class="col-md-6">
            <a href="{{ url('/account/public') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-eye fs-3 me-2"></i>
                        <h5 class="mb-0">Public information</h5>
                    </div>
                    <p class="text-muted mb-0">Provide details which will be shown publicly on your profile</p>
                </div>
            </a>
        </div>

        <!-- Linked Accounts -->
        <div class="col-md-6">
            <a href="{{ url('/account/linked') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-share fs-3 me-2"></i>
                        <h5 class="mb-0">Linked accounts</h5>
                    </div>
                    <p class="text-muted mb-0">See your account connectivity and add links to your social media and website</p>
                </div>
            </a>
        </div>

        <!-- Notifications -->
        {{-- <div class="col-md-6">
            <a href="{{ url('/account/notifications') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-bell fs-3 me-2"></i>
                        <h5 class="mb-0">Notifications</h5>
                    </div>
                    <p class="text-muted mb-0">Choose what notifications you receive and who can contact you</p>
                </div>
            </a>
        </div> --}}
    </div>
</div>
@endsection
