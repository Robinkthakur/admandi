<x-app-layout
    title="Refund Policy - AdMandi"
    meta-description="Read our Refund Policy to understand the conditions under which refunds are provided for premium listing packages on AdMandi."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Refund Policy') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <h1 class="fw-bold mb-4 gradient-text">{{ __('Refund Policy') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: May 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p>{{ __('Thank you for choosing AdMandi. We value your business and aim to provide a transparent and fair marketplace experience. This Refund Policy describes the terms under which refunds are offered for our paid listing services, boosting packages, and advertiser tools.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. General Terms') }}</h4>
                <p>{{ __('Since AdMandi offers digital products (listing upgrades, advertising spaces, and verification badges) that are activated instantly upon successful payment, all transactions are generally final and non-refundable. By completing your purchase, you agree to this term.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. Exceptions for Refund Eligibility') }}</h4>
                <p>{{ __('A refund may be issued in the following specific circumstances:') }}</p>
                <ul>
                    <li>{{ __('Double Charging: You were charged twice for the same transaction due to a technical error in our payment processing system.') }}</li>
                    <li>{{ __('Service Outage: A severe system outage prevented your boosted listing from appearing on the platform for more than 48 consecutive hours, rendering the service unusable.') }}</li>
                    <li>{{ __('Fraudulent Activity: You have proof of unauthorized use of your credit card or payment account by a third party on our website, subject to investigation.') }}</li>
                </ul>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. Non-Refundable Situations') }}</h4>
                <p>{{ __('Refund requests will be denied in the following cases:') }}</p>
                <ul>
                    <li>{{ __('Change of Mind: You change your mind after upgrading your ad or purchasing a verification package.') }}</li>
                    <li>{{ __('Ad Removal: Your listing is removed from the platform due to violations of our Terms & Conditions (e.g. selling prohibited goods or posting misleading information).') }}</li>
                    <li>{{ __('Item Sold: Your item is sold before the boosted/featured period expires.') }}</li>
                    <li>{{ __('Lack of Inquiries: You do not receive the expected number of buyer inquiries or offers from your boosted listing.') }}</li>
                </ul>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Refund Request Process') }}</h4>
                <p>{{ __('To submit a refund request, please contact our Support Team through the Help Center or by email at support@admandi.com within 7 days of the transaction date. Please include your Transaction ID, Account Email, and a detailed explanation of why you are requesting a refund. Approved refunds will be processed within 5-10 business days back to the original payment method.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
