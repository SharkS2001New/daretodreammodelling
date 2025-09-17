@extends('layouts.frontend')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="text-center mb-2">
                <h1 class="display-4 fw-bold text-dark mb-3">Got Questions? We've Got Answers!</h1>
                <p class="lead text-muted">
                    We are the community that brings together new faces, professional models, photographers, 
                    agencies and other industry experts.
                </p>
            </div>

            <!-- Contact Information -->
            <div class="card shadow-sm border-0 mb-2">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-3">Get In Touch</h3>
                        <p class="text-muted mb-4">
                            You can contact us at <a href="mailto:info@daretodream.com" class="text-primary">info@daretodream.com</a>, 
                            and in our social spaces:
                        </p>
                        
                        <!-- Social Media Links -->
                        <div class="social-links mb-4">
                            <a href="https://www.facebook.com/profile.php?id=100028941746406" class="btn btn-outline-primary btn-sm mx-1 mb-2">
                                <i class="bi bi-facebook me-1"></i> FACEBOOK
                            </a>
                            <a href="https://www.instagram.com/d_d_models/?hl=en" class="btn btn-outline-primary btn-sm mx-1 mb-2">
                                <i class="bi bi-instagram me-1"></i> INSTAGRAM
                            </a>
                            <a href="https://www.tiktok.com/@ddmodels96" class="btn btn-outline-primary btn-sm mx-1 mb-2">
                                <i class="bi bi-tiktok me-1"></i> TIKTOK
                            </a>
                        </div>

                        <p class="text-muted">
                            By joining our social sites you'll be able to stay in touch with our news, 
                            get discounts, exclusive information and much more...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Networking Guide -->
            <div class="card shadow-sm border-0 mb-2">
                <div class="card-body">
                    <h3 class="fw-bold text-center mb-4">How to network within Dare to Dream:</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-search text-primary me-2"></i>
                                    <strong>Find people</strong> in the industry
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-chat-dots text-primary me-2"></i>
                                    <strong>Leave comments</strong> on other models' shots
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-envelope text-primary me-2"></i>
                                    <strong>Email them</strong> directly
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-person-plus text-primary me-2"></i>
                                    <strong>Follow them</strong> to stay updated
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-reply text-primary me-2"></i>
                                    <strong>Respond</strong> to people that engage with you
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-link-45deg text-primary me-2"></i>
                                    <strong>Share your profile</strong> with your unique link
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-people text-primary me-2"></i>
                                    <strong>Connect</strong> with members inside and outside the community
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotion Guide -->
            <div class="card shadow-sm border-0 mb-2">
                <div class="card-body">
                    <h3 class="fw-bold text-center mb-4">How to promote yourself using Dare to Dream:</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-diagram-3 text-primary me-2"></i>
                                    <strong>Network, network, network</strong> - it's essential!
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-images text-primary me-2"></i>
                                    <strong>Keep your portfolio updated</strong> with your best shots
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-chat-heart text-primary me-2"></i>
                                    <strong>Don't be afraid</strong> of contacting other members
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-share text-primary me-2"></i>
                                    <strong>Share your profile</strong> on social media and other platforms
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-globe text-primary me-2"></i>
                                    <strong>Embed your profile badge</strong> on your website or blog
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-envelope-at text-primary me-2"></i>
                                    <strong>Add your link</strong> as a signature for your emails
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Collapsible Section -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold text-center mb-4">Frequently Asked Questions</h3>
                    
                    <div class="accordion" id="faqAccordion">
                        <!-- Question 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    HOW DOES DARE TO DREAM WORK?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:26px">We help models discover the business side of the industry. This is another way of helping the jobless individuals in the society who have passion and willingness to do modeling not only as a hobby but as a career. A model is a person with a role to promote, display or advertise commercial products, or to serve as a visual aid for people who are creating works of art. Dare to Dream not only discovers the unknown talents but also links the youth with job opportunities.</p>
                                    <p>We offer models with skills that help them to;</p>
                                    <ol>
                                        <li>Promote products and services for companies, brands, artists and other platforms relating with the industry.</li>
                                        <li>Work closely with photographers, hair and clothing stylists, makeup artists and clients to produce a desired look.</li>
                                        <li>Create and maintain a portfolio of their work.</li>
                                        <li>Travel to meet and interview potential clients.</li>
                                        <li>Conduct research on the product being promoted.</li>
                                        <li>Wear designers clothing for runways and fashion shows.</li>
                                        <li>Model accessories such as handbags, shoes and jewelry, and promote beauty products including; fragrances and cosmetics.</li>
                                    </ol>
                                    <p>We scout, nurture and train different types of models according to their capabilities in the industry which are:</p>
                                    <ul>
                                        <li>Editorial</li>
                                        <li>Runway/ramp</li>
                                        <li>Commercial</li>
                                        <li>Petite/lingerie</li>
                                        <li>Parts modeling</li>
                                        <li>Glamour</li>
                                        <li>Photography</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Question 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What qualities are required for modeling?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">You need to want to be a model and be committed to achieving it! It might sound obvious but it is amazing how many prospective models realize they can't do a shoot for many weeks and then give up. Having the right look and figure is also important but without determination you will not succeed. If you want to be a model then you should always be professional in your attitude. If you provide a phone number or email address you should always return contact promptly.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Do I need good quality photos for my modeling portfolio?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">Yes! You may have heard that an agency only needs amateur photos to judge your potential as a model. This may be true, but these days much promotion of models is done outside of model agencies on the web with online portfolio hosting sites where the best quality portfolio shots will give you an advantage. Your portfolio should show a variety of poses in different styles of modeling you are looking to do, but include a clear head face shot and full length shot to show your figure.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 4 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Everyone says I should be a model. So can anyone be a model?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">I wish I could say yes, but the truth is, no. Not everyone can be a model. There are certain looks that are generally desired and it takes a lot of hard work and dedication to make it as a model.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 5 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    DO I NEED A PORTFOLIO?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">NO you do NOT require a portfolio to apply to our agency. Snapshots from your phone are fine, however if you have a professional portfolio that meets agency standards, we will happily accept this.</p>
                                    <p>Parents should be aware that any reputable agency would insist on meeting and testing models under camera before signing them. We call this a test shoot to see how well you engage and take direction. If you are based in our area and do not have your own photos we will invite you in and test you free of charge regardless of any experience gained in a studio. Any agency that does not want to meet models and test them should be avoided as clients insist only those 'capable' of the task will be sent to the client.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 6 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    WHAT HAPPENS ONCE I AM REGISTERED WITH THE AGENCY?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">We will put you forward for all assignments where you meet the criteria. As and when a client contacts us to meet you for a casting or book you direct for a job, we will contact you immediately. Sometimes we might contact you beforehand if the client requests us to do so to confirm availability on a number of shortlisted models or maybe to confirm specific details. Please know we will not contact you each and every time our artists are submitted for work. It is obviously crucial that all artists' profiles are kept up to date and to keep the agency informed of any changes whatsoever.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 7 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    How do modeling coaching products work?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">We believe repetition of video footage is one of the best ways to prepare a model for his/her next professional photo shoot. By looking in on an actual photo shoot, you will benefit from the exact same information that a professional model gets, but at a fraction of the cost of a paid shoot. We want to bring the professional photo shoot experience to you so you can gain the same valuable information and demonstration tips from experienced professionals within the modeling industry.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 8 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    By joining Dare to Dream will I be guaranteed work?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p style="line-height:28px">No company can guarantee a job placement to its members. As it all depends on his/her portfolio and overall potential. However, the amount of professionalism we deliver gives you a great advantage in getting work. We maximize exposure, thus helping you to be noticed by the correct people in the industry.</p>
                                </div>
                            </div>
                        </div>
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
    border-radius: 15px;
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.social-links .btn {
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 500;
}

.btn-primary {
    background-color: #e91e63;
    border-color: #e91e63;
    border-radius: 25px;
    padding: 10px 30px;
}

.btn-primary:hover {
    background-color: #c2185b;
    border-color: #c2185b;
}

.btn-outline-primary {
    border-radius: 25px;
    padding: 10px 30px;
    border-color: #e91e63;
    color: #e91e63;
}

.btn-outline-primary:hover {
    background-color: #e91e63;
    border-color: #e91e63;
    color: white;
}

.display-4 {
    font-size: 2.5rem;
    font-weight: 700;
}

.lead {
    font-size: 1.25rem;
}

.list-unstyled li {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.list-unstyled li:last-child {
    border-bottom: none;
}

.bi {
    font-size: 1.2rem;
}
</style>
@endsection