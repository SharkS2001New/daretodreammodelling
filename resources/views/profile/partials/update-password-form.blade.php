<section class="account-section">
    <div class="account-section__header mb-4">
        <h2 class="account-section__title">{{ __('Update Password') }}</h2>
        <p class="account-section__subtitle mb-0">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="account-form">
        @csrf
        @method('put')

        <div class="auth-form__group">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="auth-form__group">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="auth-form__group">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button>{{ __('Update password') }}</x-primary-button>
            @if (session('status') === 'password-updated')
                <span class="text-success small fw-semibold">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
