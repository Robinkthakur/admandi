<x-app-layout
    title="Privacy Policy - AdMandi"
    meta-description="Read our Privacy Policy to understand how AdMandi collects, uses, and protects your personal information."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Privacy Policy') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <h1 class="fw-bold mb-4 gradient-text">{{ __('Privacy Policy') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: May 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p>{{ __('Welcome to AdMandi. Your privacy is extremely important to us. This Privacy Policy describes how we collect, use, process, and share your personal information when you use our website, mobile application, and other services.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. Information We Collect') }}</h4>
                <p>{{ __('We collect information you provide directly to us when creating an account, posting an ad, updating your profile, or communicating with buyers and sellers. This includes your name, email address, phone number, profile photo, location details, and listing descriptions.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. How We Use Your Information') }}</h4>
                <p>{{ __('We use the information we collect to operate and improve our marketplace, connect buyers and sellers near their location, personalize your experience, send notifications, prevent fraud and spam, and comply with legal obligations.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. Information Sharing and Disclosure') }}</h4>
                <p>{{ __('Your listing title, description, price, city/state location, and creation date are visible to any visitor to the website. Your phone number is only visible if you choose to display it. We do not sell your personal data to third parties.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Data Security') }}</h4>
                <p>{{ __('We implement industry-standard security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. However, no transmission method over the internet is 100% secure.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('5. Your Rights and Choices') }}</h4>
                <p>{{ __('You can access, update, or delete your account information at any time by logging into your profile. You can also adjust your location permissions and notification preferences from your settings.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('6. Changes to this Policy') }}</h4>
                <p>{{ __('We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
