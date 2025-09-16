@extends('layouts.frontend')

@section('content')
<section id="terms-of-use" class="section py-5">
  <div class="container" data-aos="fade-up">
    <h2 class="fw-bold mb-4">Terms of Use</h2>
    <p class="text-muted mb-5">
      Last updated: {{ now()->format('F d, Y') }}
    </p>

    <div class="mb-4">
      <h5 class="fw-bold">1. Acceptance of Terms</h5>
      <p>
        By accessing and using {{ config('app.name') }}, you agree to be bound by these
        Terms of Use and all applicable laws and regulations. If you do not agree with any
        part of these terms, please do not use our website.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">2. Use of Content</h5>
      <p>
        All content on this site, including text, images, graphics, logos, and other
        materials, is the property of {{ config('app.name') }} or its licensors and is
        protected by copyright and intellectual property laws. You may not copy, modify,
        distribute, or use any content without prior written permission.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">3. User Responsibilities</h5>
      <ul>
        <li>You agree to use the website only for lawful purposes.</li>
        <li>You must not attempt to gain unauthorized access to any part of the website.</li>
        <li>You are responsible for ensuring that any information you provide is accurate and up to date.</li>
      </ul>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">4. Third-Party Links</h5>
      <p>
        Our website may contain links to third-party websites. These links are provided for
        convenience only, and we are not responsible for the content, policies, or
        practices of any third-party sites.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">5. Disclaimer of Warranties</h5>
      <p>
        The website and its content are provided on an "as is" and "as available" basis.
        {{ config('app.name') }} makes no warranties, expressed or implied, regarding the
        accuracy, reliability, or availability of the site.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">6. Limitation of Liability</h5>
      <p>
        To the fullest extent permitted by law, {{ config('app.name') }} shall not be held
        liable for any damages arising out of or related to your use of the website,
        including direct, indirect, incidental, or consequential damages.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">7. Changes to Terms</h5>
      <p>
        We reserve the right to modify these Terms of Use at any time. Any changes will be
        effective immediately upon posting on this page. Your continued use of the site
        after updates means you accept the revised terms.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">8. Governing Law</h5>
      <p>
        These Terms of Use are governed by and construed in accordance with the laws of
        Kenya (or your applicable jurisdiction), without regard to conflict of law
        principles.
      </p>
    </div>

    <div class="mb-4">
      <h5 class="fw-bold">9. Contact Us</h5>
      <p>
        If you have any questions regarding these Terms of Use, please contact us at:
      </p>
      <p class="mb-0">
        Email: <a href="mailto:info@daretodream.com">
          info@daretodream.com
        </a>
      </p>
      <p>Phone: +254 700 000 000</p>
    </div>
  </div>
</section>
@endsection
