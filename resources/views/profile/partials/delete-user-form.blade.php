<section class="account-section account-section--danger">
    <div class="account-section__header mb-4">
        <h2 class="account-section__title">{{ __('Delete Account') }}</h2>
        <p class="account-section__subtitle mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please download anything you wish to keep before proceeding.') }}
        </p>
    </div>

    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Delete account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content account-modal">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="confirmUserDeletionLabel">{{ __('Delete your account?') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            {{ __('This action cannot be undone. Enter your password to confirm permanent deletion.') }}
                        </p>

                        <label for="delete_password" class="form-label">{{ __('Password') }}</label>
                        <input
                            id="delete_password"
                            name="password"
                            type="password"
                            class="form-control auth-form__control {{ $errors->userDeletion->has('password') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter your password') }}"
                            required
                        >
                        <x-input-error :messages="$errors->userDeletion->get('password')" />
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-outline-danger">{{ __('Delete account') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if ($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('confirmUserDeletionModal')).show();
        });
    </script>
@endif
