<div>
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <!-- <li class="breadcrumb-item"><a href="{{ url('ads/'.$ad->category->slug) }}">{{ $ad->category->name }}</a></li> -->
                <li class="breadcrumb-item active" aria-current="page">{{ $ad->title }}</li>
            </ol>
            </nav>
        </div>
    </div>

    <div class="details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="image-area" wire:ignore>  
                        <div class="product-view-slider">
                            @foreach($ad->getMedia('*') as $ad_img)
                            <div>
                                <img src="{{ $ad_img->getUrl('medium') }}"  loading="lazy" class="main-image">
                            </div>
                            @endforeach
                        </div>
                         @if($ad->getMedia('*')->count() > 1)
                        <div class="product-view-slider-thumb">
                            @foreach($ad->getMedia('*') as $ad_img)
                                <div class="slide-thumb">
                                    <img src="{{ $ad_img->getUrl('thumb') }}" loading="lazy" class="main-image">
                                </div>
                            @endforeach
                        </div>
                        @endif

                    </div>

                    <div class="mt-4">
                        <div>
                            <div class="ad-title d-lg-none">
                                {{ $ad->title }}
                            </div>

                            <div class="ad-description ">
                                {!! $ad->description !!}
                            </div>
                           
                            <div class="ad-price d-lg-none">
                                ₹ {{ number_format($ad->price) }}
                            </div>
                            <div class="ad-location d-lg-none">
                                {{ $ad->location?->display_name }} | {{ $ad->created_at?->diffForHumans() }}
                            </div>
                        </div>
                        <hr>
                        <div class="d-lg-none">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#shareModal">
                                <i class="bi bi-share me-1"></i>
                                <span>{{ __('Share') }}</span>
                            </button>

                            <button class="btn" wire:click="toggleWishList">
                                @if($isWishlisted)
                                    <i class="bi bi-heart-fill text-danger me-1"></i>
                                    <span>{{ __('Wishlisted') }} • <span class="text-danger">{{ __('Remove') }}</span></span>
                                @else
                                    <i class="bi bi-heart me-1"></i>
                                    <span>{{ __('Add to wishlist') }}</span>
                                @endif
                            </button>
                        </div>
                        <hr class="d-lg-none">
                        <div class="ad-details">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <span >{{ __('Ad ID:') }} </span>
                                    <span>{{ $ad->ad_id }}</span>
                                </div>
                                <div>
                                    <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="bi bi-info-circle me-1"></i>{{ __('Report this ad') }}</button>
                                </div>
                            </div>
                        </div>
                         <hr class="d-lg-none">
                        <div class="map-area d-lg-none pt-0">
                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($ad->location->name) }}&hl=en&z=12&output=embed"
                                loading="lazy"
                                class="w-100 mt-0"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <p class="mt-3 mb-1">{{ __('Posted By:') }}</p>
                        <div class="custom-card ad-posted-by {{ $ad->user?->isVerified() ? 'verified' : '' }}">
                           
                            <div class="d-flex align-items-center">
                                 <div class="me-2">
                                     <img src="{{ $ad->user->avatar ?? asset('assets/icons/avatar.png') }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                 </div>
                                 <div>
                                     <span class="username">
                                         {{ $ad->user?->name }}
                                         @if($ad->user?->isVerified())
                                             <a href="{{ route('verification-status', $ad->user_id) }}" class="text-decoration-none">
                                                <i class="bi bi-patch-check-fill text-primary ms-1" title="{{ __('Verified User') }}"></i>
                                             </a>
                                         @endif
                                     </span><br>
                                     <small><a class="text-primary" href="{{ url('profile/' . $ad->user_id) }}">{{ __('View Profile') }}</a></small>
                                 </div>
                             </div>
                             
                             @if($ad->user->email_verified_at || $ad->user->phone_verified_at || $ad->user->isVerified())
                             <div class="d-flex gap-2 mt-3 flex-wrap justify-content-start">
                                 @if($ad->user->email_verified_at)
                                     <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill" style="font-size: 0.7rem;" title="{{ __('Email Address Verified') }}">
                                         <i class="bi bi-envelope-check-fill me-1"></i>
                                         {{ __('Email Verified') }}
                                     </span>
                                 @endif

                                 @if($ad->user->phone_verified_at)
                                     <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill" style="font-size: 0.7rem;" title="{{ __('Phone Number Verified') }}">
                                         <i class="bi bi-telephone-fill me-1"></i>
                                         {{ __('Phone Verified') }}
                                     </span>
                                 @endif

                                 @if($ad->user->isVerified())
                                     <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill" style="font-size: 0.7rem;" title="{{ __('Identity Verified') }}">
                                         <i class="bi bi-shield-check me-1"></i>
                                         {{ __('Identity Verified') }}
                                     </span>
                                 @endif
                             </div>
                             @endif
                             
                             @if(auth()->id() !== $ad->user_id)
                             <div class="mt-3">
                                 <button wire:click="startChat" class="theme-btn"><i class="bi bi-chat-dots me-2"></i>{{ __('Chat') }}</button>
                             </div>
                             @endif
                        </div>
                        <br>
                        <div class="custom-card border-dark  mt-5 p-3">

                        <div class="d-flex align-items-start">

                            <div class="fs-2 me-3">
                                ⚠️
                            </div>

                            <div>

                                <h5 class="fw-bold mb-3">
                                    {{ __('Safety Tips') }}
                                </h5>

                                <ul class="mb-0 ps-3 text-dark">

                                    <li class="mb-2">
                                        {{ __('Never send money in advance without verifying the seller.') }}
                                    </li>

                                    <li class="mb-2">
                                        {{ __('Always meet in a public and safe place.') }}
                                    </li>

                                    <li class="mb-2">
                                        {{ __('Check the product carefully before making payment.') }}
                                    </li>

                                    <li class="mb-2">
                                        {{ __('Avoid sharing bank details, OTPs, or passwords.') }}
                                    </li>

                                    <li class="mb-2">
                                        {{ __('Beware of fake payment screenshots and scam links.') }}
                                    </li>

                                    <li class="mb-2">
                                        {{ __('Prefer face-to-face deals whenever possible.') }}
                                    </li>

                                    <li class="mb-2">
                                        {{ __('Do not pay booking/token amounts to unknown people.') }}
                                    </li>

                                    <li class="mb-0">
                                        {{ __('adMandi is only a marketplace and is not responsible for transactions between users.') }}
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                    </div>

                </div>
                <div class="col-lg-5">
                    <div class="">
                        
                        <div class="ad-title d-none d-lg-block">
                            {{ $ad->title }}
                        </div>
                        <div class="ad-location d-none d-lg-block">
                            {{ $ad->location?->display_name }} | {{ $ad->created_at?->diffForHumans() }}
                        </div>
                        <div class="ad-price d-none d-lg-block">
                            ₹ {{ number_format($ad->price) }}
                        </div>

                        @if(auth()->id() === $ad->user_id)
                            <div class="card border-primary bg-light-subtle rounded-4 p-3 mb-4 shadow-sm">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fw-bold mb-0 text-primary">
                                        <i class="bi bi-person-fill-gear me-1"></i> {{ __('Manage Your Ad') }}
                                    </h6>
                                    @if($ad->is_featured && $ad->featured_until && now()->lt($ad->featured_until))
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                            👑 {{ __('Featured Ad') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="row g-2 text-center mb-3">
                                    <div class="col-6">
                                        <div class="bg-white p-2 rounded-3 border">
                                            <div class="fs-4 fw-bold text-dark">{{ $ad->views ?? 0 }}</div>
                                            <small class="text-muted"><i class="bi bi-eye me-1"></i> {{ __('Views') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-white p-2 rounded-3 border">
                                            <div class="fs-4 fw-bold text-dark">{{ $ad->wishlists_count ?? 0 }}</div>
                                            <small class="text-muted"><i class="bi bi-heart me-1"></i> {{ __('Likes') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($ad->is_featured && $ad->featured_until && now()->lt($ad->featured_until))
                                    <button class="btn btn-warning text-dark w-100 rounded-pill py-2" disabled title="{{ __('Featured ads cannot be changed') }}">
                                        <i class="bi bi-star-fill me-1"></i> {{ __('Featured until') }} {{ $ad->featured_until->format('d M Y') }}
                                    </button>
                                @else
                                    <a href="{{ url('/profile/boost-ads?ids=' . $ad->id) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold text-white d-flex align-items-center justify-content-center gap-1">
                                        <i class="bi bi-lightning-fill me-1"></i> {{ __('Boost This Ad') }}
                                    </a>
                                @endif
                            </div>
                        @endif

                        @if(auth()->id() !== $ad->user_id)
                            <div class="mb-3 d-none d-lg-block">
                                <button wire:click="startChat" class="theme-btn me-3">
                                    <i class="bi bi-chat-dots"></i>
                                    <span>{{ __('Chat') }}</span>
                                </button>
                            </div>
                        @endif

                        <div class="d-none d-lg-block">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#shareModal">
                                <i class="bi bi-share me-1"></i>
                                <span>{{ __('Share') }}</span>
                            </button>

                            <button class="btn" wire:click="toggleWishList">
                                @if($isWishlisted)
                                    <i class="bi bi-heart-fill text-danger me-1"></i>
                                    <span>{{ __('Wishlisted') }} • <span class="text-danger">{{ __('Remove') }}</span></span>
                                @else
                                    <i class="bi bi-heart me-1"></i>
                                    <span>{{ __('Add to wishlist') }}</span>
                                @endif
                            </button>
                        </div>

                        <div class="map-area d-none d-lg-block">
                            <iframe
                                src="https://maps.google.com/maps?q={{ urlencode($ad->location->name) }}&hl=en&z=12&output=embed"
                                loading="lazy"
                                allowfullscreen>
                            </iframe>
                        </div>
                        

                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <hr>
                    <h5 class="mb-3 fw-bold text-dark"><i class="bi bi-grid-fill text-primary me-2"></i>{{ __('Similar Ads') }}</h5>
                    @if($similarAds->isEmpty())
                        <div class="alert alert-light text-center border py-4 rounded-4 shadow-sm">
                            <i class="bi bi-info-circle text-muted fs-4 d-block mb-2"></i>
                            <span class="text-muted">{{ __('No similar ads found in this category.') }}</span>
                        </div>
                    @else
                        <div class="row">
                            @foreach($similarAds as $similarAd)
                                <div class="col-lg-3 col-md-6 col-6 mb-4" wire:key="similar-ad-col-{{ $similarAd->id }}">
                                    <livewire:components.ad-card
                                        :ad="$similarAd"
                                        :wire:key="'similar-ad-card-'.$similarAd->id"
                                    />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Share Modal --}}
    <div wire:ignore.self class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="shareModalLabel">
                        <i class="bi bi-share-fill text-primary me-2"></i> {{ __('Share this Ad') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-muted small">{{ __('Share this listing with your friends and family across social media networks.') }}</p>
                    
                    {{-- Social Share Grid --}}
                    <div class="d-flex justify-content-around my-4">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($ad->title . ' - ' . url($ad->slug)) }}" target="_blank" class="text-decoration-none text-center">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm hover-scale" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <span class="small text-muted d-block mt-2">{{ __('WhatsApp') }}</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($ad->slug)) }}" target="_blank" class="text-decoration-none text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm hover-scale" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                <i class="bi bi-facebook"></i>
                            </div>
                            <span class="small text-muted d-block mt-2">{{ __('Facebook') }}</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($ad->title) }}&url={{ urlencode(url($ad->slug)) }}" target="_blank" class="text-decoration-none text-center">
                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center shadow-sm hover-scale" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                <i class="bi bi-twitter-x"></i>
                            </div>
                            <span class="small text-muted d-block mt-2">{{ __('Twitter / X') }}</span>
                        </a>
                        <a href="mailto:?subject={{ urlencode($ad->title) }}&body={{ urlencode(url($ad->slug)) }}" class="text-decoration-none text-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm hover-scale" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <span class="small text-muted d-block mt-2">{{ __('Email') }}</span>
                        </a>
                    </div>
                    
                    {{-- Copy Link Row --}}
                    <label class="form-label text-dark small fw-bold">{{ __('Copy Link') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control bg-light rounded-start-3" id="shareLinkInput" value="{{ url($ad->slug) }}" readonly>
                        <button class="btn btn-primary rounded-end-3" type="button" onclick="copyShareLink()">
                            <i class="bi bi-copy me-1"></i> {{ __('Copy') }}
                        </button>
                    </div>
                    <div id="copySuccessMsg" class="text-success small mt-2 d-none">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ __('Link copied to clipboard!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Modal --}}
    <div wire:ignore.self class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="reportModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> {{ __('Report this Ad') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="submitReport">
                    <div class="modal-body py-4">
                        @if (session()->has('report_success'))
                            <div class="alert alert-success border-0 rounded-4 shadow-sm p-3 mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('report_success') }}
                            </div>
                        @else
                            <p class="text-muted small">{{ __("Help us keep our community safe. Please let us know what's wrong with this listing.") }}</p>
                            
                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">{{ __('Reason for reporting') }}</label>
                                <select class="form-select rounded-3 @error('reportReason') is-invalid @enderror" wire:model="reportReason">
                                    <option value="">{{ __('Select a reason') }}</option>
                                    <option value="spam">{{ __('Spam / Duplicate Ad') }}</option>
                                    <option value="fraud">{{ __('Fraud / Scam / Misleading') }}</option>
                                    <option value="wrong_category">{{ __('Wrong Category') }}</option>
                                    <option value="prohibited">{{ __('Prohibited Content / Illegal Item') }}</option>
                                    <option value="other">{{ __('Other reason') }}</option>
                                </select>
                                @error('reportReason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-0">
                                <label class="form-label text-dark small fw-bold">{{ __('Description / Details') }}</label>
                                <textarea class="form-control rounded-3 @error('reportDescription') is-invalid @enderror" rows="4" placeholder="{{ __('Provide more details to help us investigate (min 10 characters)...') }}" wire:model="reportDescription"></textarea>
                                @error('reportDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        @if (session()->has('report_success'))
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        @else
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <span wire:loading.remove wire:target="submitReport">{{ __('Submit Report') }}</span>
                                <span wire:loading wire:target="submitReport" class="spinner-border spinner-border-sm" role="status"></span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    @script
    <script>
        window.copyShareLink = function() {
            const copyText = document.getElementById("shareLinkInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(copyText.value);
            
            const successMsg = document.getElementById("copySuccessMsg");
            successMsg.classList.remove("d-none");
            setTimeout(() => {
                successMsg.classList.add("d-none");
            }, 3000);
        };

        $wire.on('close-report-modal', () => {
            setTimeout(() => {
                const modalEl = document.getElementById('reportModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }, 2500);
        });
    </script>
    @endscript
</div>
