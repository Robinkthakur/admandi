<x-app-layout
    title="AdMandi - Buy & Sell Mobiles, Cars, Electronics, Properties & More"
    meta-description="Discover thousands of local deals on AdMandi. Buy & sell mobiles, cars, electronics, property, furniture, and more. Post free classified ads instantly."
    meta-keywords="classifieds, local marketplace, buy and sell, post free ads, mobiles, cars, electronics, properties, AdMandi"
>
	
	<livewire:homepage.hero-slider />
	<livewire:homepage.categories-section />
	<livewire:homepage.recently-viewed-listings lazy />
	<livewire:homepage.recent-listings lazy />
	

	<section class="d-none">
		<div class="container features-section">
			<div class="row">
				<div class="col-lg-3">
					<div class="featured-card">
						<div class="feature-icon">
							<i class="bi bi-shield-fill-check gradient-text"></i>
						</div>
						<div>
							<h6 class="feature-title">{{ __('100% Verified Users') }}</h6>
							<span class="feature-subtitle">{{ __('Safe & trusted community') }}</span>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="featured-card">
						<div class="feature-icon">
							<i class="bi bi-chat-dots-fill gradient-text"></i>
						</div>
						<div>
							<h6 class="feature-title">{{ __('Chat Securely') }}</h6>
							<span class="feature-subtitle">{{ __('In-app messaging') }}</span>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="featured-card">
						<div class="feature-icon">
							<i class="bi bi-plus-circle-fill gradient-text"></i>
						</div>
						<div>
							<h6 class="feature-title">{{ __('Post Free Ads') }}</h6>
							<span class="feature-subtitle">{{ __('Post unlimited ads quickly') }}</span>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="featured-card">
						<div class="feature-icon">
							<i class="bi bi-tags-fill gradient-text"></i>
						</div>
						<div>
							<h6 class="feature-title">{{ __('Get Best Deals') }}</h6>
							<span class="feature-subtitle">{{ __('Save more everyday') }}</span>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>


	{{-- Trust & Safety Showcase Section --}}
	<section class="py-5 bg-white border-top border-bottom position-relative overflow-hidden">
		<style>
			.trust-badge-glow {
				background: linear-gradient(135deg, var(--light) 0%, #ffffff 100%);
				border: 1px solid rgba(96, 71, 230, 0.15) !important;
				box-shadow: 0 15px 35px rgba(96, 71, 230, 0.05);
				transition: transform 0.3s ease, box-shadow 0.3s ease;
			}
			.trust-badge-glow:hover {
				transform: translateY(-5px);
				box-shadow: 0 20px 40px rgba(96, 71, 230, 0.1);
			}
			.trust-list-item i {
				background: var(--light);
				color: var(--primary);
				width: 32px;
				height: 32px;
				border-radius: 50%;
				display: inline-flex;
				align-items: center;
				justify-content: center;
				font-size: 1rem;
				flex-shrink: 0;
			}
		</style>
		<div class="container">
			<div class="row align-items-center g-5">
				<!-- Graphic / Badge Column -->
				<div class="col-lg-5 text-center order-2 order-lg-1">
					<div class="card trust-badge-glow border-0 rounded-5 p-5 mx-auto" style="max-width: 400px;">
						<div class="mb-4">
							<i class="bi bi-shield-fill-check text-primary" style="font-size: 5rem; filter: drop-shadow(0 10px 15px rgba(96,71,230,0.25));"></i>
						</div>
						<h4 class="fw-bold mb-2">{{ __('AdMandi Safeguard') }}</h4>
						<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-6 mb-3">
							<i class="bi bi-patch-check-fill me-1"></i> {{ __('99.99% Genuine Ads') }}
						</span>
						<p class="text-muted small mb-0">
							{{ __('Our state-of-the-art spam filters and identity checks keep our local marketplace safe and clean.') }}
						</p>
					</div>
				</div>

				<!-- Text / Info Column -->
				<div class="col-lg-7 order-1 order-lg-2">
					<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-3">
						<i class="bi bi-shield-shaded me-1"></i> {{ __('Zero Spam Guarantee') }}
					</span>
					<h2 class="display-6 fw-bold mb-3">
						{{ __('Our Main Focus is a') }} <span class="gradient-text">{{ __('Fraud-Free Marketplace') }}</span>
					</h2>
					<p class="text-muted fs-5 mb-4">
						{{ __('We utilize multi-stage defenses to ensure you trade with confidence. No fake listings, no duplicate ads, and no unverified profiles.') }}
					</p>

					<div class="row g-4 mb-4">
						<div class="col-md-6">
							<div class="d-flex gap-3 trust-list-item">
								<i class="bi bi-person-check-fill"></i>
								<div>
									<h6 class="fw-bold mb-1">{{ __('100% Verified Sellers') }}</h6>
									<p class="text-muted small mb-0">{{ __('Sellers verify their accounts via OTP authentication to eliminate bot activities.') }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="d-flex gap-3 trust-list-item">
								<i class="bi bi-chat-left-dots-fill"></i>
								<div>
									<h6 class="fw-bold mb-1">{{ __('Secure In-App Chat') }}</h6>
									<p class="text-muted small mb-0">{{ __('Communicate privately and securely with automatic anti-scam warnings.') }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="d-flex gap-3 trust-list-item">
								<i class="bi bi-robot"></i>
								<div>
									<h6 class="fw-bold mb-1">{{ __('AI Anti-Fraud Shield') }}</h6>
									<p class="text-muted small mb-0">{{ __('Automatic analysis flags outliers, pricing patterns, and duplicate ads.') }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="d-flex gap-3 trust-list-item">
								<i class="bi bi-lightning-fill"></i>
								<div>
									<h6 class="fw-bold mb-1">{{ __('Swift Takedowns') }}</h6>
									<p class="text-muted small mb-0">{{ __('Flagged or reported ads are investigated and removed within 5 minutes.') }}</p>
								</div>
							</div>
						</div>
					</div>

					<div>
						<a href="{{ route('about') }}" class="theme-btn d-inline-flex align-items-center">
							{{ __('Explore Safety Infrastructure') }} <i class="bi bi-arrow-right ms-2"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="py-5 app-section">

	    <div class="container">

	        <div class="row align-items-center  overflow-hidden p-4 p-lg-5">

	            <!-- Content -->
	            <div class="col-lg-6 mb-5 mb-lg-0">

	                <span class="badge bg-dark px-3 py-2 rounded-pill mb-3">
	                    📱 {{ __('Try Our Mobile App') }}
	                </span>

	                <h2 class="display-5 fw-bold mb-3">
	                    {{ __('Buy & Sell Faster with') }} 
	                    <span class="gradient-text">adMandi App</span>
	                </h2>

	                <p class="text-muted fs-5 mb-4">
	                    {{ __('Discover thousands of deals on mobiles, cars, electronics, property and more. Post ads instantly and connect directly with buyers & sellers.') }}
	                </p>

	                <div class="d-flex flex-wrap gap-3">

	                    <!-- Play Store -->
	                    <a href="#"
	                       class="theme-btn d-flex align-items-center px-3 py-2 rounded-4">

	                        <img 
	                            src="https://cdn-icons-png.flaticon.com/512/888/888857.png"
	                            width="35"
	                            class="me-2"
	                        >

	                        <div class="text-start">
	                            <small class="d-block lh-1">
	                                {{ __('Get it on') }}
	                            </small>

	                            <strong>
	                                {{ __('Google Play') }}
	                            </strong>
	                        </div>

	                    </a>

	                    <!-- App Store -->
	                    <a href="#"
	                       class="btn btn-light d-flex align-items-center px-3 py-2 rounded-4">

	                        <img 
	                            src="https://cdn-icons-png.flaticon.com/512/888/888841.png"
	                            width="35"
	                            class="me-2"
	                        >

	                        <div class="text-start">
	                            <small class="d-block lh-1">
	                                {{ __('Download on the') }}
	                            </small>

	                            <strong>
	                                {{ __('App Store') }}
	                            </strong>
	                        </div>

	                    </a>

	                </div>
					<h4 class="mt-4 text-italic gradient-text"><i>We are working to launch the app soon. Stay tuned!</i></h4>

	            </div>

	            <!-- Image -->
	            <div class="col-lg-6 text-center">

	                <img 
	                    src="{{ asset('images/app-home.webp') }}"
	                    class="img-fluid rounded-5 shadow-lg"
	                    style="max-height:600px;object-fit:cover;"
	                >

	            </div>

	        </div>

	    </div>

	</section>
</x-app-layout>