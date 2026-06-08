<div class="py-5 bg-light min-vh-100">
    <div class="container">
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/profile/my-ads') }}">{{ __('My Ads') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Boost Ads') }}</li>
            </ol>
        </nav>

        {{-- Error & Info Alerts --}}
        @if (session()->has('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if(auth()->check() && auth()->user()->isVerified())
            <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-start gap-3 bg-info-subtle text-info-emphasis">
                <i class="bi bi-info-circle-fill fs-5 text-info mt-0.5"></i>
                <div>
                    <h6 class="fw-bold mb-1">{{ __('Verified Seller Boost Credits') }}</h6>
                    <p class="mb-0 small">
                        {{ __('You have') }} <strong>{{ auth()->user()->featured_limit }}</strong> {{ __('remaining featured ad credits.') }}
                        @if(auth()->user()->featured_limit > 0)
                            {{ __('To boost ads automatically using your credits, select at most :limit ads at a time to trigger automatic credit-based boosting.', ['limit' => auth()->user()->featured_limit]) }}
                        @else
                            {{ __('Since you have 0 credits left, you can select one of the premium boosting packages below to boost your ads via checkout payment.') }}
                        @endif
                    </p>
                </div>
            </div>
        @endif

        <div class="row g-4">
            
            {{-- Selected Ads List --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-collection-play-fill text-primary me-2"></i>
                        {{ __('Selected Ads') }} ({{ count($listings) }})
                    </h5>
                    <p class="text-muted small mb-4">{{ __('The following ads will be upgraded to Featured status. Once active, featured settings cannot be changed or transferred.') }}</p>
                    
                    <div class="d-flex flex-column gap-3">
                        @foreach($listings as $listing)
                            <div class="d-flex align-items-center gap-3 p-3 border rounded-4 bg-white" wire:key="boost-col-{{ $listing->id }}">
                                <div class="flex-shrink-0" style="width: 80px; height: 60px; overflow: hidden; border-radius: 12px;">
                                    @if($listing->getFirstMediaUrl('*', 'thumb'))
                                        <img src="{{ $listing->getFirstMediaUrl('*', 'thumb') }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/no-product.webp') }}" class="w-100 h-100" style="object-fit: cover;">
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <span class="badge bg-light text-dark mb-1 small">{{ $listing->category?->name }}</span>
                                    <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $listing->title }}</h6>
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        <span><i class="bi bi-geo-alt me-1"></i>{{ $listing->location?->display_name }}</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <span class="fw-bold text-primary fs-5">{{ price($listing->price) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Packages & Checkout Summary --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                            {{ __('Select Boosting Package') }}
                        </h5>

                        <div class="d-flex flex-column gap-3 mb-4">
                            @foreach($packages as $package)
                                <label class="cursor-pointer w-100">
                                    <input type="radio" wire:model.live="selectedPackageId" value="{{ $package->id }}" class="btn-check" name="boost_checkout_pkg">
                                    <div class="card border-2 rounded-4 p-3 transition-all {{ $selectedPackageId == $package->id ? 'border-primary bg-light' : 'border-light-subtle' }}">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="fs-3">
                                                    @if($package->duration_in_days <= 7) ⚡ 
                                                    @elseif($package->duration_in_days <= 14) 🚀 
                                                    @elseif($package->duration_in_days <= 30) 🔥 
                                                    @else 👑 
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">{{ $package->name }}</h6>
                                                    <small class="text-muted">{{ $package->description }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold text-dark fs-5">{{ price($package->price) }}</span>
                                                <small class="text-muted d-block small">{{ __('per ad') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Summary & Checkout button --}}
                    <div class="border-top pt-4 mt-auto">
                        <h6 class="fw-bold text-dark mb-3">{{ __('Order Summary') }}</h6>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2 text-muted">
                            <span>{{ __('Package Rate:') }}</span>
                            <span>{{ price($selectedPackage?->price ?? 0) }} / {{ __('ad') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2 text-muted">
                            <span>{{ __('Selected Ads:') }}</span>
                            <span>x {{ count($listings) }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 border-top pt-3 text-dark">
                            <strong class="fs-5">{{ __('Total Amount:') }}</strong>
                            <strong class="fs-4 text-primary">{{ price($totalPrice) }}</strong>
                        </div>

                        <button 
                            class="theme-btn w-100 py-3 rounded-pill fw-bold fs-6 d-flex align-items-center justify-content-center gap-2 shadow-sm"
                            wire:click="createRazorpayOrder"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="createRazorpayOrder">
                                <i class="bi bi-credit-card-2-front-fill"></i> {{ __('Pay Now') }}
                            </span>
                            <span wire:loading wire:target="createRazorpayOrder" class="spinner-border spinner-border-sm" role="status"></span>
                        </button>
                    </div>

                </div>
            </div>

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

</div>
