<x-app-layout
    title="Help Center & FAQ - AdMandi"
    meta-description="Find answers to frequently asked questions about buying, selling, and managing your listings on AdMandi classifieds."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Help Center') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <h1 class="fw-bold mb-4 gradient-text text-center">{{ __('Help Center & FAQ') }}</h1>
            <p class="text-muted text-center mb-5">{{ __('How can we help you today? Find answers to commonly asked questions below.') }}</p>
            
            <div class="row g-4">
                <div class="col-lg-8 mx-auto">
                    {{-- FAQ Accordion --}}
                    <div class="accordion accordion-flush" id="faqAccordion">
                        
                        {{-- Question 1 --}}
                        <div class="accordion-item border-bottom py-3">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed fw-bold text-dark fs-5 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    {{ __('How do I post a free advertisement on AdMandi?') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted lh-lg">
                                    {{ __('Posting an ad is simple and completely free. Log in to your account, click on the "Post an Ad" button in the header, select the category that best matches your item, fill in details like title, description, price, and location, upload up to 10 high-quality photos, and click publish.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Question 2 --}}
                        <div class="accordion-item border-bottom py-3">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-bold text-dark fs-5 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{ __('What is a verified seller and how do I become one?') }}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted lh-lg">
                                    {{ __('A Verified Seller has completed identity verification, which builds buyer trust and speeds up sales. Verified sellers receive a checkmark badge next to their name, higher priority ranking in search results, highlighted card borders, and free featured ad credits. You can apply by clicking "Get Verified" in your profile settings.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Question 3 --}}
                        <div class="accordion-item border-bottom py-3">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed fw-bold text-dark fs-5 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ __('How do I contact a buyer or seller?') }}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted lh-lg">
                                    {{ __('You can communicate directly with any buyer or seller using our secure in-app chat system. Simply visit the listing details page and click the "Chat" button. Your conversations will be saved in your account dashboard under Messages.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Question 4 --}}
                        <div class="accordion-item border-bottom py-3">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed fw-bold text-dark fs-5 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    {{ __('What safety precautions should I take when buying or selling?') }}
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted lh-lg">
                                    {{ __('Always meet in a public, safe, and well-lit place to inspect items and make exchanges. Never send payments or booking deposits in advance without verifying the seller and the product. Inspect items thoroughly before making payments, and beware of scam links or fake transaction screenshots.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Question 5 --}}
                        <div class="accordion-item border-bottom py-3">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed fw-bold text-dark fs-5 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    {{ __('How do I boost my ads to get more views?') }}
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted lh-lg">
                                    {{ __('To boost your listing visibility, go to "My Ads" on your profile, select the ad you want to upgrade, and click the "Boost" button. You can choose a promotion package to make your listing "Featured", which pins it to the top of homepage sliders and category result pages.') }}
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Contact Info Box --}}
                    <div class="mt-5 text-center bg-light rounded-4 p-4">
                        <h5 class="fw-bold mb-2">{{ __('Still have questions?') }}</h5>
                        <p class="text-muted mb-3">{{ __('Our support team is available 24/7 to assist you.') }}</p>
                        <a href="mailto:support@admandi.com" class="theme-btn text-decoration-none">
                            <i class="bi bi-envelope-fill me-1"></i> {{ __('Contact Support') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
