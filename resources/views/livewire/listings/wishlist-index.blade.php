<div>
    {{-- Breadcrumbs --}}
   <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Wishlist') }}</li>
            </ol>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">{{ __('My Saved Ads') }}</h2>
                <p class="text-muted mb-0">
                    @if($listings->total() > 0)
                        {{ $listings->total() === 1 ? __('You have :count item saved in your wishlist', ['count' => $listings->total()]) : __('You have :count items saved in your wishlist', ['count' => $listings->total()]) }}
                    @else
                        {{ __('Keep track of things you want to buy') }}
                    @endif
                </p>
            </div>
        </div>

        @if($listings->total() > 0 || !empty($search))
            {{-- Filter Bar --}}
            <div class="row mb-4 align-items-center g-2">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input 
                            wire:model.live.debounce.300ms="search" 
                            type="text" 
                            class="form-control border-start-0" 
                            placeholder="{{ __('Search in saved ads...') }}"
                        >
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 d-flex justify-content-md-end">
                    <div class="dropdown">
                        <button class="btn dropdown border bg-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span><b>{{ __('Sort By:') }}</b> {{ match($sort_by){
                                'latest' => __('Recently Saved'),
                                'price_low_high' => __('Price - Low to High'),
                                'price_high_low' => __('Price - High to Low'),
                                'popular' => __('Most Viewed')
                            } }}</span>
                            <i class="bi bi-chevron-down ms-1 text-sm"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-2">
                            <li wire:click="setSorting('latest')">
                                <a class="dropdown-item rounded-3 {{ $sort_by === 'latest' ? 'active' : '' }}" href="javascript:void(0)">
                                    {{ __('Recently Saved') }}
                                </a>
                            </li>
                            <li wire:click="setSorting('price_low_high')">
                                <a class="dropdown-item rounded-3 {{ $sort_by === 'price_low_high' ? 'active' : '' }}" href="javascript:void(0)">
                                    {{ __('Price - Low to High') }}
                                </a>
                            </li>
                            <li wire:click="setSorting('price_high_low')">
                                <a class="dropdown-item rounded-3 {{ $sort_by === 'price_high_low' ? 'active' : '' }}" href="javascript:void(0)">
                                    {{ __('Price - High to Low') }}
                                </a>
                            </li>
                            <li wire:click="setSorting('popular')">
                                <a class="dropdown-item rounded-3 {{ $sort_by === 'popular' ? 'active' : '' }}" href="javascript:void(0)">
                                    {{ __('Most Viewed') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Grid of saved ads --}}
            <div class="row g-2">
                @forelse($listings as $ad)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4" wire:key="wishlist-col-{{ $ad->id }}">
                        <livewire:components.ad-card 
                            :ad="$ad" 
                            :wire:key="'wishlist-ad-'.$ad->id" 
                        />
                    </div>
                @empty
                    {{-- Search returns empty --}}
                    <div class="col-12 text-center py-5">
                        <div class="py-4">
                            <i class="bi bi-search text-muted mb-3" style="font-size: 3rem; display: block;"></i>
                            <h5 class="fw-bold mb-2">{{ __('No matching saved ads found') }}</h5>
                            <p class="text-muted">{{ __('We couldn\'t find any saved ads matching ":search"', ['search' => $search]) }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $listings->links() }}
            </div>
        @else
            {{-- Wishlist is completely empty --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-body text-center py-5">
                    <div class="py-5">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light text-primary rounded-circle" style="width: 100px; height: 100px;">
                                <i class="bi bi-heart text-muted" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2">{{ __('Your wishlist is empty') }}</h4>
                        <p class="text-muted mb-4 mx-auto" style="max-width: 450px;">
                            {{ __('Save items you are interested in by clicking the heart icon on any ad, and they will show up here.') }}
                        </p>
                        <a href="{{ url('/ads') }}" class="theme-btn text-decoration-none">
                            {{ __('Explore Ads') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
