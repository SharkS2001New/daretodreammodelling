@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Profile'), 'current' => __('Personal information')])

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="account-panel mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="account-panel mb-4">
                @include('profile.partials.update-password-form')
            </div>

            <div class="account-panel account-panel--danger">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
