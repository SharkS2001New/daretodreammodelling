@extends('layouts.frontend')

@section('title', 'Modeling Advice - Tips & Guidance for Models')
@section('meta_description', 'Modeling advice and tips for new and experienced models. Learn how to start, build your portfolio, work with agencies, and grow your career in modeling.')

@section('content')
<section class="py-2 mb-2 bg-white">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Left Column: Text + Image -->
      <div class="col-lg-9">
        <h1 class="mb-3">Modeling Advice</h1>
        <h5 class="text-muted mb-4">
          Read our modeling advice and tips to help you with your modeling career.
        </h5>
        <p class="mb-4">
          Every model needs advice at some point in their career. Whether you are a newcomer into the modeling world or an established model, 
          check out our modeling advice articles designed to help save time and grow your career.
        </p>

        <img src="{{ asset('become-model-haunter.jpg') }}" width="60%"  alt="Modeling Class" class="img-fluid rounded shadow-sm">
      </div>

      <!-- Right Column: Call-to-Action Banner -->
      <div class="col-lg-3 text-center mt-4 mt-lg-0">
        <a href="/register" class="d-block">
          <img src="{{ asset('join-now-banner.png') }}" alt="Join Modeling Community" class="img-fluid mb-3 rounded">
        </a>
      </div>
    </div>
  </div>
</section>
<section class="py-2">
  <div class="container">
    <!-- Bootstrap Accordion -->
    <div class="accordion" id="modelingAdviceAccordion">

      <!-- Modeling Tips -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTips">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTips" aria-expanded="true" aria-controls="collapseTips">
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

      <!-- Can I Be a Model -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingBeModel">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBeModel" aria-expanded="false" aria-controls="collapseBeModel">
            Can I Be a Model?
          </button>
        </h2>
        <div id="collapseBeModel" class="accordion-collapse collapse" aria-labelledby="headingBeModel" data-bs-parent="#modelingAdviceAccordion">
          <div class="accordion-body">
            Modeling is not only about height and body type. Today, agencies welcome diversity in looks, age, and size.  
            What matters most is confidence, professionalism, and the ability to take direction.  
            If you’re passionate and willing to work hard, you can find a place in the industry.
          </div>
        </div>
      </div>

      <!-- Portfolios -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingPortfolio">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePortfolio" aria-expanded="false" aria-controls="collapsePortfolio">
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

      <!-- Photo Shoots -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingShoots">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShoots" aria-expanded="false" aria-controls="collapseShoots">
            Model Photo Shoots
          </button>
        </h2>
        <div id="collapseShoots" class="accordion-collapse collapse" aria-labelledby="headingShoots" data-bs-parent="#modelingAdviceAccordion">
          <div class="accordion-body">
            Before a shoot, get plenty of rest, hydrate, and bring essentials like makeup, hairbrush, and wardrobe changes.  
            Communicate with the photographer about the theme and expectations.  
            Remember: the best shots come when you’re relaxed and confident.
          </div>
        </div>
      </div>

      <!-- Agencies -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingAgencies">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAgencies" aria-expanded="false" aria-controls="collapseAgencies">
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

      <!-- Modeling Scams -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingScams">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScams" aria-expanded="false" aria-controls="collapseScams">
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

      <!-- Careers -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingCareer">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCareer" aria-expanded="false" aria-controls="collapseCareer">
            Modeling Career
          </button>
        </h2>
        <div id="collapseCareer" class="accordion-collapse collapse" aria-labelledby="headingCareer" data-bs-parent="#modelingAdviceAccordion">
          <div class="accordion-body">
            A modeling career requires persistence and adaptability.  
            Some models thrive in fashion, while others find success in commercial, fitness, or lifestyle modeling.  
            Build a strong personal brand, stay active on social platforms, and always maintain your professionalism.  
            Remember: careers take time to build—patience and consistency are key.
          </div>
        </div>
      </div>

    </div><!-- /accordion -->

    <p class="mt-5">✨ Use this advice to shape your modeling journey and grow with confidence in the industry.</p>
  </div>
</section>
@endsection
