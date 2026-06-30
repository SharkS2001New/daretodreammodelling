@extends('layouts.frontend')

@section('content')
<div class="container pb-5">
    <x-page-heading subtitle="Have a question, booking enquiry, or want to join DD Models? We would love to hear from you." />

    <div class="row g-4 align-items-stretch">
        <div class="col-lg-4">
            <div class="contact-intro h-100">
                <p class="contact-intro__eyebrow text-uppercase fw-semibold mb-2">Get in touch</p>
                <h2 class="section-heading fw-bold mb-3">Let's connect</h2>
                <p class="text-muted mb-4">
                    Whether you are an aspiring model, a brand looking for talent, or simply curious about our agency,
                    our team is ready to help.
                </p>
                <p class="fw-medium mb-4">
                    DD Models Agency – Dare To Dream. Develop. Shine. Succeed. ✨
                </p>
                <a href="{{ route('faq') }}" class="btn btn-outline-secondary rounded-pill">
                    View FAQ
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <a href="tel:+254768562962" class="contact-card text-decoration-none h-100">
                        <div class="contact-card__icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <p class="contact-card__label mb-1">Phone</p>
                            <p class="contact-card__value mb-0">0768 562 962</p>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6">
                    <a href="mailto:ddmodelske@gmail.com" class="contact-card text-decoration-none h-100">
                        <div class="contact-card__icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <p class="contact-card__label mb-1">Email</p>
                            <p class="contact-card__value mb-0">ddmodelske@gmail.com</p>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6">
                    <a href="https://www.instagram.com/dd_models/" target="_blank" rel="noopener" class="contact-card text-decoration-none h-100">
                        <div class="contact-card__icon">
                            <i class="bi bi-instagram"></i>
                        </div>
                        <div>
                            <p class="contact-card__label mb-1">Instagram</p>
                            <p class="contact-card__value mb-0">@dd_models</p>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6">
                    <a href="https://www.tiktok.com/@ddmodels96" target="_blank" rel="noopener" class="contact-card text-decoration-none h-100">
                        <div class="contact-card__icon">
                            <i class="bi bi-tiktok"></i>
                        </div>
                        <div>
                            <p class="contact-card__label mb-1">TikTok</p>
                            <p class="contact-card__value mb-0">@ddmodels96</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="contact-agency-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="contact-card__icon contact-card__icon--compact flex-shrink-0">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h3 class="h5 fw-bold mb-2">Dare to Dream Modelling Agency</h3>
                        <p class="text-muted mb-1">Talent Management Services</p>
                        <p class="text-muted mb-1">Nairobi, Kenya</p>
                        <p class="text-muted mb-0 small">Business Registration No: BN-7ZC52M52</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
