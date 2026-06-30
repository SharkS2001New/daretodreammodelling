@extends('layouts.frontend')

@section('content')
<div class="container pb-5">
    <div class="row align-items-center g-4 mb-5">
        <div class="col-lg-6">
            <x-page-heading :centered="false" class="mb-3" />
            <p class="text-muted mb-0">
                Every model needs guidance at some point in their career. Whether you are new to the industry or already established,
                explore our practical advice to save time, stay professional, and grow with confidence.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="advice-hero-frame">
                <img src="{{ asset('advice-hero.png') }}"
                    alt="DD Models Agency group of models"
                    class="advice-hero-image">
            </div>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <div class="advice-topics-panel">
                <div class="advice-topics-panel__header mb-4">
                    <p class="advice-topics-panel__eyebrow text-uppercase fw-semibold mb-2">Guidance</p>
                    <h2 class="section-heading fw-bold mb-2">Topics to help you grow</h2>
                    <p class="text-muted mb-0">Tap a topic below for quick, actionable advice from the DD Models team.</p>
                </div>

                <div class="accordion advice-accordion" id="modelingAdviceAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTips">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTips" aria-expanded="true" aria-controls="collapseTips">
                                <span class="advice-topic__icon"><i class="bi bi-lightbulb-fill"></i></span>
                                Modeling Tips
                            </button>
                        </h2>
                        <div id="collapseTips" class="accordion-collapse collapse show" aria-labelledby="headingTips" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                Always maintain professionalism. Arrive on time, stay prepared, and treat every opportunity seriously.
                                Practice your poses in front of a mirror, study fashion magazines, and learn how to work with photographers.
                                Confidence, consistency, and networking are key to growing as a model.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingBeModel">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBeModel" aria-expanded="false" aria-controls="collapseBeModel">
                                <span class="advice-topic__icon"><i class="bi bi-person-check-fill"></i></span>
                                Can I Be a Model?
                            </button>
                        </h2>
                        <div id="collapseBeModel" class="accordion-collapse collapse" aria-labelledby="headingBeModel" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                Modeling is not only about height and body type. Today, agencies welcome diversity in looks, age, and size.
                                What matters most is confidence, professionalism, and the ability to take direction.
                                If you're passionate and willing to work hard, you can find a place in the industry.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPortfolio">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePortfolio" aria-expanded="false" aria-controls="collapsePortfolio">
                                <span class="advice-topic__icon"><i class="bi bi-images"></i></span>
                                Modeling Portfolios
                            </button>
                        </h2>
                        <div id="collapsePortfolio" class="accordion-collapse collapse" aria-labelledby="headingPortfolio" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                Your portfolio is your business card. Include high-quality professional photos that show versatility: close-ups,
                                full-body shots, and natural looks. Avoid over-editing; agencies prefer to see the real you.
                                Update your portfolio regularly to reflect your current look and recent work.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingShoots">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShoots" aria-expanded="false" aria-controls="collapseShoots">
                                <span class="advice-topic__icon"><i class="bi bi-camera-fill"></i></span>
                                Model Photo Shoots
                            </button>
                        </h2>
                        <div id="collapseShoots" class="accordion-collapse collapse" aria-labelledby="headingShoots" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                Before a shoot, get plenty of rest, hydrate, and bring essentials like makeup, a hairbrush, and wardrobe changes.
                                Communicate with the photographer about the theme and expectations.
                                Remember: the best shots come when you're relaxed and confident.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingAgencies">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAgencies" aria-expanded="false" aria-controls="collapseAgencies">
                                <span class="advice-topic__icon"><i class="bi bi-building"></i></span>
                                Modeling Agencies
                            </button>
                        </h2>
                        <div id="collapseAgencies" class="accordion-collapse collapse" aria-labelledby="headingAgencies" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                A reputable agency can open doors to major opportunities.
                                Research agencies carefully and avoid those asking for large upfront fees.
                                Legitimate agencies earn their income from commissions when you book work, not from selling classes or photoshoots.
                                Always read contracts thoroughly before signing.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingScams">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScams" aria-expanded="false" aria-controls="collapseScams">
                                <span class="advice-topic__icon"><i class="bi bi-shield-exclamation"></i></span>
                                Modeling Scams
                            </button>
                        </h2>
                        <div id="collapseScams" class="accordion-collapse collapse" aria-labelledby="headingScams" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                Beware of scams that promise overnight fame or require expensive upfront payments.
                                Never send money for casting calls, and be cautious with personal information.
                                If an offer sounds too good to be true, it probably is.
                                Always trust your instincts and research thoroughly.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCareer">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCareer" aria-expanded="false" aria-controls="collapseCareer">
                                <span class="advice-topic__icon"><i class="bi bi-graph-up-arrow"></i></span>
                                Modeling Career
                            </button>
                        </h2>
                        <div id="collapseCareer" class="accordion-collapse collapse" aria-labelledby="headingCareer" data-bs-parent="#modelingAdviceAccordion">
                            <div class="accordion-body">
                                A modeling career requires persistence and adaptability.
                                Some models thrive in fashion, while others find success in commercial, fitness, or lifestyle modeling.
                                Build a strong personal brand, stay active on social platforms, and always maintain your professionalism.
                                Remember: careers take time to build — patience and consistency are key.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="advice-closing mt-4">
                <p class="mb-0">Use this advice to shape your modeling journey and grow with confidence in the industry. ✨</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="advice-sidebar">
                <a href="{{ route('register') }}" class="advice-cta-banner d-block mb-4">
                    <img src="{{ asset('join-now-banner.png') }}" alt="Join Modeling Community" class="img-fluid rounded-3 w-100">
                </a>

                <div class="advice-sidebar-card">
                    <div class="advice-sidebar-card__icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Ready to take the next step?</h3>
                    <p class="text-muted mb-3">Join DD Models Agency and get mentorship, training, and real opportunities to build your career.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill w-100">Create your profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
