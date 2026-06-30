<section class="account-section">
    <div class="account-section__header mb-4">
        <h2 class="account-section__title">{{ __('Profile Information') }}</h2>
        <p class="account-section__subtitle mb-0">{{ __("Update your account's profile information and email address.") }}</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="account-form">
        @csrf
        @method('patch')

        <div class="auth-form__group">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="auth-form__group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="account-notice mt-2">
                    <p class="mb-2">{{ __('Your email address is unverified.') }}</p>
                    <button form="send-verification" type="submit" class="btn btn-sm btn-outline-primary">
                        {{ __('Resend verification email') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small mb-0 mt-2">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button>{{ __('Save changes') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <span class="text-success small fw-semibold">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
