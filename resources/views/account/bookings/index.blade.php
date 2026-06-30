@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Bookings'), 'current' => __('Manage bookings')])

    @if(session('success'))
        <div class="alert alert-success account-alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger account-alert">{{ session('error') }}</div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <p class="text-muted mb-0">Track booking requests you've received and submitted.</p>
        <a href="{{ route('account.bookings.create') }}" class="btn btn-primary btn-sm">New booking request</a>
    </div>

    <div class="account-panel mb-4">
        <div class="account-section__header mb-4">
            <h2 class="account-section__title h5">Received as model</h2>
            <p class="account-section__subtitle mb-0">Booking requests from clients.</p>
        </div>

        @if($asModel->isEmpty())
            <p class="text-muted mb-0">No booking requests received yet.</p>
        @else
            @foreach($asModel as $booking)
                @include('account.bookings.partials.card', ['booking' => $booking, 'role' => 'model'])
            @endforeach
            <div class="mt-3">{{ $asModel->links() }}</div>
        @endif
    </div>

    <div class="account-panel">
        <div class="account-section__header mb-4">
            <h2 class="account-section__title h5">Submitted by you</h2>
            <p class="account-section__subtitle mb-0">Bookings you've requested.</p>
        </div>

        @if($asClient->isEmpty())
            <p class="text-muted mb-0">You haven't submitted any booking requests.</p>
        @else
            @foreach($asClient as $booking)
                @include('account.bookings.partials.card', ['booking' => $booking, 'role' => 'client'])
            @endforeach
            <div class="mt-3">{{ $asClient->links() }}</div>
        @endif
    </div>
</div>
@endsection
