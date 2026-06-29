<x-app-layout
    title="Refund Policy - AdMandi"
    meta-description="Review the AdMandi Refund Policy. Learn about refund eligibility, double charge resolutions, timelines, and how to contact billing support."
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
            <h1 class="fw-bold mb-3 gradient-text">{{ __('Refund Policy') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: June 18, 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p class="lead text-muted">{{ __('Thank you for choosing AdMandi. Because our advertising boosts, verified seller status, and limit upgrades are digital products activated instantly, we have established this transparent Refund Policy to govern all payment transactions.') }}</p>
                
                <hr class="my-4 text-muted">

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. General No-Refund Policy') }}</h4>
                <p>{{ __('All purchases on AdMandi (including but not limited to Featured Ad Boosts, Bump Up Credits, and User Verification Packages) are digital in nature. Once a payment is completed, the corresponding features, credits, or verification workflows are immediately applied to your account or listing. Consequently, all transactions are considered final and non-refundable, except as explicitly detailed in Section 2 below.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. Exceptions & Refund Eligibility') }}</h4>
                <p>{{ __('We understand that exceptional issues can occur with billing. You may be eligible for a refund or account credit in the following scenarios:') }}</p>
                <ul>
                    <li><strong>{{ __('System Double Charging:') }}</strong> {{ __('If you were charged twice for the exact same package or upgrade due to an official payment gateway timeout, API error, or double transaction processing, we will refund the duplicate payment.') }}</li>
                    <li><strong>{{ __('Severe Technical Failures:') }}</strong> {{ __('If a platform-side bug prevents your paid featured listing from rendering or appearing in search queries for more than 48 consecutive hours, we will verify the outage and issue a full or partial refund or run-time extension.') }}</li>
                    <li><strong>{{ __('Unauthorized Transactions:') }}</strong> {{ __('If you identify unauthorized card use or fraudulent billing on our website, you must contact us and your bank immediately. We will investigate the claim and process appropriate refunds if the transaction is confirmed unauthorized.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. Explicit Non-Refundable Scenarios') }}</h4>
                <p>{{ __('Under no circumstances will refunds be issued for:') }}</p>
                <ul>
                    <li><strong>{{ __('Classified Violations:') }}</strong> {{ __('If your ad is removed, flag-deleted, or your account is suspended because you listed prohibited goods (weapons, illegal services, drugs) or violated our general Terms & Conditions.') }}</li>
                    <li><strong>{{ __('Rapid Product Sales:') }}</strong> {{ __('If the item you advertised sells quickly (e.g. within 2 hours or days) and you choose to mark the ad as "Sold" or remove the listing before your purchased boost duration (e.g., 30 days) expires.') }}</li>
                    <li><strong>{{ __('Change of Mind:') }}</strong> {{ __('If you change your mind, decide you don\'t want to boost the listing anymore, or decide you want a different package after the purchase is finalized.') }}</li>
                    <li><strong>{{ __('Low Lead Volume:') }}</strong> {{ __('We cannot guarantee the quantity, quality, or authenticity of buyer replies or phone inquiries. A lack of buyer interest is not grounds for a refund.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Razorpay and Payment Processors') }}</h4>
                <p>{{ __('We process payments through secure, certified gateways like Razorpay. Depending on your choice of payment (credit card, debit card, UPI, net banking, or wallet), transaction processing fees are deducted by the processor. When a refund is officially approved by AdMandi, the funds are sent back to the payment processor who coordinates the deposit back to your original source of payment.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('5. Refund Claim Procedure') }}</h4>
                <p>{{ __('To submit a claim, please follow these steps within 7 calendar days of the transaction:') }}</p>
                <ol>
                    <li>{{ __('Locate your payment confirmation email and copy the Transaction ID or Payment ID.') }}</li>
                    <li>{{ __('Visit the') }} <a href="{{ route('help-center') }}">{{ __('Help & Support Center') }}</a> {{ __('or write to') }} <a href="mailto:support@admandi.co.in">support@admandi.co.in</a>.</li>
                    <li>{{ __('Provide your registered account email, the Transaction ID, the date of the charge, and a brief description explaining why you believe your case falls under our eligibility exceptions.') }}</li>
                </ol>
                <p>{{ __('All requests are reviewed by our billing desk. We will notify you of approval or rejection within 3-5 business days. Approved refunds are processed immediately and take 5 to 10 banking days to reflect in your account, depending on your bank\'s clearing cycle.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
