<x-app-layout
    title="Sitemap - AdMandi Directory"
    meta-description="Browse the structured sitemap of AdMandi to quickly navigate through our marketplace sections, categories, and legal policies."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Sitemap') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-3 gradient-text">{{ __('Sitemap') }}</h1>
                <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                    {{ __('Find quick links to navigate all the main sections, popular categories, and legal pages of AdMandi.') }}
                </p>
            </div>

            <div class="row g-5">
                {{-- Column 1: Main Links --}}
                <div class="col-md-4">
                    <div class="h-100 p-4 rounded-4 bg-light border">
                        <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-link-45deg me-1"></i> {{ __('Quick Links') }}</h4>
                        <ul class="list-unstyled lh-lg fs-5">
                            <li class="mb-2">
                                <a href="{{ url('/') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Home') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('about') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('About') }} AdMandi</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/ads') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Categories') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('post-ad') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Post Ad') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('profile') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('My Account') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('contact') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Contact Us') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Column 2: Legal & Support --}}
                <div class="col-md-4">
                    <div class="h-100 p-4 rounded-4 bg-light border">
                        <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-info-circle me-1"></i> {{ __('Legal & Help') }}</h4>
                        <ul class="list-unstyled lh-lg fs-5">
                            <li class="mb-2">
                                <a href="{{ route('privacy-policy') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Privacy Policy') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('terms-conditions') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Terms & Conditions') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('refund-policy') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Refund Policy') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('cookie-policy') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Cookie Policy') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('help-center') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Help Center') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Categories --}}
                <div class="col-md-4">
                    <div class="h-100 p-4 rounded-4 bg-light border">
                        <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-grid me-1"></i> {{ __('Popular Categories') }}</h4>
                        <ul class="list-unstyled lh-lg fs-5">
                            <li class="mb-2">
                                <a href="{{ url('/ads/' . (get_location()?->slug ?? 'all') . '/vehicles') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Cars') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/ads/' . (get_location()?->slug ?? 'all') . '/mobiles') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Mobiles') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/ads/' . (get_location()?->slug ?? 'all') . '/electronics') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Electronics') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/ads/' . (get_location()?->slug ?? 'all') . '/property') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Property') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/ads/' . (get_location()?->slug ?? 'all') . '/home-furniture') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Furniture') }}</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ url('/ads/' . (get_location()?->slug ?? 'all') . '/fashion') }}" class="text-dark hover-text-primary"><i class="bi bi-chevron-right text-muted me-1 small"></i> {{ __('Fashion') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
