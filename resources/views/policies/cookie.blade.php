<x-app-layout
    title="Cookie Policy - AdMandi"
    meta-description="Read our Cookie Policy to learn how AdMandi uses cookies and other tracking technologies to enhance your experience."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Cookie Policy') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <h1 class="fw-bold mb-4 gradient-text">{{ __('Cookie Policy') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: May 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p>{{ __('This Cookie Policy explains how AdMandi uses cookies and similar tracking technologies on our website and mobile application. By using our platform, you consent to the use of cookies as described in this policy.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. What are Cookies?') }}</h4>
                <p>{{ __('Cookies are small text files that are stored on your computer or mobile device when you visit a website. They are widely used to make websites work more efficiently, improve user experience, and provide analytical data to website owners.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. How We Use Cookies') }}</h4>
                <p>{{ __('AdMandi uses cookies for several purposes, including:') }}</p>
                <ul>
                    <li><strong>{{ __('Essential Cookies:') }}</strong> {{ __('These cookies are necessary for the website to function properly. They enable core features like user authentication, security, and session management.') }}</li>
                    <li><strong>{{ __('Preference Cookies:') }}</strong> {{ __('These cookies allow us to remember your settings and preferences, such as your chosen language, location settings, and layout choices.') }}</li>
                    <li><strong>{{ __('Analytics Cookies:') }}</strong> {{ __('These cookies help us analyze how visitors interact with our platform by collecting information about page views, traffic sources, and user activity, allowing us to optimize performance.') }}</li>
                    <li><strong>{{ __('Marketing Cookies:') }}</strong> {{ __('These cookies are used to track visitors across websites. They allow advertisers to display relevant and engaging ads based on user behavior and interests.') }}</li>
                </ul>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. Third-Party Cookies') }}</h4>
                <p>{{ __('In addition to our first-party cookies, we may also work with third-party service providers (such as Google Analytics or social networks) who set cookies on our platform to help us analyze traffic and integration.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Managing Cookies') }}</h4>
                <p>{{ __('Most web browsers allow you to control cookies through their settings. You can choose to block all cookies, accept only certain cookies, or delete cookies that have already been saved. Please note that if you disable cookies, some sections or features of AdMandi may not function correctly.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
