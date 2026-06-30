{{-- resources/views/how-it-works.blade.php --}}
@extends('layouts.frontend')

@section('content')
<div class="container">
    {{-- Hero Section --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-3">
            <h1 class="fw-bold text-success">Join the world's best modelling community</h1>
            <p class="lead">
                Create your free profile — add photos, videos and measurements. 
                Get moderated, learn with our Model Academy and apply to castings.
            </p>
            
            <a href="{{ route('register') }}" class="btn btn-sm btn-outline-success fw-bold">
                Create your free profile
            </a>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('hero-training-bw.png') }}" 
                 alt="Dare to Dream modelling session" 
                 class="img-fluid rounded shadow">
        </div>
    </div>

    {{-- How it Works Steps --}}
    <div class="text-center mb-4">
        <h2 class="section-heading fw-bold">How it Works</h2>
    </div>
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="p-4 border rounded bg-light h-100">
                <h3 class="h5 fw-bold">1. Create your profile</h3>
                <p>Upload your photos, add measurements and tell us what makes you unique.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded bg-light h-100">
                <h3 class="h5 fw-bold">2. Get approved</h3>
                <p>Our team reviews profiles to keep the community professional and safe.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded bg-light h-100">
                <h3 class="h5 fw-bold">3. Apply & get booked</h3>
                <p>Find castings, apply and receive secure bookings or contracts.</p>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="row align-items-center my-5">
        <div class="col-md-6">
            <h2 class="fw-bold">Why choose Dare to Dream</h2>
            <ul class="list-unstyled mt-3">
                <li class="mb-2">✔ Expert moderation and safe bookings</li>
                <li class="mb-2">✔ Model Academy training and resources</li>
                <li class="mb-2">✔ Direct messaging with professionals</li>
                <li class="mb-2">✔ Mobile app access (coming soon)</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('models-row-bw.png') }}" 
                 alt="Models in a training session" 
                 class="img-fluid rounded shadow">
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="text-center py-5 bg-light rounded shadow-sm">
        <h2 class="fw-bold">Ready to start your modelling journey?</h2>
        <p class="lead">Sign up now and become part of Dare to Dream Modelling Agency.</p>
        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-success fw-bold">
            Get Started
        </a>
    </div>
</div>
@endsection
