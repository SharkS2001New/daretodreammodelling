@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Reviews'), 'current' => __('Your reviews')])

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="account-panel text-center">
                <p class="text-muted small mb-1">Average rating</p>
                <div class="account-rating-display">
                    @if($averageRating)
                        <span class="account-rating-display__value">{{ number_format($averageRating, 1) }}</span>
                        <div class="account-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($averageRating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                    @else
                        <span class="account-rating-display__value">—</span>
                        <p class="text-muted small mb-0">No reviews yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Reviews about you</h2>
                    <p class="account-section__subtitle mb-0">Feedback from clients and collaborators.</p>
                </div>

                @if($received->isEmpty())
                    <p class="text-muted mb-0">No reviews received yet.</p>
                @else
                    @foreach($received as $review)
                        @include('account.reviews.partials.review-card', ['review' => $review, 'type' => 'received'])
                    @endforeach
                    <div class="mt-3">{{ $received->links() }}</div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Reviews you've written</h2>
                    <p class="account-section__subtitle mb-0">Reviews you've left for other models.</p>
                </div>

                @if($given->isEmpty())
                    <p class="text-muted mb-0">You haven't written any reviews yet.</p>
                @else
                    @foreach($given as $review)
                        @include('account.reviews.partials.review-card', ['review' => $review, 'type' => 'given'])
                    @endforeach
                    <div class="mt-3">{{ $given->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
