<?php

use Livewire\Component;
use App\Models\Location\Location;
use Livewire\Attributes\On;

new class extends Component
{
    public $locations;

    public $location_search;

    public $selected_location;

    public $wishlistCount = 0;
    public $unreadNotificationsCount = 0;
    public $search = '';

    #[On('refresh-navigation')]
    public function refreshComponent()
    {
        $this->updateWishlistCount();
        $this->updateNotificationCount();
        $this->dispatch('$refresh');
    }

    #[On('wishlist-updated')]
    public function updateWishlistCount()
    {
        if (auth()->check()) {
            $this->wishlistCount = auth()->user()->wishlistAds()->count();
        } else {
            $this->wishlistCount = 0;
        }
    }

    public function updateNotificationCount()
    {
        if (auth()->check()) {
            $this->unreadNotificationsCount = auth()->user()->unreadNotifications()->count();
        } else {
            $this->unreadNotificationsCount = 0;
        }
    }

    public function mount(){
        $this->getLocations();
        $this->selected_location = get_location()?->display_name ?? 'Punjab';
        $this->updateWishlistCount();
        $this->updateNotificationCount();
        $this->search = request()->query('search', '');
    }
    
    public function updatedLocationSearch($v){
        if (empty($this->location_search)) {
            $this->getLocations();
        } else {
            $this->locations = Location::where('name', 'LIKE', '%'.$this->location_search.'%')
                ->limit(20)
                ->get();
        }
    }

    public function getLocations(){
        $this->locations = Location::where('parent_id', 29)->limit(20)->get();
    }

    public function setLocation($locationId){
        set_location($locationId);
        if(auth()->check()){
            auth()->user()->update([
                'location_id' => $locationId
            ]);
        }
        
        $location = Location::find($locationId);
        $this->selected_location = $location?->display_name;

        // Smart redirect to apply new location context
        $referer = request()->header('Referer');
        if ($referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            
            // Check if current URL is listing index route: /ads/{location}/{category?}
            if (preg_match('/^\/ads\/([^\/]+)(?:\/([^\/]+))?$/', $refererPath, $matches)) {
                $categorySlug = $matches[2] ?? null;
                $newUrl = '/ads/' . ($location?->slug ?? 'all');
                if ($categorySlug) {
                    $newUrl .= '/' . $categorySlug;
                }
                return redirect()->to($newUrl);
            }
            
            if ($refererPath === '/ads') {
                return redirect()->to('/ads/' . ($location?->slug ?? 'all'));
            }
            
            return redirect()->to($referer);
        }

        return redirect()->to('/');
    }

    public function performSearch()
    {
        $location = get_location()?->slug ?? 'all';
        return redirect()->to('/ads/' . $location . '?search=' . urlencode($this->search));
    }

    public function logout(){
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        $this->refreshComponent();
    }

    public function setLocationByCoords($lat, $lng)
    {
        $nearestCity = Location::where('type', 'city')
            ->where('latitude', '!=', '')
            ->where('longitude', '!=', '')
            ->select('id')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$lat, $lng, $lat]
            )
            ->orderBy('distance')
            ->first();

        if ($nearestCity) {
            return $this->setLocation($nearestCity->id);
        }

        return $this->setLocation(1);
    }
};
?>

