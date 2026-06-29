<x-app-layout
    title="Terms & Conditions - AdMandi"
    meta-description="Review the AdMandi Terms & Conditions. Understand the rules, user responsibilities, listing policies, and safety guidelines for our marketplace."
>
    {{-- Breadcrumbs --}}
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Terms & Conditions') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
            <h1 class="fw-bold mb-3 gradient-text">{{ __('Terms & Conditions') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: June 18, 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p class="lead text-muted">{{ __('Welcome to AdMandi. By accessing, browsing, or using our website, mobile applications, or any services provided on the platform, you agree to comply with and be bound by the following Terms and Conditions. Please review them carefully before using our platform.') }}</p>
                
                <hr class="my-4 text-muted">

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. Intermediary Status & Platform Scope') }}</h4>
                <p>{{ __('AdMandi operates strictly as an online classifieds marketplace. We provide a platform for third-party sellers to advertise their items and services, and for buyers to discover those listings. We are an intermediary as defined under the Information Technology Act. Accordingly:') }}</p>
                <ul>
                    <li>{{ __('We do not own, inspect, manufacture, store, ship, or verify the quality of any items advertised on our platform.') }}</li>
                    <li>{{ __('We are not party to any actual transaction, negotiation, delivery, or transfer of funds between buyers and sellers.') }}</li>
                    <li>{{ __('Any transaction concluded between a buyer and a seller is solely at their own risk, and AdMandi assumes zero liability for disputes, losses, damages, or scams arising from such transactions.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. Account Registration and Security') }}</h4>
                <p>{{ __('To list advertisements, message other users, or purchase upgrades, you must register for an account. By registering, you agree to:') }}</p>
                <ul>
                    <li>{{ __('Provide accurate, current, and complete details, and update them as necessary.') }}</li>
                    <li>{{ __('Keep your account login credentials and OTP codes highly confidential.') }}</li>
                    <li>{{ __('Ensure you are at least 18 years of age or possess legal parental consent.') }}</li>
                    <li>{{ __('Assume full responsibility for all activities, messages, and listings created under your account.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. Classified Listing Rules & Policies') }}</h4>
                <p>{{ __('Sellers are solely liable for the listings they publish. All advertisements must conform to the following guidelines:') }}</p>
                <ul>
                    <li><strong>{{ __('Prohibited Items:') }}</strong> {{ __('You must not list or advertise weapons, firearms, drugs, prescription medication, alcoholic beverages, tobacco products, adult/pornographic content, fireworks, hazardous chemicals, counterfeit items, stolen goods, protected wildlife, or any items/services prohibited by local and federal laws.') }}</li>
                    <li><strong>{{ __('Honesty and Truthfulness:') }}</strong> {{ __('Listing descriptions, prices, titles, and photographs must accurately represent the current state and condition of the item. Misleading descriptions or stock photos that do not match the real item are strictly prohibited.') }}</li>
                    <li><strong>{{ __('Duplicate & Spam Listings:') }}</strong> {{ __('Posting duplicate listings for the same item or service in multiple locations or categories is prohibited.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Safety Guidelines & Scams Warning') }}</h4>
                <p class="text-danger fw-semibold"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ __('PLEASE READ THIS CAREFULLY TO AVOID SCAMS:') }}</p>
                <ul>
                    <li>{{ __('Always meet in person in a safe, busy, and public location (e.g. outside a police station, shopping mall, or bank).') }}</li>
                    <li>{{ __('Do not send advance payments, deposit money, or ship products to strangers before receiving the full agreed-upon amount.') }}</li>
                    <li>{{ __('Thoroughly inspect the item (such as verification of mobile IMEI, car engine check, or product functioning) before paying.') }}</li>
                    <li>{{ __('Be highly cautious of offers that seem too good to be true, or buyers/sellers who pressure you to complete transactions off the platform.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('5. Paid Boosts and Verification Packages') }}</h4>
                <p>{{ __('AdMandi offers paid plans, featured listings boosts, and verification packages. The terms for paid services are:') }}</p>
                <ul>
                    <li>{{ __('Fees for listings, packages, and verification badges are clearly displayed on the payment screens.') }}</li>
                    <li>{{ __('Payments are processed securely via third-party processors (such as Razorpay). We do not store credit card numbers or banking passwords on our servers.') }}</li>
                    <li>{{ __('Verification badges are intended to build platform trust. However, a verification badge does NOT constitute an endorsement or absolute warranty by AdMandi of a user\'s behavior, legitimacy, or the items they sell.') }}</li>
                    <li>{{ __('Refunds for any paid listings or packages are governed strictly by our Refund Policy.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('6. Intellectual Property') }}</h4>
                <p>{{ __('All intellectual property rights associated with AdMandi, including logos, designs, page layouts, templates, styling, software code, database structures, and trademarks, are owned by AdMandi. By uploading content (descriptions, photographs, prices) to our platform, you grant AdMandi a non-exclusive, worldwide, royalty-free, perpetual license to use, reproduce, display, and distribute that content on the platform.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('7. Limitation of Liability') }}</h4>
                <p>{{ __('In no event shall AdMandi, its founders, directors, employees, or agents be liable for any direct, indirect, incidental, special, consequential, or punitive damages (including loss of profits, loss of data, transaction losses, or product defects) resulting from or connected to your use of the platform. The platform is provided "as is" and "as available" without warranties of any kind.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('8. Termination & Suspension') }}</h4>
                <p>{{ __('We reserve the absolute right to suspend, terminate, or delete any account, block specific phone numbers/IP addresses, or remove any listings from the platform immediately, without prior notice, if we suspect a violation of these Terms & Conditions, fraudulent transactions, or any activity that compromises the safety of other users.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('9. Governing Law & Jurisdiction') }}</h4>
                <p>{{ __('These Terms and Conditions are governed by the laws of India. Any legal action, dispute, or claim arising from these terms or your use of the platform shall be submitted to the exclusive jurisdiction of the competent courts of Punjab, India.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('10. Contacting Support') }}</h4>
                <p>{{ __('If you have questions about these Terms, or if you need to report scam behavior, copyright violations, or abusive content, please contact our support team at:') }}</p>
                <div class="bg-light p-3 rounded-3 border">
                    <p class="mb-1"><strong>{{ __('AdMandi Legal Compliance Team') }}</strong></p>
                    <p class="mb-1">{{ __('Email:') }} <a href="mailto:support@admandi.co.in">support@admandi.co.in</a></p>
                    <p class="mb-0">{{ __('Help Desk:') }} <a href="{{ route('help-center') }}">{{ __('Help & Support Center') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
