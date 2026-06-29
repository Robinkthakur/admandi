<x-app-layout
    title="Privacy Policy - AdMandi"
    meta-description="Read the AdMandi Privacy Policy. Learn how we collect, process, secure, and share your personal information in compliance with data privacy standards."
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
            <h1 class="fw-bold mb-3 gradient-text">{{ __('Privacy Policy') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: June 18, 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p class="lead text-muted">{{ __('At AdMandi, we are dedicated to protecting your privacy and ensuring the security of your personal data. This Privacy Policy describes how we collect, use, process, and disclose your information when you access or use our website, mobile application, and classifieds platform.') }}</p>
                
                <hr class="my-4 text-muted">

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. Introduction & Overview') }}</h4>
                <p>{{ __('AdMandi operates as an online classifieds marketplace platform. By registering an account, posting listings, or using any of our services, you consent to the collection, storage, transfer, and processing of your personal information as described in this policy. We process data in compliance with standard data protection regulations, including information technology regulations for intermediary platforms.') }}</p>
                
                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. Information We Collect') }}</h4>
                <p>{{ __('We collect various categories of information depending on how you interact with AdMandi:') }}</p>
                <ul>
                    <li><strong>{{ __('Account & Profile Data:') }}</strong> {{ __('When you register, we collect your name, email address, phone number, and password. If you upload a profile photo, selfie, or ID proof for account verification, we collect and store those files securely.') }}</li>
                    <li><strong>{{ __('Classified Listings Content:') }}</strong> {{ __('Any information you include in a listing (titles, descriptions, price, category, photos, and location details) is stored and displayed publicly on our platform.') }}</li>
                    <li><strong>{{ __('Geolocation and Coordinates:') }}</strong> {{ __('To show you ads in your region or display nearby listings, we collect geographic coordinates (latitude and longitude) through browser geolocation services or IP addresses, with your explicit permission.') }}</li>
                    <li><strong>{{ __('Usage and Device Information:') }}</strong> {{ __('We automatically collect log information, including your IP address, browser type, operating system, page views, access times, and system activity via tracking technologies like cookies.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. How We Use Your Information') }}</h4>
                <p>{{ __('Your personal data is used to provide, improve, and secure the AdMandi experience, specifically for:') }}</p>
                <ul>
                    <li>{{ __('Creating and managing user accounts and processing identity verifications.') }}</li>
                    <li>{{ __('Enabling local marketplace matching by connecting buyers and sellers based on geographic proximity.') }}</li>
                    <li>{{ __('Processing payments and verification packages via integrated payment gateways (such as Razorpay).') }}</li>
                    <li>{{ __('Facilitating platform communication (in-app chat, transaction status notifications, and updates).') }}</li>
                    <li>{{ __('Detecting, preventing, and prosecuting fraudulent behavior, spam, scams, and policy violations.') }}</li>
                    <li>{{ __('Analyzing platform performance and traffic patterns to optimize layout, performance, and functionality.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Data Sharing and Intermediary Disclosures') }}</h4>
                <p>{{ __('We prioritize your data privacy and share your information only under the following conditions:') }}</p>
                <ul>
                    <li><strong>{{ __('Public Marketplace Visibility:') }}</strong> {{ __('Classified listings are fully public. The title, description, price, pictures, and approximate location are visible to all users. Your phone number is only displayed to logged-in users if you explicitly enable it in your listing configurations.') }}</li>
                    <li><strong>{{ __('Service Providers:') }}</strong> {{ __('We share payment details with payment processors (e.g. Razorpay) and SMS API gateways (e.g. APITXT) solely to complete transactions and send OTP verifications.') }}</li>
                    <li><strong>{{ __('Legal and Compliance Requirements:') }}</strong> {{ __('We may disclose data to law enforcement, government bodies, or judicial authorities if required by subpoena, court order, or to cooperate with official investigations into fraudulent activities.') }}</li>
                    <li><strong>{{ __('Business Transfers:') }}</strong> {{ __('In the event of a merger, acquisition, restructuring, or sale of assets, user data may be transferred as a business asset, subject to continuing privacy promises.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('5. Data Retention, Security, and Storage') }}</h4>
                <p>{{ __('We employ industry-standard electronic, administrative, and physical security measures (including SSL encryption, secure hashing protocols, and firewalls) to protect your information against unauthorized access, loss, or alteration. All identity verification materials (selfies and ID proofs) are stored in secure subdirectories and are accessed only by authorized administration staff to verify credentials, after which they are handled in accordance with strict security standards. We retain your data for as long as your account remains active or as required to fulfill legal, tax, or accounting obligations.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('6. Children\'s Privacy') }}</h4>
                <p>{{ __('AdMandi is a general audience platform not intended for children under the age of 18. We do not knowingly collect personal data from individuals under 18 years of age. If we discover that a minor has created an account, we will take immediate steps to terminate the account and erase their data.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('7. Your Rights and Choices') }}</h4>
                <p>{{ __('You have control over how your data is handled on AdMandi:') }}</p>
                <ul>
                    <li><strong>{{ __('Access and Rectification:') }}</strong> {{ __('You can access and update your profile information, phone number, and location at any time through the profile edit panel.') }}</li>
                    <li><strong>{{ __('Data Portability & Deletion:') }}</strong> {{ __('You may request details of the personal data we hold or request complete deletion of your account. Note that some data may remain cached or archived in backups for legal audit purposes for a limited time.') }}</li>
                    <li><strong>{{ __('Location Permissions:') }}</strong> {{ __('You can toggle browser geolocation settings to enable or disable real-time coordinate sharing.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('8. Changes to this Privacy Policy') }}</h4>
                <p>{{ __('We reserve the right to modify this Privacy Policy at any time. If we make material modifications, we will publish the updated policy on this page and revise the "Last Updated" date. We encourage you to review this policy periodically to stay informed about our data protection practices.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('9. Contact and Grievance redressal') }}</h4>
                <p>{{ __('If you have any questions, concerns, or complaints regarding this Privacy Policy or our data processing activities, please contact our Grievance Officer at:') }}</p>
                <div class="bg-light p-3 rounded-3 border">
                    <p class="mb-1"><strong>{{ __('AdMandi Support Desk') }}</strong></p>
                    <p class="mb-1">{{ __('Email:') }} <a href="mailto:support@admandi.co.in">support@admandi.co.in</a></p>
                    <p class="mb-0">{{ __('Address: Classifieds Intermediary Division, Punjab, India') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
