<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title ?? 'AdMandi - Classified Ads Marketplace' }}</title>

	<!-- SEO Meta Tags -->
	<meta name="description" content="{{ $metaDescription ?? 'Buy & sell mobiles, cars, electronics, property, furniture, and more on AdMandi. Connect directly with verified buyers and sellers near you.' }}">
	@if(!empty($metaKeywords))
	<meta name="keywords" content="{{ $metaKeywords }}">
	@else
	<meta name="keywords" content="classifieds, marketplace, buy and sell, buy car, buy mobile, local marketplace, free ads, AdMandi">
	@endif
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="{{ url()->current() }}">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="{{ $ogType ?? 'website' }}">
	<meta property="og:title" content="{{ $title ?? 'AdMandi - Classified Ads Marketplace' }}">
	<meta property="og:description" content="{{ $metaDescription ?? 'Buy & sell mobiles, cars, electronics, property, furniture, and more on AdMandi. Connect directly with verified buyers and sellers near you.' }}">
	<meta property="og:image" content="{{ $ogImage ?? asset('favicon.png') }}">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta property="og:site_name" content="AdMandi">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:title" content="{{ $title ?? 'AdMandi - Classified Ads Marketplace' }}">
	<meta property="twitter:description" content="{{ $metaDescription ?? 'Buy & sell mobiles, cars, electronics, property, furniture, and more on AdMandi. Connect directly with verified buyers and sellers near you.' }}">
	<meta property="twitter:image" content="{{ $ogImage ?? asset('favicon.png') }}">

	<!-- bootstrap css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

	<!-- slick slider -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

	<!-- main css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

	<!-- icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

	<!-- responsive css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

    {{-- jquery --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    {{-- icons --}}
    <link rel="icon" href="{{ asset('favicon.png') }}">

</head>
<body>
	
    
    <div class="app-header">
        <header class='header'>
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <a href="javascript:void(0)" onclick="window.history.back()">
                        <i class="bi bi-arrow-left fs-5"></i>
                    </a>   
                    <span>{{ isset($headerTitle) ? __($headerTitle) : __('Post an Ad') }}</span>
                    
                </div>
                <div>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('logo.png') }}" style="width:90px" alt="">
                    </a>
                </div>

                <div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#helpModal" class="text-decoration-none">
                        <i class="bi bi-info-circle me-1"></i>
                        <span>{{ __('Help') }}</span>
                    </a>
                </div>
            </div>
        </header>
    </div>

    {{  $slot }}


    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="helpModalLabel">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i> {{ __('How to Post a Great Ad') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                                <i class="bi bi-tag-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('1. Choose Category') }}</h6>
                                <p class="text-muted small mb-0">{{ __('Select the category that best matches your product. This ensures interested buyers can easily find it.') }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                                <i class="bi bi-file-text-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('2. Add Ad Details') }}</h6>
                                <p class="text-muted small mb-0">{{ __("Enter a descriptive title, detail the item's condition in the description, set a fair price, and specify your location.") }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                                <i class="bi bi-images"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('3. Upload Photos') }}</h6>
                                <p class="text-muted small mb-0">{{ __('Add up to 10 clear, high-quality photos. Ads with good images receive up to 5x more responses.') }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ __('4. Review & Publish') }}</h6>
                                <p class="text-muted small mb-0">{{ __('Review all details, then click publish. Your ad will be reviewed and will go live shortly after.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-primary w-100 rounded-3" data-bs-dismiss="modal">{{ __('Got it, thanks!') }}</button>
                </div>
            </div>
        </div>
    </div>

    <livewire:auth.login />

    <livewire:components.layouts.notifications />
    <livewire:components.layouts.category-modal />
    

	
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

	<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	
	<script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Helper to save location to storage and cookies
        function saveLocationToStorageAndCookies(latitude, longitude) {
            const locationData = {
                latitude: latitude,
                longitude: longitude,
                timestamp: Date.now()
            };
            localStorage.setItem('cached_user_location', JSON.stringify(locationData));
            
            // Set cookies for 30 minutes
            document.cookie = "user_lat=" + latitude + "; path=/; max-age=1800";
            document.cookie = "user_lng=" + longitude + "; path=/; max-age=1800";
        }

        // Function to auto-detect location on first visit
        function autoDetectLocation() {
            const hasUserCoords = document.cookie.split(';').some(c => c.trim().startsWith('user_lat='));
            
            if (!hasUserCoords) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        saveLocationToStorageAndCookies(lat, lng);
                        
                        // Clear location_id to force backend recalculation
                        document.cookie = "location_id=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                        
                        // Reload the page
                        window.location.reload();
                    }, (error) => {
                        console.error("Auto geolocation failed: ", error);
                        document.cookie = "user_lat=failed; path=/; max-age=1800";
                        document.cookie = "user_lng=failed; path=/; max-age=1800";
                    });
                }
            } else {
                const cachedData = localStorage.getItem('cached_user_location');
                if (!cachedData) {
                    const cookies = document.cookie.split(';').reduce((acc, cookie) => {
                        const [key, value] = cookie.split('=').map(c => c.trim());
                        acc[key] = value;
                        return acc;
                    }, {});
                    const lat = cookies['user_lat'];
                    const lng = cookies['user_lng'];
                    if (lat && lng && lat !== 'failed' && lng !== 'failed') {
                        saveLocationToStorageAndCookies(lat, lng);
                    }
                }
            }
        }
        autoDetectLocation();
    </script>
	
</body>
</html>