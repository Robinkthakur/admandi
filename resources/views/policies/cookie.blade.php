<x-app-layout
    title="Cookie Policy - AdMandi"
    meta-description="Review the AdMandi Cookie Policy. Understand how we use cookies, session storage, tracking scripts, and geolocation caching to optimize your marketplace experience."
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
            <h1 class="fw-bold mb-3 gradient-text">{{ __('Cookie Policy') }}</h1>
            <p class="text-muted mb-4">{{ __('Last Updated: June 18, 2026') }}</p>
            
            <div class="lh-lg text-dark">
                <p class="lead text-muted">{{ __('This Cookie Policy explains how AdMandi uses cookies, session storage, and similar technologies to enhance your browsing experience, remember your marketplace preferences, and analyze platform traffic.') }}</p>
                
                <hr class="my-4 text-muted">

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('1. Understanding Cookies & Tracking') }}</h4>
                <p>{{ __('Cookies are small files composed of letters and numbers downloaded to your computer or mobile device when you access a web page. They act as a memory for the browser, helping websites recognize your device, maintain logins, remember filters, and deliver personalized layouts.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('2. Classification of Cookies We Use') }}</h4>
                <p>{{ __('AdMandi operates using four categories of cookies:') }}</p>
                <ul>
                    <li><strong>{{ __('Essential / Strictly Necessary Cookies:') }}</strong> {{ __('These are required for basic platform functions. They authenticate users, enable secure login sessions, defend against cross-site request forgery attacks (CSRF protection), and allow items to load correctly in chats and listings.') }}</li>
                    <li><strong>{{ __('Functionality & Preferences Cookies:') }}</strong> {{ __('These cookies save your chosen settings. For example, they store your preferred interface language (English, Hindi, or Punjabi) and your selected marketplace location context.') }}</li>
                    <li><strong>{{ __('Analytical & Performance Cookies:') }}</strong> {{ __('These track aggregate visitor counts, analyze which categories are visited most frequently, and log slow-loading pages. This lets us refine the platform structure and make pages load faster.') }}</li>
                    <li><strong>{{ __('Advertising & Target Cookies:') }}</strong> {{ __('We may work with promotional networks to show relevant ads suited to your interests. These track page clicks to prevent showing duplicate advertisements.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('3. Key Cookie Fields Utilized by AdMandi') }}</h4>
                <p>{{ __('Here are the primary first-party cookies and session parameters we store:') }}</p>
                <div class="table-responsive my-3">
                    <table class="table table-bordered align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>{{ __('Cookie Name / Key') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Purpose & Duration') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>laravel_session</code></td>
                                <td>{{ __('Strictly Necessary') }}</td>
                                <td>{{ __('Maintains secure user state, active authentication, and in-app chat session. (Expires: Session)') }}</td>
                            </tr>
                            <tr>
                                <td><code>XSRF-TOKEN</code></td>
                                <td>{{ __('Strictly Necessary') }}</td>
                                <td>{{ __('Prevents cross-site request forgery security exploits. (Expires: Session)') }}</td>
                            </tr>
                            <tr>
                                <td><code>location_id</code></td>
                                <td>{{ __('Preference') }}</td>
                                <td>{{ __('Stores your selected city/state ID context so listings match your preferred region. (Expires: 30 days)') }}</td>
                            </tr>
                            <tr>
                                <td><code>user_lat</code> / <code>user_lng</code></td>
                                <td>{{ __('Preference') }}</td>
                                <td>{{ __('Caches user coordinates for browser-based distance filtering and matching nearby ads. (Expires: 30 minutes)') }}</td>
                            </tr>
                            <tr>
                                <td><code>locale</code></td>
                                <td>{{ __('Preference') }}</td>
                                <td>{{ __('Remembers your chosen language choice (en, hi, pa) across the website. (Expires: 1 year)') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('4. Integrated Third-Party Tracking') }}</h4>
                <p>{{ __('Some services on our site set cookies controlled by external companies:') }}</p>
                <ul>
                    <li><strong>{{ __('Google Analytics:') }}</strong> {{ __('Used to analyze visitor behavior. Google sets analytical cookies to generate reports on site usage.') }}</li>
                    <li><strong>{{ __('Razorpay Payment Gateway:') }}</strong> {{ __('When checkout is loaded, Razorpay may place helper cookies to run fraud prevention protocols and verify transactions.') }}</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('5. Managing Cookie Settings') }}</h4>
                <p>{{ __('You can fully configure how your device interacts with cookies. Most popular web browsers allow you to block all cookies, accept only first-party cookies, or configure prompts when cookies are saved. Please refer to your browser\'s official support guidelines (Chrome, Safari, Firefox, Edge) to modify settings. Note that disabling necessary cookies may prevent logging in, updating locations, or posting classified ads.') }}</p>

                <h4 class="fw-bold mt-4 mb-3 text-primary">{{ __('6. Inquiries and Contact') }}</h4>
                <p>{{ __('For questions regarding our use of cookies or tracking protocols, please contact our support team at:') }}</p>
                <div class="bg-light p-3 rounded-3 border">
                    <p class="mb-1"><strong>{{ __('AdMandi Data Protection Office') }}</strong></p>
                    <p class="mb-0">{{ __('Email:') }} <a href="mailto:support@admandi.co.in">support@admandi.co.in</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
