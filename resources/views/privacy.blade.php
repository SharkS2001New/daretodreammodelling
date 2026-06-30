@extends('layouts.frontend')

@section('content')
<section id="privacy-policy" class="section">
  <div class="container" data-aos="fade-up">
    <x-page-heading class="mb-2" />
    <p class="text-muted mb-5">
      Last updated: {{ now()->format('F d, Y') }}
    </p>

    <div class="mb-4">
      <h5 class="fw-bold">1. Introduction</h5>
      <p>
        This Privacy Policy explains how {{ config('app.name') }} collects, uses, and
        protects your personal information when you use our website and related services.
        By joining our platform, you agree to the practices described here.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">2. What Data We Collect</h5>
      <p>Depending on how you use our platform, we may collect:</p>
      <ul>
        <li>Name, username, or company name</li>
        <li>Email address and phone number</li>
        <li>Password (encrypted)</li>
        <li>Date of birth and gender</li>
        <li>Profile information such as bio, portfolio links, and social media</li>
        <li>Uploaded images, videos, or other media</li>
        <li>Location and language preferences</li>
        <li>Details of transactions, bookings, or subscriptions</li>
        <li>Logins, sign-up date, and user interactions (follows, likes, favorites)</li>
        <li>Measurements or professional details (for models/talents)</li>
      </ul>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">3. How We Use Your Information</h5>
      <ul>
        <li>To create and manage your account</li>
        <li>To connect members and enable collaboration</li>
        <li>To process bookings, payments, or subscriptions</li>
        <li>To notify you about casting calls, messages, or account activity</li>
        <li>To send updates, surveys, promotions, or offers (optional)</li>
        <li>To improve our platform by analyzing user behavior</li>
      </ul>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">4. Sharing of Data</h5>
      <p>
        We do not sell or rent your data. We may share it with trusted service providers
        to deliver our services—for example, payment processors, analytics tools, or
        messaging services. These providers are bound by confidentiality agreements.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">5. Cookies & Tracking</h5>
      <p>
        Like most websites, we use cookies to store preferences, enhance performance, and
        analyze traffic. You can disable cookies in your browser settings, but some
        features may not work properly without them.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">6. Data Retention</h5>
      <p>
        We keep your personal data for as long as your account is active, or as long as
        necessary to provide our services. You may request deletion of your account and
        associated data at any time.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">7. Security</h5>
      <p>
        We apply technical and organizational measures to safeguard your data from
        unauthorized access, misuse, or loss. While we strive to protect your information,
        no system is completely secure.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">8. Your Rights</h5>
      <ul>
        <li>Access and review your personal data</li>
        <li>Update or correct inaccurate details</li>
        <li>Delete your account and personal information</li>
        <li>Opt-out of marketing communications</li>
      </ul>
      <p>
        You can manage your account settings directly, or contact us to exercise these
        rights.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">9. Changes to this Policy</h5>
      <p>
        We may update this Privacy Policy from time to time. Updates will be posted on
        this page with a new "last updated" date. Continued use of our site means you
        accept the changes.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">10. Contact Us</h5>
      <p>If you have any questions about this Privacy Policy, please contact us:</p>
      <p>Email: <a href="mailto:privacy@daretodreamagency.com">
        privacy@daretodreamagency.com</a></p>
      <p>Phone: +254 700 000 000</p>
      <p>Address: Nairobi, Kenya</p>
    </div>
  </div>
</section>
@endsection