<style>
    /* Responsive layout tweaks */
    @media (max-width: 991.98px) {
        body {
            margin-top: 110px !important;
            margin-bottom: 70px !important;
        }
        .app-header {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .header {
            padding: 0 !important;
        }
    }
    
    /* Mobile bottom navigation styling */
    .mobile-bottom-nav {
        box-shadow: 0 -4px 15px rgba(0,0,0,0.06) !important;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }
    .mobile-bottom-nav a {
        transition: color 0.15s ease;
    }
    .mobile-bottom-nav a:hover,
    .mobile-bottom-nav a:focus {
        color: var(--primary) !important;
    }
    .mobile-bottom-nav .bg-primary {
        transition: transform 0.2s ease, background-color 0.15s ease;
    }
    .mobile-bottom-nav .bg-primary:active {
        transform: scale(0.9);
        background-color: var(--primaryDark) !important;
    }
    
    /* Mobile search improvements */
    .mobile-search-wrapper .form-control {
        background-color: #f1f3f5 !important;
        border: 1px solid #e9ecef !important;
    }
    .mobile-search-wrapper .form-control:focus {
        background-color: #fff !important;
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(96, 71, 230, 0.15) !important;
    }
    
    /* Center search inputs icon vertically */
    .mobile-search-wrapper button {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Modern offcanvas styling */
    .offcanvas-menu-item {
        border: none !important;
        border-left: 4px solid transparent !important;
        transition: all 0.2s ease-in-out !important;
        padding-left: 20px !important;
        color: var(--dark) !important;
        background: transparent !important;
    }
    .offcanvas-menu-item:hover {
        background-color: rgba(96, 71, 230, 0.05) !important;
        color: var(--primary) !important;
        padding-left: 24px !important;
    }
    .offcanvas-menu-item.active {
        background-color: rgba(96, 71, 230, 0.08) !important;
        color: var(--primary) !important;
        font-weight: 600 !important;
        border-left-color: var(--primary) !important;
        padding-left: 24px !important;
    }
    .offcanvas-menu-item i {
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        color: var(--muted);
    }
    .offcanvas-menu-item:hover i,
    .offcanvas-menu-item.active i {
        color: var(--primary) !important;
    }
</style>
<div>
    <div class="app-header">
        @php
            $unreadMessagesCount = 0;
            if (auth()->check()) {
                $unreadMessagesCount = \App\Models\Chats\Message::whereHas('conversation', function($q) {
                    $q->where(function($query) {
                        $query->where('buyer_id', auth()->id())->where('deleted_by_buyer', false);
                    })->orWhere(function($query) {
                        $query->where('seller_id', auth()->id())->where('deleted_by_seller', false);
                    });
                })
                ->where('sender_id', '!=', auth()->id())
                ->where('is_read', false)
                ->count();
            }
        @endphp

        <!-- ========================================================================= -->
        <!-- DESKTOP HEADER (992px and up)                                             -->
        <!-- ========================================================================= -->
        <header class="header d-none d-lg-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-1">
                        <div class="logo">
                            <a href="{{ url('/') }}" class="text-dark">
                                <img src="{{ asset('logo.png') }}" alt="logo" style="width: 120px">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="search-bar">
                            <input wire:model="search" wire:keydown.enter="performSearch" placeholder="{{ __('Search for anything...') }}">
                            <button wire:click="performSearch">
                                <img src="{{ asset('assets/icons/search-dark.png') }}" style="filter: invert(1);">
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="location-bar">
                            <span class="prefix-icon">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <div class="dropdown" x-data="{ open: false }" @click.outside="open = false">
                                <button class="btn dropdown" type="button" @click="open = !open" :aria-expanded="open.toString()">
                                <span>{{ $selected_location ? substr(__($selected_location), 0, 25) : __('Select Location') }} </span>
                                <i class="bi bi-chevron-down text-sm"></i>
                                </button>
                                <div class="dropdown-menu location-dropdown" :class="{ 'show': open }" x-show="open" style="display: block; max-height: 400px;" wire:ignore.self>
                                    <div class="border-bottom pb-2" style="padding: 10px">
                                        <input wire:model.live="location_search" type="search" placeholder="{{ __('Search Location') }}" name="" class="form-control rounded-pill">
                                    </div>
                                    
                                    <div class="border-bottom pb-1">
                                        <a class="dropdown-item p-2 text-primary d-flex align-items-center gap-2" href="javascript:void(0)" @click="
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition((position) => {
                                                    const lat = position.coords.latitude;
                                                    const lng = position.coords.longitude;
                                                    const locationData = {
                                                        latitude: lat,
                                                        longitude: lng,
                                                        timestamp: Date.now()
                                                    };
                                                    localStorage.setItem('cached_user_location', JSON.stringify(locationData));
                                                    document.cookie = 'user_lat=' + lat + '; path=/; max-age=1800';
                                                    document.cookie = 'user_lng=' + lng + '; path=/; max-age=1800';
                                                    document.cookie = 'location_id=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
                                                    $wire.setLocationByCoords(lat, lng);
                                                }, (error) => {
                                                    console.error(error);
                                                    alert('Failed to get current location. Please check your browser permissions.');
                                                });
                                            } else {
                                                alert('Geolocation is not supported by your browser.');
                                            }
                                        ">
                                            <i class="bi bi-crosshair"></i>
                                            <span>{{ __('Use Current Location') }}</span>
                                        </a>
                                    </div>
                                    <div style="max-height: 300px;overflow-y:auto" wire:transition>
                                        @foreach($locations as $loc)
                                            <div class="w-100">
                                                <button type="button" class="dropdown-item p-2 text-start border-0 bg-transparent w-100 d-flex align-items-center gap-2" wire:click="setLocation({{ $loc->id }})">
                                                    <i class="bi bi-geo-alt text-muted"></i>
                                                    <span>{{ __($loc->display_name) }}</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-lg-5 d-flex justify-content-end ">
                        <div class="header-right">
                            <a href="{{ url('post-ad') }}">
                                <div class="sell-btn">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    <span>{{ __('Post an Ad') }}</span>
                                </div>
                            </a>
                            @if(auth()->check())
                            <a href="{{ url('chat') }}"  class="messages">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-chat-right-text"></i>
                                    <span>{{ __('Messages') }}</span>
                                    @if($unreadMessagesCount > 0)
                                        <span class="messages-count">
                                            <!-- {{-- {{ $unreadMessagesCount }} --}} -->
                                        </span>
                                    @endif
                                </div>
                            </a>
                            @endif
                            <a href="{{ route('wishlist') }}" class="saved">
                                <div class="d-flex  align-items-center gap-2">
                                    <i class="bi bi-heart"></i>
                                    <span>{{ __('Saved') }}</span>
                                    @if(auth()->check() && $wishlistCount > 0)
                                        <span class="messages-count">
                                            <!-- {{ $wishlistCount }} -->
                                        </span>
                                    @endif
                                </div>
                            </a>

                            @if(auth()->check())
                            <a href="#notificationOffcanvas" data-bs-toggle="offcanvas" class="notifications position-relative">
                                <i class="bi bi-bell"></i>
                                @if($unreadNotificationsCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 8px; height: 8px; margin-top: 2px;">
                                        <span class="visually-hidden">{{ __('New alerts') }}</span>
                                    </span>
                                @endif
                            </a>
                            @endif

                            <!-- Language Switcher -->
                            <div class="dropdown language-dropdown" x-data="{ open: false }" @click.outside="open = false">
                                <button class="btn p-0 d-flex align-items-center gap-1 border-0" type="button" @click="open = !open" :aria-expanded="open.toString()">
                                    <i class="bi bi-translate fs-5"></i>
                                    <span class=" small text-uppercase" style="font-size: .85rem;">{{ app()->getLocale() }}</span>
                                    <i class="bi bi-chevron-down small" style="font-size: 0.65rem;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2 mt-2" :class="{ 'show': open }" x-show="open" style="display: block; right: 0; left: auto; border-radius: 12px; min-width: 140px; border: 1px solid #eee !important;">
                                    <li>
                                        <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between {{ app()->getLocale() === 'en' ? 'bg-light text-primary fw-bold' : '' }}" href="{{ route('change-locale', 'en') }}">
                                            <span>English</span>
                                            @if(app()->getLocale() === 'en') <i class="bi bi-check-lg text-primary"></i> @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between {{ app()->getLocale() === 'hi' ? 'bg-light text-primary fw-bold' : '' }}" href="{{ route('change-locale', 'hi') }}">
                                            <span>हिन्दी</span>
                                            @if(app()->getLocale() === 'hi') <i class="bi bi-check-lg text-primary"></i> @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 px-3 d-flex align-items-center justify-content-between {{ app()->getLocale() === 'pa' ? 'bg-light text-primary fw-bold' : '' }}" href="{{ route('change-locale', 'pa') }}">
                                            <span>ਪੰਜਾਬੀ</span>
                                            @if(app()->getLocale() === 'pa') <i class="bi bi-check-lg text-primary"></i> @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown user-dropdown" x-data="{ open: false }" @click.outside="open = false">
                                @if(auth()->check())
                                <a class="btn p-0" type="button" @click="open = !open" :aria-expanded="open.toString()">
                                    <img src="{{ auth()->user()->avatar ? auth()->user()->avatar : asset('assets/icons/avatar.png') }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                </a>
                                @else
                                    <a class="btn p-0" type="button" data-bs-toggle="modal" data-bs-target="#loginModal" aria-expanded="false">
                                    <img src="{{ asset('assets/icons/avatar.png') }}">
                                </a>
                                @endif
                                <ul class="dropdown-menu dropdown-menu-end" :class="{ 'show': open }" x-show="open" style="min-width: 250px; display: block; right: 0; left: auto;">

                                @if(auth()->user() && auth()->user()->isVerified())
                                <li><a class="dropdown-item p-2 " href="{{ route('verification-status') }}" @click="open = false">
                                <div class="d-flex w-100 px-2 py-2 rounded-3 bg-success" >
                                        <i class="bi bi-patch-check-fill me-2 text-white" ></i>
                                        <div class="text-white">
                                            <span>{{ __('Verified Account') }}</span><br>
                                            <small class="text-white">
                                                {{ __('Your profile is verified') }}
                                            </small>
                                        </div>
                                </div>
                                </a></li>
                                @elseif(auth()->user() && auth()->user()->needsIdentityVerification())
                                <li><a class="dropdown-item p-2 " href="{{ route('verification-status') }}" @click="open = false">
                                <div class="d-flex w-100 px-2 py-2 rounded-3 bg-warning" >
                                        <i class="bi bi-exclamation-triangle-fill me-2 text-white" ></i>
                                        <div class="text-white">
                                            <span>{{ __('Complete Verification') }}</span><br>
                                            <small class="text-white" style="font-size: 0.75rem;">
                                                {{ __('Upload selfie & ID proof') }}
                                            </small>
                                        </div>
                                </div>
                                </a></li>
                                @else
                                <li><a class="dropdown-item p-2 " href="{{ route('get-verified') }}" @click="open = false">
                                <div class="d-flex w-100 px-2 py-2 rounded-3" style="background: var(--primary)" >
                                        <i class="bi bi-shield-check me-2 text-white" ></i>
                                        <div class="text-white">
                                            <span>{{ __('Get Verified') }}</span><br>
                                            <small class="text-white">
                                                {{ __('Build trust and sell faster') }}
                                            </small>
                                        </div>
                                </div>
                                </a></li>
                                @endif

                                <li><a class="dropdown-item p-2" href="{{ url('profile') }}" @click="open = false">
                                    <i class="bi bi-person-fill me-2 text-primary"></i>
                                    <span>{{ __('My Profile') }}</span>
                                </a></li>
                                <li><a class="dropdown-item p-2" href="{{ url('profile/my-ads') }}" @click="open = false">
                                    <i class="bi bi-box-fill me-2 text-primary"></i>
                                    <span>{{ __('My Ads') }}</span>
                                </a></li>
                                <hr class="my-1" style="border-color: #b1b1b1">
                                <li><a class="dropdown-item p-2" href="javascript:void(0)" wire:click="logout" @click="open = false">
                                    <i class="bi bi-box-arrow-right me-2 text-danger"></i>
                                    <span>{{ __('Logout') }}</span>
                                </a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========================================================================= -->
        <!-- MOBILE HEADER (Below 992px)                                               -->
        <!-- ========================================================================= -->
        <header class="header d-block d-lg-none py-1 mobile-nav">
            <div class="container-fluid">
                <!-- Top row: Logo, Location, Lang, Profile -->
                <div class="d-flex align-items-center justify-content-between py-2 px-1 mobile-navbar">
                    <!-- Mobile Logo -->
                    <div class="logo">
                        <a href="{{ url('/') }}" class="text-dark">
                            <img src="{{ asset('logo.png') }}" alt="logo" style="width: 100px">
                        </a>
                    </div>

                    <!-- Right Action Cluster -->
                    <div class="d-flex align-items-center gap-3">
                    

                        <!-- Notifications -->
                        @if(auth()->check())
                        <a href="#notificationOffcanvas" data-bs-toggle="offcanvas" class="text-dark position-relative p-1">
                            <i class="bi bi-bell text-white fs-5"></i>
                            @if($unreadNotificationsCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 7px; height: 7px; margin-top: 2px;"></span>
                            @endif
                        </a>
                        @endif

                        <a href="#mobileMenuOffCanvas" data-bs-toggle="offcanvas" class="text-dark position-relative p-1">
                            <i class="bi bi-list text-white" style="font-size:25px"></i>
                        </a>

                    </div>
                </div>

            <div>
                <!-- Location Selector -->
                <div class="location-bar border-0 p-0" x-data="{ open: false }" @click.outside="open = false">
                    <div class="dropdown">
                        <button class="btn p-0 d-flex align-items-center gap-1 border-0" type="button" @click="open = !open">
                            <i class="bi bi-geo-alt text-primary fs-5"></i>
                            <span class="small text-truncate text-white" style="max-width: 100%; font-weight: 300;">
                                {{ $selected_location ? __($selected_location) : __('Location') }}
                            </span>
                            <i class="bi bi-chevron-down text-muted" style="font-size: 0.6rem;"></i>
                        </button>
                        
                        <div class="dropdown-menu location-dropdown shadow-lg mt-2" :class="{ 'show': open }" x-show="open" style="display: block; position: absolute; left: 0; max-height: 400px; width: 280px; z-index: 1000;" wire:ignore.self>
                            <div class="border-bottom pb-2" style="padding: 10px">
                                <input wire:model.live="location_search" type="search" placeholder="{{ __('Search Location') }}" class="form-control rounded-pill form-control-sm">
                            </div>
                            <div class="border-bottom pb-1">
                                <a class="dropdown-item p-2 text-primary d-flex align-items-center gap-2 small" href="javascript:void(0)" @click="
                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition((position) => {
                                            const lat = position.coords.latitude;
                                            const lng = position.coords.longitude;
                                            const locationData = {
                                                latitude: lat,
                                                longitude: lng,
                                                timestamp: Date.now()
                                            };
                                            localStorage.setItem('cached_user_location', JSON.stringify(locationData));
                                            document.cookie = 'user_lat=' + lat + '; path=/; max-age=1800';
                                            document.cookie = 'user_lng=' + lng + '; path=/; max-age=1800';
                                            document.cookie = 'location_id=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
                                            $wire.setLocationByCoords(lat, lng);
                                        });
                                    }
                                ">
                                    <i class="bi bi-crosshair"></i>
                                    <span>{{ __('Use Current Location') }}</span>
                                </a>
                            </div>
                            <div style="max-height: 250px; overflow-y:auto" wire:transition>
                                @foreach($locations as $loc)
                                    <button type="button" class="dropdown-item p-2.5 text-start border-0 bg-transparent w-100 d-flex align-items-center gap-2 small" wire:click="setLocation({{ $loc->id }})">
                                        <i class="bi bi-geo-alt text-muted"></i>
                                        <span>{{ __($loc->display_name) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Mobile Search Row -->
                <div class="py-2 px-1">
                    <div class="mobile-search-wrapper position-relative">
                        <input wire:model="search" wire:keydown.enter="performSearch" placeholder="{{ __('Search for anything...') }}" class="form-control rounded-pill border-0 shadow-sm" style="padding: 8px 45px 8px 20px; font-size: 14px;">
                        <button wire:click="performSearch" class="btn border-0 position-absolute end-0 top-50 translate-middle-y text-primary bg-transparent" style="padding-right: 15px;">
                            <i class="bi bi-search fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        
    </div>

    <!-- ========================================================================= -->
    <!-- MOBILE BOTTOM NAVIGATION (Below 992px)                                    -->
    <!-- ========================================================================= -->
    <div class="mobile-bottom-nav d-flex d-lg-none justify-content-around align-items-center bg-white border-top position-fixed bottom-0 start-0 w-100 shadow-lg py-2" style="z-index: 1050; height: 60px;">
        <!-- Home -->
        <a href="{{ url('/') }}" class="text-center text-decoration-none flex-grow-1 {{ request()->is('/') ? 'text-primary' : 'text-muted' }}">
            <div class="d-flex flex-column align-items-center">
                <i class="bi {{ request()->is('/') ? 'bi-house-door-fill' : 'bi-house-door' }} fs-5"></i>
                <span style="font-size: 10px; font-weight: 500;">{{ __('Home') }}</span>
            </div>
        </a>
        
        <!-- Chats -->
        <a href="{{ url('chat') }}" class="text-center text-decoration-none flex-grow-1 position-relative {{ request()->is('chat*') ? 'text-primary' : 'text-muted' }}">
            <div class="d-flex flex-column align-items-center">
                <i class="bi {{ request()->is('chat*') ? 'bi-chat-right-text-fill' : 'bi-chat-right-text' }} fs-5"></i>
                <span style="font-size: 10px; font-weight: 500;">{{ __('Chats') }}</span>
                @if(auth()->check() && $unreadMessagesCount > 0)
                    <span class="position-absolute badge rounded-pill bg-danger" style="font-size: 8px; top: -5px; right: 20%; padding: 3px 6px;">
                        {{ $unreadMessagesCount }}
                    </span>
                @endif
            </div>
        </a>
        
        <!-- Sell (Post Ad) -->
        <a href="{{ url('post-ad') }}" class="text-center text-decoration-none flex-grow-1" style="margin-top: -20px;">
            <div class="d-flex flex-column align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg border border-3 border-white" style="width: 50px; height: 50px;">
                    <i class="bi bi-plus-lg fs-4 fw-bold"></i>
                </div>
                <span style="font-size: 10px; font-weight: 500; margin-top: 2px;" class="text-primary">{{ __('Sell') }}</span>
            </div>
        </a>
        
        <!-- Saved -->
        <a href="{{ route('wishlist') }}" class="text-center text-decoration-none flex-grow-1 position-relative {{ request()->is('profile/wishlist') || request()->is('wishlist*') ? 'text-primary' : 'text-muted' }}">
            <div class="d-flex flex-column align-items-center">
                <i class="bi {{ request()->is('profile/wishlist') || request()->is('wishlist*') ? 'bi-heart-fill' : 'bi-heart' }} fs-5"></i>
                <span style="font-size: 10px; font-weight: 500;">{{ __('Saved') }}</span>
                @if(auth()->check() && $wishlistCount > 0)
                    <span class="position-absolute badge rounded-pill bg-danger" style="font-size: 8px; top: -5px; right: 20%; padding: 3px 6px;">
                        {{ $wishlistCount }}
                    </span>
                @endif
            </div>
        </a>
        
        <!-- Account -->
        <a href="{{ url('profile') }}" class="text-center text-decoration-none flex-grow-1 {{ request()->is('profile') && !request()->is('profile/my-ads') && !request()->is('profile/wishlist') ? 'text-primary' : 'text-muted' }}">
            <div class="d-flex flex-column align-items-center">
                @if(auth()->check())
                    <img src="{{ auth()->user()->avatar ? auth()->user()->avatar : asset('assets/icons/avatar.png') }}" class="rounded-circle border {{ request()->is('profile') ? 'border-primary' : 'border-secondary' }}" style="width: 20px; height: 20px; object-fit: cover;">
                @else
                    <i class="bi bi-person fs-5"></i>
                @endif
                <span style="font-size: 10px; font-weight: 500;">{{ __('Account') }}</span>
            </div>
        </a>
    </div>

    <!-- ========================================================================= -->
    <!-- MOBILE OFFCANVAS NAVIGATION (Below 992px)                                 -->
    <!-- ========================================================================= -->

    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenuOffCanvas"
    aria-labelledby="mobileMenuOffCanvasLabel"
    style="max-width:75%">

        <!-- Header -->
        <div class="offcanvas-header bg-light border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileMenuOffCanvasLabel">
                <img src="{{ asset('logo.png') }}" style="width:120px" />
            </h5>

            <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                data-bs-target="#mobileMenuOffCanvas"
                aria-label="Close">
            </button>
        </div>

        <!-- Body -->
        <div class="offcanvas-body p-0 d-flex flex-column h-100">

            <!-- User Info -->
            <div class="p-3 border-bottom d-flex align-items-center">
                @auth
                    <div class="me-3">
                        <a href="{{ url('profile') }}" data-bs-dismiss="offcanvas">
                            <img src="{{ auth()->user()->avatar ? auth()->user()->avatar : asset('assets/icons/avatar.png') }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                        </a>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark d-flex align-items-center">
                            {{ auth()->user()->name ?? __('User') }}
                            @if(auth()->user()->isVerified())
                                <i class="bi bi-patch-check-fill text-success ms-1" style="font-size: 1.1rem;" title="{{ __('Verified Account') }}"></i>
                            @endif
                        </h6>
                        <small class="text-muted d-block" style="font-size: 0.85rem;">
                            {{ auth()->user()->email }}
                        </small>
                    </div>
                @else
                    <div class="me-3">
                        <img src="{{ asset('assets/icons/avatar.png') }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">{{ __('Welcome Guest') }}</h6>
                        <small class="text-muted" style="font-size: 0.85rem;">{{ __('Login to post ads & sync details') }}</small>
                    </div>
                @endauth
            </div>

            <!-- Language Switcher -->
            <div class="p-3 border-bottom">
                <label class="fw-semibold mb-2" style="font-size: 0.9rem;">
                    {{ __('Language') }}
                </label>
                <select class="form-select" onchange="window.location.href = '{{ url('/lang') }}/' + this.value">
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                    <option value="pa" {{ app()->getLocale() === 'pa' ? 'selected' : '' }}>Punjabi</option>
                    <option value="hi" {{ app()->getLocale() === 'hi' ? 'selected' : '' }}>Hindi</option>
                </select>
            </div>

            <!-- Menu Links -->
            <div class="list-group list-group-flush" style="overflow-y: auto; flex-grow: 1;">
                <!-- General Section -->
                <div class="px-3 py-2 bg-light text-uppercase fw-bold text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    {{ __('Main Menu') }}
                </div>

                <!-- Home -->
                <a href="{{ url('/') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('/') ? 'active' : '' }}">
                    <i class="bi bi-house me-3 fs-5"></i>
                    {{ __('Home') }}
                </a>

                <!-- Browse Ads -->
                <a href="{{ url('/ads') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('ads*') ? 'active' : '' }}">
                    <i class="bi bi-compass me-3 fs-5"></i>
                    {{ __('Browse Ads') }}
                </a>

                <!-- Post an Ad -->
                <a href="{{ route('post-ad') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('post-ad*') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle me-3 fs-5"></i>
                    {{ __('Post an Ad') }}
                </a>

                @auth
                    <!-- Account & Activities Section -->
                    <div class="px-3 py-2 bg-light text-uppercase fw-bold text-muted border-top" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        {{ __('Account & Activities') }}
                    </div>

                    <!-- My Profile -->
                    <a href="{{ url('profile') }}" 
                        class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('profile') && !request()->is('profile/my-ads') && !request()->is('profile/wishlist') && !request()->is('profile/verification-status*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle me-3 fs-5"></i>
                        {{ __('My Profile') }}
                    </a>

                    <!-- My Ads -->
                    <a href="{{ url('profile/my-ads') }}" 
                        class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('profile/my-ads') ? 'active' : '' }}">
                        <i class="bi bi-grid me-3 fs-5"></i>
                        {{ __('My Ads') }}
                    </a>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist') }}" 
                        class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('wishlist*') || request()->is('profile/wishlist') ? 'active' : '' }}">
                        <i class="bi bi-heart me-3 fs-5"></i>
                        {{ __('Wishlist') }}
                        @if($wishlistCount > 0)
                            <span class="badge rounded-pill bg-danger ms-auto">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <!-- Chats -->
                    <a href="{{ route('chat') }}" 
                        class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('chat*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots me-3 fs-5"></i>
                        {{ __('Chats') }}
                        @if($unreadMessagesCount > 0)
                            <span class="badge rounded-pill bg-danger ms-auto">{{ $unreadMessagesCount }}</span>
                        @endif
                    </a>

                    <!-- Get Verified / Verified Badge / Complete Verification -->
                    @if(auth()->user()->isVerified())
                        <a href="{{ route('verification-status') }}" 
                            class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('profile/verification-status*') ? 'active' : '' }}">
                            <i class="bi bi-patch-check-fill me-3 fs-5 text-success"></i>
                            {{ __('Verification Status') }}
                        </a>
                    @elseif(auth()->user()->needsIdentityVerification())
                        <a href="{{ route('verification-status') }}" 
                            class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('profile/verification-status*') ? 'active' : '' }}">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-5 text-warning"></i>
                            <span class="text-warning fw-semibold">{{ __('Complete Verification') }}</span>
                        </a>
                    @else
                        <a href="{{ route('get-verified') }}" 
                            class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('get-verified*') ? 'active' : '' }}">
                            <i class="bi bi-shield-check me-3 fs-5"></i>
                            {{ __('Get Verified') }}
                        </a>
                    @endif
                @endauth

                <!-- Info & Support Section -->
                <div class="px-3 py-2 bg-light text-uppercase fw-bold text-muted border-top" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    {{ __('Support & Info') }}
                </div>

                <!-- Help -->
                <a href="{{ route('help-center') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('help-center*') ? 'active' : '' }}">
                    <i class="bi bi-question-circle me-3 fs-5"></i>
                    {{ __('Help & Support') }}
                </a>

                <!-- About Us -->
                <a href="{{ route('about') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('about*') ? 'active' : '' }}">
                    <i class="bi bi-info-circle me-3 fs-5"></i>
                    {{ __('About Us') }}
                </a>

                <!-- Contact Us -->
                <a href="{{ route('contact') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('contact*') ? 'active' : '' }}">
                    <i class="bi bi-envelope me-3 fs-5"></i>
                    {{ __('Contact Us') }}
                </a>

                <!-- Legal Section -->
                <div class="px-3 py-2 bg-light text-uppercase fw-bold text-muted border-top" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    {{ __('Legal') }}
                </div>

                <!-- Privacy Policy -->
                <a href="{{ route('privacy-policy') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('privacy-policy*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock me-3 fs-5"></i>
                    {{ __('Privacy Policy') }}
                </a>

                <!-- Terms & Conditions -->
                <a href="{{ route('terms-conditions') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('terms-conditions*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text me-3 fs-5"></i>
                    {{ __('Terms & Conditions') }}
                </a>

                <!-- Refund Policy -->
                <a href="{{ route('refund-policy') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('refund-policy*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right me-3 fs-5"></i>
                    {{ __('Refund Policy') }}
                </a>

                <!-- Cookie Policy -->
                <a href="{{ route('cookie-policy') }}" 
                    class="list-group-item list-group-item-action d-flex align-items-center py-3 offcanvas-menu-item {{ request()->is('cookie-policy*') ? 'active' : '' }}">
                    <i class="bi bi-cookie me-3 fs-5"></i>
                    {{ __('Cookie Policy') }}
                </a>
            </div>

            <!-- Actions -->
            <div class="p-3 border-top mt-auto">
                @auth
                    <button wire:click="logout" 
                        class="btn btn-danger w-100 rounded-pill py-2">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        {{ __('Logout') }}
                    </button>
                @else
                    <a href="{{ route('login') }}" 
                        class="btn btn-primary w-100 rounded-pill py-2">
                        {{ __('Login / Register') }}
                    </a>
                @endauth
            </div>

        </div>
    </div>


</div>