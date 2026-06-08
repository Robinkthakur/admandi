<x-app-layout
    title="Terms & Conditions - AdMandi"
    meta-description="Read our Terms and Conditions to understand the rules and guidelines for using the AdMandi marketplace."
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
            <h1 class="fw-bold mb-4 gradient-text">{{ __('Terms & Conditions') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: May 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p>{{ __('Welcome to AdMandi. By accessing or using our website, mobile application, and related services, you agree to comply with and be bound by the following Terms and Conditions. Please read them carefully.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. Account Registration') }}</h4>
                <p>{{ __('To access certain features of the platform, such as posting advertisements or messaging other users, you must register for an account. You agree to provide accurate, current, and complete information, and to keep your login credentials secure.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. Listing Guidelines') }}</h4>
                <p>{{ __('Users are solely responsible for the content of their listings. All ads must be legal, decent, honest, and truthful. You must not post advertisements for prohibited items, illegal goods, weapons, drugs, adult content, or services that violate local laws.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. User Interactions and Transactions') }}</h4>
                <p>{{ __('AdMandi is a classifieds marketplace. We do not participate in, control, or take responsibility for transactions, payments, deliveries, or communications between buyers and sellers. You should use caution and perform face-to-face transactions in safe public locations.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Boosting and Paid Services') }}</h4>
                <p>{{ __('We offer paid packages to boost listings (e.g. Featured status). All fees are clearly communicated prior to purchase. Payments are processed through secure gateways. Except as defined in our Refund Policy, all purchases are non-refundable.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('5. Intellectual Property') }}</h4>
                <p>{{ __('The logos, layout, design, graphics, database structure, and source code of AdMandi are the intellectual property of AdMandi. Users retain ownership of photos and text uploaded in listings, but grant AdMandi a non-exclusive license to display this content on the platform.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('6. Limitation of Liability') }}</h4>
                <p>{{ __('AdMandi is provided "as is" without warranties of any kind. We are not liable for any direct, indirect, incidental, or consequential damages resulting from user listings, fraudulent activities, website downtime, or transactions between users.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('7. Termination') }}</h4>
                <p>{{ __('We reserve the right to suspend or terminate accounts, remove listings, or block users from the platform at our sole discretion, without prior notice, for violating these Terms and Conditions or engaging in fraudulent behavior.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
