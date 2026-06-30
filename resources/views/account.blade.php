@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    <div class="account-page__header mb-4">
        <p class="account-page__eyebrow text-uppercase fw-semibold mb-2">Your profile</p>
        <h1 class="account-page__title mb-1">{{ __('Account') }}</h1>
        <p class="text-muted mb-0">Manage your personal details, public profile, and connected social accounts.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('profile.edit') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-person-vcard-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Personal information</h2>
                    <p class="account-nav-card__text mb-0">Update your name, email, and password. This information is not shown publicly.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('account.public.edit') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-eye-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Public information</h2>
                    <p class="account-nav-card__text mb-0">Add details and a photo that appear on your model profile.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('account.linked') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-share-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Linked accounts</h2>
                    <p class="account-nav-card__text mb-0">Connect TikTok and add links to your social media profiles.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('account.messages.index') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-chat-dots-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Messages</h2>
                    <p class="account-nav-card__text mb-0">View and reply to conversations with clients and models.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('account.bookings.index') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-calendar-event-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Bookings</h2>
                    <p class="account-nav-card__text mb-0">Manage booking requests you've received or submitted.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('account.followers.index') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-people-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Followers</h2>
                    <p class="account-nav-card__text mb-0">See who follows you and who you're following.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('account.reviews.index') }}" class="account-nav-card text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-star-fill"></i></div>
                <div>
                    <h2 class="account-nav-card__title">Reviews</h2>
                    <p class="account-nav-card__text mb-0">Read feedback about you and reviews you've written.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
