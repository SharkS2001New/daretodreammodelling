@extends('layouts.console')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Console') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="container" style="max-width: 1000px;">
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="text-center fw-bold">{{ __("You're logged in !!!") }} &nbsp;:-&nbsp; <a href="/" class="text-primary">View Website</a> &nbsp;:-&nbsp;
        <a href="/clear-cache" class="text-danger">Clear Cache</a>
    </div>
    <br/>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="py-4"> 
                    <div class="container">
                        <h4 class="mb-4">Manage Website Pages</h4>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <a href="{{ url('/seo-metas') }}" class="btn btn-outline-danger w-100">
                                    Manage Website Seo Metas
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('/landing/1/edit') }}" class="btn btn-outline-primary w-100">
                                    Landing Page
                                </a>
                            </div>                           
                            <div class="col-md-6">
                                <a href="{{ url('/about/1/edit') }}" class="btn btn-outline-primary w-100">
                                    About Us
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('/contact-us/edit') }}" class="btn btn-outline-primary w-100">
                                    Contact Us
                                </a>
                            </div>                                                     
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    // Fade out after 10 seconds (10000 milliseconds)
    setTimeout(function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 1s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 1000); // Remove element after fade
        }
    }, 10000);
</script>
@endsection
