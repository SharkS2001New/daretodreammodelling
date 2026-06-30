@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Linked accounts'), 'current' => __('Social links')])

    @if(session('success'))
        <div class="alert alert-success account-alert">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="account-panel mb-4">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">TikTok</h2>
                    <p class="account-section__subtitle mb-0">Connect your TikTok account to display videos on your profile.</p>
                </div>

                <div class="account-social-row">
                    <div class="account-social-row__brand">
                        <div class="account-social-row__icon account-social-row__icon--tiktok">
                            <i class="bi bi-tiktok"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-1">TikTok</h3>
                            <p class="text-muted small mb-0">Show your latest videos on your model page.</p>
                        </div>
                    </div>
                    <div class="account-social-row__actions">
                        @if($linkedAccount->hasTikTokConnection())
                            <span class="badge account-badge account-badge--success">Connected</span>
                            <form action="{{ route('tiktok.disconnect') }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to disconnect your TikTok account?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Disconnect</button>
                            </form>
                        @else
                            <a href="{{ route('tiktok.connect') }}" class="btn btn-sm btn-primary">Connect TikTok</a>
                        @endif
                    </div>
                </div>

                @if($linkedAccount->hasTikTokConnection())
                    <p class="text-success small mb-0 mt-3">
                        <i class="bi bi-check-circle-fill me-1"></i> Your TikTok feed will display on your profile.
                    </p>
                @endif
            </div>

            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Social links</h2>
                    <p class="account-section__subtitle mb-0">Add URLs to your other social profiles and websites.</p>
                </div>

                <form action="{{ route('account.linked.update') }}" method="POST" class="account-form">
                    @csrf

                    <div class="auth-form__group">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" name="instagram_url"
                            value="{{ old('instagram_url', $linkedAccount->instagram_url ?? '') }}"
                            placeholder="https://www.instagram.com/yourusername"
                            class="form-control auth-form__control @error('instagram_url') is-invalid @enderror">
                        @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" name="twitter_url"
                            value="{{ old('twitter_url', $linkedAccount->twitter_url ?? '') }}"
                            placeholder="https://www.twitter.com/yourusername"
                            class="form-control auth-form__control @error('twitter_url') is-invalid @enderror">
                        @error('twitter_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">YouTube URL</label>
                        <input type="url" name="youtube_url"
                            value="{{ old('youtube_url', $linkedAccount->youtube_url ?? '') }}"
                            placeholder="https://www.youtube.com/yourchannel"
                            class="form-control auth-form__control @error('youtube_url') is-invalid @enderror">
                        @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">Website</label>
                        <input type="url" name="other_url"
                            value="{{ old('other_url', $linkedAccount->other_url ?? '') }}"
                            placeholder="https://example.com"
                            class="form-control auth-form__control @error('other_url') is-invalid @enderror">
                        @error('other_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Add any other social profile or personal website.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save links</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
