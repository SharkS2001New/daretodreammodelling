@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @php
        $user = auth()->user();
        $publicInfo = $user->publicInfo;
        $photoCount = $user->photos()->count();

        $steps = [
            ['done' => !empty($publicInfo?->about_me), 'label' => 'Write about you', 'url' => route('account.public.edit'), 'icon' => 'bi-pencil-square'],
            ['done' => !empty($publicInfo?->profile_picture), 'label' => 'Upload profile photo', 'url' => route('account.public.edit'), 'icon' => 'bi-camera-fill'],
            ['done' => $photoCount >= 3, 'label' => 'Upload 3 photos', 'url' => route('models.show', ['slug' => $user->slug, 'tab' => 'photos']), 'icon' => 'bi-images'],
        ];

        $completed = collect($steps)->where('done', true)->count();
        $percent = (int) round(($completed / count($steps)) * 100);
    @endphp

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <p class="account-page__eyebrow text-uppercase fw-semibold mb-2">Welcome back</p>
            <h1 class="account-page__title mb-1">{{ __('Dashboard') }}</h1>
            <p class="text-muted mb-0">Hi {{ $user->name }}, complete your profile to get discovered.</p>
        </div>

        @if($user->is_admin == 1)
            <a href="{{ url('/console') }}" class="btn btn-outline-primary btn-sm">
                {{ __('Admin console') }}
            </a>
        @endif
    </div>

    @if (! $user->hasVerifiedEmail())
        <div class="account-alert account-alert--warning mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ __('Please verify your email address.') }}
                    <span class="text-muted d-block d-sm-inline ms-sm-2">{{ $user->email }}</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">{{ __('Resend email') }}</button>
                    </form>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit email') }}</a>
                </div>
            </div>
        </div>
    @endif

    <div class="account-panel mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <h2 class="h5 fw-bold mb-0">Profile completion</h2>
            <span class="account-progress-badge">{{ $percent }}%</span>
        </div>

        <div class="progress account-progress mb-4" role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: {{ $percent }}%"></div>
        </div>

        <div class="row g-3">
            @foreach ($steps as $step)
                <div class="col-md-4">
                    <a href="{{ $step['url'] }}" class="account-step-card {{ $step['done'] ? 'is-complete' : '' }}">
                        <div class="account-step-card__icon">
                            <i class="bi {{ $step['done'] ? 'bi-check-circle-fill' : $step['icon'] }}"></i>
                        </div>
                        <span>{{ $step['label'] }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('account.public.edit') }}" class="account-nav-card account-nav-card--compact text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-eye-fill"></i></div>
                <div>
                    <h3 class="account-nav-card__title h6">Edit public profile</h3>
                    <p class="account-nav-card__text mb-0">Update measurements, bio, and photo.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('models.show', ['slug' => $user->slug]) }}" class="account-nav-card account-nav-card--compact text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-person-badge-fill"></i></div>
                <div>
                    <h3 class="account-nav-card__title h6">View my profile</h3>
                    <p class="account-nav-card__text mb-0">See how your page looks to visitors.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ url('/account') }}" class="account-nav-card account-nav-card--compact text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-gear-fill"></i></div>
                <div>
                    <h3 class="account-nav-card__title h6">Account settings</h3>
                    <p class="account-nav-card__text mb-0">Manage personal and linked accounts.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
