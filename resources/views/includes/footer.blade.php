<footer class="site-footer bg-dark text-white">
    <div class="container">
        <div class="row g-4 site-footer__main">
            <div class="col-lg-5 col-md-6">
                <p class="site-footer__eyebrow text-uppercase fw-semibold mb-2">DD Models Agency</p>
                <h4 class="site-footer__brand fw-bold mb-1">Dare to Dream</h4>
                <p class="site-footer__tagline mb-3">Modelling Agency</p>
                <p class="site-footer__text mb-0">
                    We empower young talent to launch modelling careers with passion, confidence, and inclusivity.
                </p>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6 class="site-footer__heading fw-bold">Company</h6>
                <ul class="list-unstyled site-footer__links">
                    <li><a href="{{ route('about-us') }}">About us</a></li>
                    <li><a href="{{ route('upcoming-activities') }}">Activities</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                    <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6 class="site-footer__heading fw-bold">Privacy</h6>
                <ul class="list-unstyled site-footer__links">
                    <li><a href="{{ url('/privacy-policy') }}">Privacy policy</a></li>
                    <li><a href="{{ url('/terms-of-use') }}">Terms of use</a></li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-3">
                <h6 class="site-footer__heading fw-bold">Help</h6>
                <ul class="list-unstyled site-footer__links">
                    <li><a href="{{ url('/how-it-works') }}">How it works</a></li>
                    <li><a href="{{ route('modelling-advice') }}">Modelling advice</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="site-footer__bottom">
            <div class="site-footer__social">
                <a href="https://www.facebook.com/profile.php?id=100028941746406" class="site-footer__social-link" target="_blank" rel="noopener" aria-label="Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://www.instagram.com/dd_models/" class="site-footer__social-link" target="_blank" rel="noopener" aria-label="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@ddmodels96" class="site-footer__social-link" target="_blank" rel="noopener" aria-label="TikTok">
                    <i class="bi bi-tiktok"></i>
                </a>
            </div>

            <p class="site-footer__copy mb-0">
                &copy; {{ date('Y') }} Dare to Dream Modelling Agency. All rights reserved.
            </p>
        </div>
    </div>
</footer>
