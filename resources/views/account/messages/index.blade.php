@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Messages'), 'current' => __('Inbox')])

    @if(session('success'))
        <div class="alert alert-success account-alert">{{ session('success') }}</div>
    @endif

    <div class="account-panel">
        <div class="account-section__header mb-4">
            <h2 class="account-section__title h5">Inbox</h2>
            <p class="account-section__subtitle mb-0">
                @if($unreadCount > 0)
                    You have {{ $unreadCount }} unread {{ Str::plural('message', $unreadCount) }}.
                @else
                    All caught up — no unread messages.
                @endif
            </p>
        </div>

        @if($conversations->isEmpty())
            <div class="account-empty-state text-center py-5">
                <i class="bi bi-chat-dots account-empty-state__icon"></i>
                <h3 class="h6 fw-bold mt-3">No messages yet</h3>
                <p class="text-muted mb-0">Visit a model profile to send your first message.</p>
            </div>
        @else
            <div class="account-list">
                @foreach($conversations as $message)
                    @php
                        $partner = $message->sender_id === auth()->id() ? $message->recipient : $message->sender;
                        $isUnread = $message->recipient_id === auth()->id() && $message->isUnread();
                    @endphp
                    <a href="{{ route('account.messages.show', $partner) }}"
                        class="account-list-item {{ $isUnread ? 'account-list-item--unread' : '' }}">
                        <img src="{{ $partner->avatarUrl(80) }}" alt="" class="account-list-item__avatar rounded-circle">
                        <div class="account-list-item__body">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <strong class="account-list-item__title">{{ $partner->displayName() }}</strong>
                                <span class="account-list-item__time">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="account-list-item__preview mb-0">
                                @if($message->sender_id === auth()->id())
                                    <span class="text-muted">You:</span>
                                @endif
                                {{ Str::limit($message->body, 80) }}
                            </p>
                        </div>
                        @if($isUnread)
                            <span class="account-list-item__badge"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
