<section class="py-4 bg-light min-vh-100">
    {{-- Breadcrumbs --}}
    <div class="pt-2 pb-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/profile') }}">{{ __('Profile') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Get Verified') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        {{-- Hero Header --}}
        <div class="text-center mb-5">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                <i class="bi bi-shield-check me-1"></i> {{ __('Build Buyer Trust') }}
            </span>
            <h2 class="display-6 fw-bold mb-3">
                {{ __('Get Verified, Sell') }} <span class="gradient-text">{{ __('10x Faster') }}</span>
            </h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                {{ __('Verification helps buyers identify you as a trusted merchant. Verified sellers get higher search priority, special page borders, and featured ad credits.') }}
            </p>
        </div>

        {{-- Error & Info Alerts --}}
        @if (session()->has('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- Verification Benefits --}}
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="card-body d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success-subtle p-3 text-success" style="aspect-ratio:1/1">
                             <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __('Seller Badge') }}</h6>
                            <small class="text-muted">{{ __('Displays a verification checkmark next to your name globally.') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="card-body d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-primary-subtle p-3 text-primary">
                             <i class="bi bi-star-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __('Featured Ads') }}</h6>
                            <small class="text-muted">{{ __('Promote your listings to the top of category lists and homepages.') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="card-body d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning-subtle p-3 text-warning">
                             <i class="bi bi-graph-up-arrow fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ __('Search Priority') }}</h6>
                            <small class="text-muted">{{ __('Verified sellers get up to 3x higher organic listing views.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Packages Grid --}}
        <div class="row g-4 justify-content-center">
            @foreach($packages as $pkg)
                @php
                    $isPopular = (bool)$pkg->popular;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow{{ $isPopular ? '-lg border border-primary border-2' : '-sm' }} rounded-4 overflow-hidden h-100 position-relative">
                        
                        @if($isPopular)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-primary text-white rounded-pill px-3 py-2 text-uppercase font-semibold">
                                    {{ $pkg->badge }}
                                </span>
                            </div>
                        @elseif($pkg->badge)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-dark text-white rounded-pill px-3 py-2 text-uppercase font-semibold">
                                    {{ $pkg->badge }}
                                </span>
                            </div>
                        @endif

                        <div class="card-body p-4 p-lg-5 d-flex flex-column h-100">
                            
                            {{-- Header --}}
                            <h4 class="fw-bold mb-2 text-dark">{{ __($pkg->name) }}</h4>
                            <div class="mb-4">
                                <span class="display-5 fw-bold text-dark">₹{{ number_format($pkg->price) }}</span>
                                <span class="text-muted">/ {{ $pkg->duration_in_months }} {{ \Illuminate\Support\Str::plural(__('month'), $pkg->duration_in_months) }}</span>
                            </div>

                            <hr class="mb-4 border-light-subtle">

                            {{-- Features --}}
                            <ul class="list-unstyled mb-5 flex-grow-1">
                                <li class="mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>{{ __('Verified Trust Badge') }}</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span><b>{{ $pkg->featured_limit }}</b> {{ __('Featured Ad Credits') }}</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>{{ __('Priority Search Ranking') }}</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>{{ __('Highlighted Card Borders') }}</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>{{ __('24/7 Dedicated Support') }}</span>
                                </li>
                            </ul>

                            {{-- CTA Button --}}
                            <button 
                                wire:click="selectPackage('{{ $pkg->id }}')" 
                                wire:loading.attr="disabled"
                                class="btn {{ $isPopular ? 'btn-primary' : 'btn-dark' }} w-100 rounded-pill py-3 fw-bold d-flex align-items-center justify-content-center gap-2"
                            >
                                <span wire:loading.remove wire:target="selectPackage('{{ $pkg->id }}')">
                                    {{ __('Choose Package') }} <i class="bi bi-arrow-right-short ms-1"></i>
                                </span>
                                <span wire:loading wire:target="selectPackage('{{ $pkg->id }}')" class="spinner-border spinner-border-sm" role="status"></span>
                            </button>

                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Razorpay JS SDK Checkout --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    
    @script
    <script>
        $wire.on('launch-razorpay', (event) => {
            const data = Array.isArray(event) ? event[0] : (event.detail ? (Array.isArray(event.detail) ? event.detail[0] : event.detail) : event);
            
            const options = {
                "key": data.key,
                "amount": data.amount,
                "currency": data.currency,
                "name": data.name,
                "description": data.description,
                "order_id": data.order_id,
                "handler": function (response) {
                    $wire.verifyPayment(
                        response.razorpay_order_id,
                        response.razorpay_payment_id,
                        response.razorpay_signature
                    );
                },
                "prefill": {
                    "name": data.prefill.name,
                    "email": data.prefill.email
                },
                "theme": {
                    "color": "#6047e6"
                },
                "modal": {
                    "ondismiss": function() {
                        console.log('Checkout modal closed.');
                    }
                }
            };
            
            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response){
                alert('Payment Failed: ' + response.error.description);
            });
            rzp.open();
        });

        $wire.on('payment-failed', (event) => {
            const msg = Array.isArray(event) ? event[0] : (event.detail ? (Array.isArray(event.detail) ? event.detail[0] : event.detail) : event);
            alert(msg);
        });
    </script>
    @endscript
</section>
