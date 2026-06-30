@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Messages'), 'current' => $user->displayName()])

    @if(session('success'))
        <div class="alert alert-success account-alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger account-alert">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="account-panel account-message-thread">
                <div class="account-message-thread__header mb-4">
                    <img src="{{ $user->avatarUrl(80) }}" alt="" class="rounded-circle" width="48" height="48">
                    <div>
                        <h2 class="h6 fw-bold mb-0">{{ $user->displayName() }}</h2>
                        <a href="{{ route('models.show', $user->slug) }}" class="small text-muted">View profile</a>
                    </div>
                </div>

                <div class="account-message-thread__messages mb-4">
                    @forelse($thread as $message)
                        <div class="account-message {{ $message->sender_id === auth()->id() ? 'account-message--sent' : 'account-message--received' }}">
                            <div class="account-message__bubble">
                                @if($message->subject)
                                    <strong class="d-block mb-1 small">{{ $message->subject }}</strong>
                                @endif
                                <p class="mb-1">{{ $message->body }}</p>
                                <span class="account-message__time">{{ $message->created_at->format('M d, g:i A') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4 mb-0">No messages yet. Say hello below.</p>
                    @endforelse
                </div>

                <form action="{{ route('account.messages.store', $user) }}" method="POST" class="account-form">
                    @csrf
                    <div class="auth-form__group">
                        <label class="form-label">Subject <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                            class="form-control auth-form__control @error('subject') is-invalid @enderror">
                        @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="auth-form__group">
                        <label class="form-label">Message</label>
                        <textarea name="body" rows="4" required
                            class="form-control auth-form__control @error('body') is-invalid @enderror"
                            placeholder="Write your message...">{{ old('body') }}</textarea>
                        @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <a href="{{ route('account.messages.index') }}" class="account-nav-card account-nav-card--compact text-decoration-none">
                <div class="account-nav-card__icon"><i class="bi bi-arrow-left"></i></div>
                <div>
                    <h3 class="account-nav-card__title h6">Back to inbox</h3>
                    <p class="account-nav-card__text mb-0">View all conversations.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const thread = document.querySelector('.account-message-thread__messages');
    if (thread) {
        thread.scrollTop = thread.scrollHeight;
    }
});
</script>
@endpush
