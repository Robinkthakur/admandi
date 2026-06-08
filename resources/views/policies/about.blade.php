<x-app-layout
    title="About AdMandi - 99.99% Genuine Ads & Verified Sellers"
    meta-description="Learn how AdMandi builds a secure, spam-free marketplace. Discover our 99.99% genuine ads pledge, seller verification processes, and safety tips."
>
    {{-- Page Custom Styles --}}
    <style>
        .trust-hero-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9f7ff 100%);
            border: 1px solid rgba(96, 71, 230, 0.15) !important;
            position: relative;
            overflow: hidden;
        }
        .trust-hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(96, 71, 230, 0.05) 0%, rgba(255,255,255,0) 70%);
            z-index: 0;
            pointer-events: none;
        }
        .metric-card {
            background: #ffffff;
            border: 1px solid rgba(220, 220, 220, 0.7);
            transition: all 0.3s ease;
        }
        .metric-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 10px 25px rgba(96, 71, 230, 0.08);
        }
        .metric-icon {
            width: 60px;
            height: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--light);
            color: var(--primary);
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }
        .metric-card:hover .metric-icon {
            background: var(--primary);
            color: #ffffff;
        }
        .pillar-card {
            background: #ffffff;
            border: 1px solid #eef0f6;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        .pillar-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        .comparison-table th {
            background-color: var(--primaryDark);
            color: #ffffff;
        }
        .comparison-table tbody tr {
            transition: background-color 0.2s ease;
        }
        .comparison-table tbody tr:hover {
            background-color: #fcfbff;
        }
        .status-badge-verified {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status-badge-unverified {
            background-color: #f8d7da;
            color: #842029;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>

    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-primary text-decoration-none">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('About') }} AdMandi</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        {{-- Hero Header --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 trust-hero-card">
            <div class="row align-items-center g-5 position-relative" style="z-index: 1;">
                <div class="col-lg-7">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-shield-fill-check me-1"></i> {{ __('Trust & Safety First') }}
                    </span>
                    <h1 class="display-4 fw-bold mb-3">
                        {{ __('Upto') }} <span class="gradient-text">99.99% {{ __('Genuine Ads') }}</span>
                    </h1>
                    <p class="text-muted fs-5 mb-4 lh-base">
                        {{ __('AdMandi is built on a simple premise: connecting local buyers and sellers should be simple, safe, and entirely free of fraud. We are on a relentless mission to build a premium, fraud-free community where every listing is vetted and every seller is verified.') }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url('/ads') }}" class="theme-btn">{{ __('Browse Verified Ads') }}</a>
                        <a href="{{ route('get-verified') }}" class="theme-btn-outline"><i class="bi bi-patch-check-fill me-1"></i> {{ __('Get Verified') }}</a>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <img src="{{ asset('images/verified-seller.webp') }}" alt="Trusted Marketplace" class="img-fluid rounded-4 shadow-lg border" style="max-height: 380px; object-fit: cover; width: 100%;">
                </div>
            </div>
        </div>

        {{-- Metrics Badges Section --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card metric-card rounded-4 p-4 text-center h-100 shadow-sm">
                    <div class="metric-icon">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-dark">99.99%</h2>
                    <h5 class="fw-semibold text-primary mb-2">{{ __('Genuine Ads Pledge') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Our combination of automated scanning and community shields keeps spam, fake offers, and duplicates off your screen.') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card metric-card rounded-4 p-4 text-center h-100 shadow-sm">
                    <div class="metric-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-dark">100%</h2>
                    <h5 class="fw-semibold text-primary mb-2">{{ __('Verified Sellers') }}</h5>
                    <p class="text-muted small mb-0">{{ __('We prioritize safety through secure SMS/OTP checks and verified seller profiles, ensuring you interact with genuine neighbors.') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card metric-card rounded-4 p-4 text-center h-100 shadow-sm">
                    <div class="metric-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-dark">&lt; 5 Min</h2>
                    <h5 class="fw-semibold text-primary mb-2">{{ __('Moderation Sweep') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Reported or flagged listings are instantly reviewed by our support team, ensuring fast mitigation against malicious agents.') }}</p>
                </div>
            </div>
        </div>

        {{-- Four Security Pillars --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <div class="text-center mb-5">
                <span class="text-primary fw-semibold text-uppercase tracking-wider">{{ __('Our Protective Infrastructure') }}</span>
                <h3 class="fw-bold text-dark mt-2 mb-3">{{ __('How We Deliver a Fraud-Free Marketplace') }}</h3>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    {{ __('To protect our users, we maintain a robust four-layer safety filter that scans, validates, and monitors all activities on AdMandi.') }}
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card pillar-card p-4 rounded-4 h-100 border-0">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="bi bi-shield-lock-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">{{ __('1. Smart OTP Verification') }}</h5>
                                <p class="text-muted mb-0">
                                    {{ __('Throwaway accounts and robot bots are eliminated. Every active seller completes a mandatory OTP phone check to bind their identity, creating structural accountability.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card pillar-card p-4 rounded-4 h-100 border-0">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="bi bi-cpu-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">{{ __('2. AI-Powered Fraud Filtering') }}</h5>
                                <p class="text-muted mb-0">
                                    {{ __('Our filters automatically analyze listing descriptions, images, titles, and price ranges. Suspicious listings (e.g. outlier low pricing or duplicated text) are immediately flagged for human preview.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card pillar-card p-4 rounded-4 h-100 border-0">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="bi bi-chat-dots-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">{{ __('3. Protected In-App Chat') }}</h5>
                                <p class="text-muted mb-0">
                                    {{ __('Trade securely without sharing phone numbers or personal social media handles. Our system actively scans for safety alerts and alerts you to potential suspicious URLs or off-platform payment schemes.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card pillar-card p-4 rounded-4 h-100 border-0">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="bi bi-flag-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">{{ __('4. 1-Click Reporting & Rapid Moderation') }}</h5>
                                <p class="text-muted mb-0">
                                    {{ __('Found a questionable ad? Flag it instantly. Our moderation team reviews user reports 24/7 and executes strict, swift action, blacklisting fraudulent devices and accounts.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Comparison Section --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <div class="text-center mb-4">
                <span class="text-primary fw-semibold text-uppercase tracking-wider">{{ __('How We Compare') }}</span>
                <h3 class="fw-bold text-dark mt-2 mb-2">{{ __('AdMandi vs. Conventional Marketplaces') }}</h3>
                <p class="text-muted">{{ __('We built a structural environment of trust, raising the bar for classified safety.') }}</p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered comparison-table align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-start py-3" style="width: 40%;">{{ __('Security Feature') }}</th>
                            <th class="py-3" style="width: 30%; background-color: var(--primary);">{{ __('AdMandi Marketplace') }}</th>
                            <th class="py-3" style="width: 30%;">{{ __('Conventional Platforms') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-start fw-semibold py-3">{{ __('Verified Seller Badge / OTP Check') }}</td>
                            <td class="py-3"><span class="status-badge-verified"><i class="bi bi-check-circle-fill me-1"></i> {{ __('Mandatory') }}</span></td>
                            <td class="py-3"><span class="status-badge-unverified"><i class="bi bi-x-circle-fill me-1"></i> {{ __('Rare / Optional') }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-start fw-semibold py-3">{{ __('AI Fraud Analysis (Real-time)') }}</td>
                            <td class="py-3"><span class="status-badge-verified"><i class="bi bi-check-circle-fill me-1"></i> {{ __('Every Listing') }}</span></td>
                            <td class="py-3"><span class="status-badge-unverified"><i class="bi bi-x-circle-fill me-1"></i> {{ __('None / Delayed') }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-start fw-semibold py-3">{{ __('Secure Contact-free Chat') }}</td>
                            <td class="py-3"><span class="status-badge-verified"><i class="bi bi-check-circle-fill me-1"></i> {{ __('Always On') }}</span></td>
                            <td class="py-3"><span class="status-badge-unverified"><i class="bi bi-x-circle-fill me-1"></i> {{ __('Exposes Phone No.') }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-start fw-semibold py-3">{{ __('Spam Response Window') }}</td>
                            <td class="py-3 text-success fw-bold"><i class="bi bi-lightning-fill text-warning"></i> {{ __('Under 5 Minutes') }}</td>
                            <td class="py-3 text-muted">{{ __('Hours or Days') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Safety Tips for Users --}}
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-bag-check-fill me-2"></i>{{ __('Safe Buying Guidelines') }}</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3 align-items-start">
                            <i class="bi bi-1-circle-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>{{ __('Inspect First, Pay Later') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('Always meet in person to inspect the item state and verify details before exchanging payments.') }}</p>
                            </div>
                        </li>
                        <li class="d-flex mb-3 align-items-start">
                            <i class="bi bi-2-circle-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>{{ __('Choose Safe Meeting Spots') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('Meet in crowded public locations, like shopping malls, coffee shops, or close to police stations during daylight.') }}</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="bi bi-3-circle-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>{{ __('Avoid Advance Wire Transfers') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('Never pay holding deposits or transfer funds through digital wallets prior to inspecting the physical item.') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-tag-fill me-2"></i>{{ __('Safe Selling Guidelines') }}</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3 align-items-start">
                            <i class="bi bi-1-circle-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>{{ __('Verify Buyer Profiles') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('Prefer buyers with completed verification tags and active platform history.') }}</p>
                            </div>
                        </li>
                        <li class="d-flex mb-3 align-items-start">
                            <i class="bi bi-2-circle-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>{{ __('Use In-App Messaging') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('Avoid sharing personal cell numbers or moving chat logs to unofficial messaging apps.') }}</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="bi bi-3-circle-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>{{ __('Insist on Immediate Payments') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('Accept cash or instant bank transfers. Never accept personal checks, promissory notes, or late payment promises.') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
