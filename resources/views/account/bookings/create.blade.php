@extends('layouts.app')

@section('content')
<div class="container account-page pb-5">
    @include('includes.account-breadcrumb', ['title' => __('Bookings'), 'current' => __('New request')])

    @if(session('error'))
        <div class="alert alert-danger account-alert">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="account-panel">
                <div class="account-section__header mb-4">
                    <h2 class="account-section__title h5">Request a booking</h2>
                    <p class="account-section__subtitle mb-0">Send a booking request to a model.</p>
                </div>

                <form action="{{ route('account.bookings.store') }}" method="POST" class="account-form">
                    @csrf

                    <div class="auth-form__group">
                        <label class="form-label">Model</label>
                        @if($model)
                            <input type="hidden" name="model_id" value="{{ $model->id }}">
                            <div class="account-notice d-flex align-items-center gap-2">
                                <img src="{{ $model->avatarUrl(48) }}" alt="" class="rounded-circle" width="40" height="40">
                                <strong>{{ $model->displayName() }}</strong>
                            </div>
                        @else
                            <select name="model_id" required class="form-select auth-form__control @error('model_id') is-invalid @enderror">
                                <option value="">Select a model...</option>
                                @foreach(\App\Models\User::where('id', '!=', auth()->id())->with('publicInfo')->orderBy('name')->get() as $u)
                                    <option value="{{ $u->id }}" @selected(old('model_id') == $u->id)>{{ $u->displayName() }}</option>
                                @endforeach
                            </select>
                            @error('model_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @endif
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            placeholder="e.g. Fashion shoot, Brand campaign"
                            class="form-control auth-form__control @error('title') is-invalid @enderror">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">Event date & time</label>
                        <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required
                            class="form-control auth-form__control @error('event_date') is-invalid @enderror">
                        @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">Location <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            placeholder="Studio, city, or address"
                            class="form-control auth-form__control @error('location') is-invalid @enderror">
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="auth-form__group">
                        <label class="form-label">Details <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="description" rows="4"
                            class="form-control auth-form__control @error('description') is-invalid @enderror"
                            placeholder="Describe the shoot, duration, requirements...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Submit request</button>
                        <a href="{{ route('account.bookings.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
