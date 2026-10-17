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
                    <p class="account-section__subtitle mb-0">These show as icons on your public profile. Leave a field empty to hide that icon.</p>
                </div>

                <form action="{{ route('account.linked.update') }}" method="POST" class="account-form">
                    @csrf

                    <div class="auth-form__group">
                        <label class="form-label"><i class="bi bi-facebook text-primary"></i> Facebook URL</label>
                        <input type="url" name="facebook_url"
                            value="{{ old('facebook_url', $linkedAccount->facebook_url ?? '') }}"
                            placeholder="https://www.facebook.com/yourusername"
                            class="form-control auth-form__control @error('facebook_url') is-invalid @enderror">
                        @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label"><i class="bi bi-instagram" style="color:#e5229f"></i> Instagram URL</label>
                        <input type="url" name="instagram_url"
                            value="{{ old('instagram_url', $linkedAccount->instagram_url ?? '') }}"
                            placeholder="https://www.instagram.com/yourusername"
                            class="form-control auth-form__control @error('instagram_url') is-invalid @enderror">
                        @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label"><i class="bi bi-tiktok"></i> TikTok URL</label>
                        <input type="url" name="tiktok_url"
                            value="{{ old('tiktok_url', $linkedAccount->tiktok_url ?? '') }}"
                            placeholder="https://www.tiktok.com/@yourusername"
                            class="form-control auth-form__control @error('tiktok_url') is-invalid @enderror">
                        @error('tiktok_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Your profile link. This is separate from connecting TikTok above to show your videos.</div>
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label"><i class="bi bi-twitter-x"></i> Twitter / X URL</label>
                        <input type="url" name="twitter_url"
                            value="{{ old('twitter_url', $linkedAccount->twitter_url ?? '') }}"
                            placeholder="https://www.twitter.com/yourusername"
                            class="form-control auth-form__control @error('twitter_url') is-invalid @enderror">
                        @error('twitter_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label"><i class="bi bi-youtube text-danger"></i> YouTube URL</label>
                        <input type="url" name="youtube_url"
                            value="{{ old('youtube_url', $linkedAccount->youtube_url ?? '') }}"
                            placeholder="https://www.youtube.com/yourchannel"
                            class="form-control auth-form__control @error('youtube_url') is-invalid @enderror">
                        @error('youtube_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label"><i class="bi bi-globe"></i> Website</label>
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
