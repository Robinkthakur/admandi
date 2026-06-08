<x-app-layout
    title="Ad Posting Limit Exceeded | AdMandi"
    meta-description="You have reached the listing limit for this category. Upgrade to verified seller status to unlock higher posting thresholds and premium tools."
>
    {{-- Custom page styles --}}
    <style>
        .limit-exceeded-card {
            background: #ffffff;
            border: 1px solid rgba(220, 220, 220, 0.7);
            border-top: 5px solid #dc3545; /* Red warning accent */
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .benefit-card-free {
            background: #fdfdfd;
            border: 1px solid #eef0f6;
            opacity: 0.8;
        }
        .benefit-card-verified {
            background: linear-gradient(135deg, #ffffff 0%, #f9f7ff 100%);
            border: 2px solid var(--primary) !important;
            position: relative;
        }
        .benefit-card-verified .popular-tag {
            position: absolute;
            top: -12px;
            right: 20px;
            background: var(--primary);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: bold;
            padding: 2px 12px;
            border-radius: 50px;
            text-transform: uppercase;
        }
    </style>

    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-primary text-decoration-none">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/post-ad') }}" class="text-primary text-decoration-none">{{ __('Post Ad') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Limit Exceeded') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Main Warning Card --}}
                <div class="card border-0 rounded-4 p-4 p-md-5 limit-exceeded-card text-center mb-5">
                    <div class="mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                        </span>
                    </div>
                    
                    <h1 class="fw-bold text-dark mb-2">{{ __('Ad Posting Limit Exceeded') }}</h1>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fs-6 mb-4">
                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('Category Limit Reached') }}
                    </span>

                    <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 600px;">
                        {{ __('You have reached the posting limit for this category. To maintain a spam-free environment, we limit listings per category based on account verification status.') }}
                    </p>

                    {{-- Plan Options Comparison --}}
                    <div class="row g-4 text-start mb-5">
                        {{-- Free Tier --}}
                        <div class="col-md-6">
                            <div class="card benefit-card-free rounded-4 p-4 h-100">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="bi bi-person text-muted fs-3"></i>
                                    <h5 class="fw-bold mb-0 text-dark">{{ __('Free Account') }}</h5>
                                </div>
                                <h3 class="fw-bold text-dark mb-4">
                                    {{ config('ads.free_limit', 5) }} 
                                    <span class="fs-6 text-muted font-normal">{{ __('Ads / Category') }}</span>
                                </h3>
                                <ul class="list-unstyled mb-0 small text-muted">
                                    <li class="mb-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-dash-circle text-danger"></i>
                                        <span>{{ __('Standard search ranking') }}</span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-dash-circle text-danger"></i>
                                        <span>{{ __('No verified trust badge') }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-2">
                                        <i class="bi bi-dash-circle text-danger"></i>
                                        <span>{{ __('Basic account visibility') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Verified Tier --}}
                        <div class="col-md-6">
                            <div class="card benefit-card-verified rounded-4 p-4 h-100 shadow-sm">
                                <span class="popular-tag">{{ __('Recommended') }}</span>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="bi bi-patch-check-fill text-primary fs-3"></i>
                                    <h5 class="fw-bold mb-0 text-primary">{{ __('Verified Seller') }}</h5>
                                </div>
                                <h3 class="fw-bold text-dark mb-4">
                                    {{ config('ads.verified_limit', 25) }} 
                                    <span class="fs-6 text-muted font-normal">{{ __('Ads / Category') }}</span>
                                </h3>
                                <ul class="list-unstyled mb-0 small text-dark">
                                    <li class="mb-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span><strong>{{ __('25 Ads per category') }}</strong></span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>{{ __('Verified badge on all listings') }}</span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>{{ __('3x Search ranking boost') }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        <span>{{ __('Featured ad credits included') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ route('get-verified') }}" class="theme-btn px-4 py-3 fs-6 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-patch-check-fill me-2"></i> {{ __('Upgrade Account Now') }}
                        </a>
                        <a href="{{ url('/profile/my-ads') }}" class="theme-btn-outline px-4 py-3 fs-6 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-grid-fill me-2"></i> {{ __('Manage Existing Ads') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
