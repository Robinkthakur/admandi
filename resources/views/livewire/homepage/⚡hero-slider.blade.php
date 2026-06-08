<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section class="hero-section d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="content">
                    <h2 class="title">{{ __('Buy, Sell & Discover') }} <br>
                        {{ __('Amazing Deals') }} <span class="gradient-text">{{ __('Near You') }}</span></h2>
                        <p>{{ __('Find Great deals on used bikes, cars, mobile, property') }} <br>
                        {{ __('and much more in your city.') }}</p>
                        <div>
                            <a href="{{ url('post-ad') }}" class="theme-btn me-2">
                                <i class="bi bi-plus-circle-fill"></i>
                                {{ __('Post an Ad') }}
                            </a>

                            <button data-bs-toggle="modal" data-bs-target="#categoriesModal" class="theme-btn-outline">
                                <i class="bi bi-ui-checks-grid"></i>
                                {{ __('Browse Categories') }}
                            </button>
                        </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-right align-items-center">
                    <div class="nearby-deal-box d-flex justify-content-between align-items-center" onclick="window.location.href='{{ url('/ads/' . get_location()->slug) }}'">
                        <div class="icon d-flex align-items-center">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="fw-bold mb-1 text-dark">{{ __('Explore Deals in') }}</h4>
                            <h5 class="text-primary fw-bold mb-2">{{ get_location()?->display_name ? __(get_location()->display_name) : __('Punjab') }}</h5>
                            <div class="text-muted d-flex justify-content-between align-items-center">
                                <span class="small">{{ __('Click to view local ads') }}</span>
                                <i class="bi bi-arrow-right-short fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>