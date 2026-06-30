@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Followers'), 'current' => __('Your network')])

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Followers</h2>
                    <p class="account-section__subtitle mb-0">People who follow your profile.</p>
                </div>

                @if($followers->isEmpty())
                    <div class="account-empty-state text-center py-4">
                        <i class="bi bi-people account-empty-state__icon"></i>
                        <p class="text-muted mb-0 mt-2">No followers yet.</p>
                    </div>
                @else
                    <div class="account-list">
                        @foreach($followers as $follower)
                            @php $followerUser = $follower->user; @endphp
                            <div class="account-list-item account-list-item--static">
                                <img src="{{ $followerUser->avatarUrl(80) }}" alt="" class="account-list-item__avatar rounded-circle">
                                <div class="account-list-item__body">
                                    <strong class="account-list-item__title">{{ $followerUser->displayName() }}</strong>
                                    <p class="account-list-item__preview mb-0 text-muted small">
                                        Following since {{ $follower->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <a href="{{ route('models.show', $followerUser->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">{{ $followers->links() }}</div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Following</h2>
                    <p class="account-section__subtitle mb-0">Models you follow.</p>
                </div>

                @if($following->isEmpty())
                    <div class="account-empty-state text-center py-4">
                        <i class="bi bi-person-plus account-empty-state__icon"></i>
                        <p class="text-muted mb-0 mt-2">You're not following anyone yet.</p>
                    </div>
                @else
                    <div class="account-list">
                        @foreach($following as $follow)
                            @php $model = $follow->model; @endphp
                            <div class="account-list-item account-list-item--static">
                                <img src="{{ $model->avatarUrl(80) }}" alt="" class="account-list-item__avatar rounded-circle">
                                <div class="account-list-item__body">
                                    <strong class="account-list-item__title">{{ $model->displayName() }}</strong>
                                    <p class="account-list-item__preview mb-0 text-muted small">
                                        Followed since {{ $follow->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <a href="{{ route('models.show', $model->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">{{ $following->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
