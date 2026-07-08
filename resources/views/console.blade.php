@extends('layouts.console')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Console') }}
    </h2>
@endsection

@section('content')
<div class="py-2">
    <div class="container mb-3" style="max-width: 1000px;">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Left (Success Alert) -->
            <div class="fw-bold flex-grow-1">
                {{ __("You're logged in !!!") }} &nbsp;:-&nbsp; 
                <a href="/" class="text-primary">View Website</a> &nbsp;:-&nbsp;
                <a href="{{ route('clear-cache') }}" class="text-danger">Clear Cache</a>
            </div>

            <!-- Right (Modelling Page Button) -->
            <div>
                <a href="/dashboard" class="btn btn-outline-primary btn-sm">
                    View My Modelling Page
                </a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success py-2 px-3 mb-3 mt-3" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="py-4"> 
                    <div class="container">
                        <h4 class="mb-4">Manage Website Pages</h4>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <a href="{{ route('console.models.create') }}" class="btn btn-primary w-100">
                                    Register Model
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('console.models.index') }}" class="btn btn-outline-primary w-100">
                                    Manage Models
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('seo-metas.index') }}" class="btn btn-outline-danger w-100">
                                    Manage Website Seo Metas
                                </a>
                            </div>
                            {{-- <div class="col-md-6">
                                <a href="{{ url('/landing/1/edit') }}" class="btn btn-outline-primary w-100">
                                    Landing Page
                                </a>
                            </div>                           
                            <div class="col-md-6">
                                <a href="{{ url('/about/1/edit') }}" class="btn btn-outline-primary w-100">
                                    About Us
                                </a>
                            </div> --}}
                            <div class="col-md-6">
                                <a href="{{ route('testimonials.index') }}" class="btn btn-outline-primary w-100">
                                   Testimonials
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('blogs.create') }}" class="btn btn-outline-primary w-100">
                                   Add Blog
                                </a>
                            </div>    
                            <div class="col-md-6">
                                <a href="{{ route('blogs-categories.index') }}" class="btn btn-outline-primary w-100">
                                  Blog Categories
                                </a>
                            </div>  
                            {{-- <div class="col-md-6">
                                <a href="{{ url('/contact-us/edit') }}" class="btn btn-outline-primary w-100">
                                    Contact Us
                                </a>
                            </div>                                                      --}}
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
