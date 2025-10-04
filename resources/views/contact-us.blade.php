@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Page Header -->
            <div class="text-center mb-2">
                <h1 class="display-5 fw-bold text-dark mb-2">Contact Us</h1>
                <p class="lead text-muted mb-2">
                    For general advice on how to use our platform please see our <a href="/faq">FAQ</a> or send to us your enquiry via the email below!
                </p>
            </div>

            <!-- Contact Information -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center">
                        <h4 class="fw-bold mb-4">Fashion Designer</h4>
                        <p class="fs-5 mb-1">Vicklyne Gatwiri</p>
                        <p class="text-muted mb-3">Email: 
                            <a href="mailto:vicklyneg@gmail.com" class="text-decoration-none">
                                vicklyneg@gmail.com
                            </a>
                        </p>
                        <p class="text-muted mb-4">Tel: 0703812218</p>
                    </div>

                    <hr class="my-5">

                    <!-- Company Information -->
                    <div class="text-center">
                        <h5 class="fw-bold text-uppercase mb-4">Dare to Dream Modelling Agency</h5>
                        <p class="mb-1">Talent Management Services</p>
                        <p class="mb-1">Nairobi, Kenya</p>
                        <p class="mb-0">Business Registration No: BN-7ZC52M52</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    border-radius: 12px;
}
.display-5 {
    font-size: 2.5rem;
}
.lead {
    font-size: 1.25rem;
}
</style>
@endsection