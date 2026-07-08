@extends('layouts.console')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Model settings') }} — {{ $managedUser->displayName() }}
    </h2>
@endsection

@section('content')
<div class="py-2">
    <div class="container account-page pb-5" style="max-width: 900px;">
        <div class="mb-3">
            <a href="{{ route('console.models.index') }}" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left"></i> All models
            </a>
            <span class="text-muted small mx-2">·</span>
            <a href="{{ route('models.show', $managedUser->slug) }}" class="text-muted small text-decoration-none">
                View public profile
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success account-alert">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger account-alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="account-panel mb-4">
            <div class="account-section__header mb-4">
                <h2 class="account-section__title h5">Profile picture</h2>
                <p class="account-section__subtitle mb-0">Update the headshot shown on {{ $managedUser->displayName() }}'s public profile.</p>
            </div>

            <form action="{{ route('console.models.profile-picture.update', $managedUser) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4">
                    <img src="{{ $managedUser->avatarUrl(150) }}" width="150" height="150" class="rounded-circle border object-fit-cover" alt="Profile preview">
                    <div class="flex-grow-1 w-100">
                        <div class="mb-3">
                            <input type="file" name="profile_picture" accept="image/*" class="form-control auth-form__control" required>
                            <div class="form-text">Max file size: 2MB. Supported: JPG, PNG, JPEG</div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Upload profile picture</button>
                    </div>
                </div>
            </form>
        </div>

        <form action="{{ route('console.models.public.update', $managedUser) }}" method="POST">
            @csrf
            <div class="account-panel mb-4">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Public information</h2>
                    <p class="account-section__subtitle mb-0">Details shown on the model's public profile.</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Display name</label>
                        <input type="text" name="display_name" value="{{ old('display_name', $managedPublicInfo?->display_name ?? '') }}" class="form-control auth-form__control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" value="{{ old('age', $managedPublicInfo?->age ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            @foreach(['Male', 'Female', 'Other'] as $gender)
                                <option value="{{ $gender }}" @selected(old('gender', $managedPublicInfo?->gender ?? '') === $gender)>{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ethnicity</label>
                        <select name="ethnicity" class="form-control">
                            <option value="">Select Ethnicity</option>
                            @foreach(['Black/African','White/Caucasian','Hispanic/Latino','Asian','Middle Eastern','Mixed','Other'] as $ethnicity)
                                <option value="{{ $ethnicity }}" @selected(old('ethnicity', $managedPublicInfo?->ethnicity ?? '') === $ethnicity)>{{ $ethnicity }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hair</label>
                        <input type="text" name="hair" value="{{ old('hair', $managedPublicInfo?->hair ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Eye color</label>
                        <input type="text" name="eye" value="{{ old('eye', $managedPublicInfo?->eye ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Height</label>
                        <input type="text" name="height" value="{{ old('height', $managedPublicInfo?->height ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Shoe size</label>
                        <input type="text" name="shoes" value="{{ old('shoes', $managedPublicInfo?->shoes ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waist</label>
                        <input type="text" name="waist" value="{{ old('waist', $managedPublicInfo?->waist ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hips</label>
                        <input type="text" name="hips" value="{{ old('hips', $managedPublicInfo?->hips ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" value="{{ old('location', $managedPublicInfo?->location ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nationality</label>
                        <input type="text" name="nationality" value="{{ old('nationality', $managedPublicInfo?->nationality ?? '') }}" class="form-control">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Languages <span class="text-muted fw-normal">(comma-separated)</span></label>
                        <input type="text" name="languages" value="{{ old('languages', is_array(old('languages')) ? implode(',', old('languages')) : ($managedPublicInfo?->languages ?? '')) }}" class="form-control" placeholder="English, French">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">About</label>
                        <textarea name="about_me" rows="4" class="form-control">{{ old('about_me', $managedPublicInfo?->about_me ?? '') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save public information</button>
            </div>
        </form>

        <div class="account-panel mb-4">
            <div class="account-section__header mb-4">
                <h2 class="account-section__title h5">Photos &amp; videos</h2>
                <p class="account-section__subtitle mb-0">Upload or remove media from the model's public profile page.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('models.show', ['slug' => $managedUser->slug, 'tab' => 'photos']) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-images"></i> Manage photos
                </a>
                <a href="{{ route('models.show', ['slug' => $managedUser->slug, 'tab' => 'videos']) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-camera-video"></i> Manage videos
                </a>
            </div>
        </div>

        <form action="{{ route('console.models.linked.update', $managedUser) }}" method="POST">
            @csrf
            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Social links</h2>
                    <p class="account-section__subtitle mb-0">Instagram, Twitter, YouTube, and website links. TikTok must be connected by the model from their own account.</p>
                </div>

                <div class="auth-form__group">
                    <label class="form-label">Instagram URL</label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $managedLinkedAccount->instagram_url ?? '') }}" class="form-control auth-form__control">
                </div>
                <div class="auth-form__group">
                    <label class="form-label">Twitter URL</label>
                    <input type="url" name="twitter_url" value="{{ old('twitter_url', $managedLinkedAccount->twitter_url ?? '') }}" class="form-control auth-form__control">
                </div>
                <div class="auth-form__group">
                    <label class="form-label">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $managedLinkedAccount->youtube_url ?? '') }}" class="form-control auth-form__control">
                </div>
                <div class="auth-form__group">
                    <label class="form-label">Website</label>
                    <input type="url" name="other_url" value="{{ old('other_url', $managedLinkedAccount->other_url ?? '') }}" class="form-control auth-form__control">
                </div>

                <button type="submit" class="btn btn-primary">Save social links</button>
            </div>
        </form>
    </div>
</div>
@endsection
