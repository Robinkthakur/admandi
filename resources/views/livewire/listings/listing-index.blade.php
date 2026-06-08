<div>
    <div class="pt-3">
        <div class="container">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/ads/'.$location) }}">{{ ucwords($location) }}</a></li>
                @if($category?->name)
                    @if($search)
                        <li class="breadcrumb-item"><a href="{{ url('ads/'.$location.'/'.$category->slug) }}">{{ $category->name }}</a></li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    @endif
                @endif
                @if($search)
                    <li class="breadcrumb-item active" aria-current="page">Search: {{ $search }}</li>
                @endif
            </ol>
            </nav>
        </div>
    </div>

    <style>
        .category-item {
            transition: all 0.15s ease-in-out;
            padding: 10px 14px;
            border-radius: 8px;
            position: relative;
            z-index: 1;
            margin-bottom: 4px;
        }
        .category-item.all {
            background: var(--light);
        }
        .category-item.all a {
            color: var(--primary) !important;
            font-weight: 600;
        }
        .category-item:hover,
        .category-item.active {
            background: #f1efff;
        }
        .category-item:hover a,
        .category-item.active a {
            color: var(--primary) !important;
            font-weight: 600;
        }

        /* Mobile offcanvas width overrides */
        @media (max-width: 991.98px) {
            .offcanvas-lg.offcanvas-start {
                width: 320px;
            }
        }
    </style>

    <div class="container py-2">

        <div class="row">
            <div class="col-lg-3">
                <!-- Sidebar Wrapper using responsive Offcanvas -->
                <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="filterSidebar" aria-labelledby="filterSidebarLabel">
                    <div class="offcanvas-header bg-light border-bottom">
                        <h5 class="offcanvas-title fw-bold" id="filterSidebarLabel">{{ __('Filters') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-3 p-lg-0">
                        <!-- Filters Sidebar -->
                        <div class="filter-sidebar w-100">

                            <div class="custom-card p-3 mb-3">

                                <h6 class="mb-3 fw-bold">
                                    {{ __('Category') }}
                                </h6>

                                <div class="mb-3">
                                    <div class="category-item all">
                                        <a href="{{ url('/ads/'.$location) }}" class="d-flex justify-content-between align-items-center text-decoration-none">
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <b>{{ __('All Categories') }}</b>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @foreach($categories as $cat)
                                    <div class="category-item ccccc @if($category?->slug == $cat->slug) active @endif">
                                        <a href="{{ url('ads/'.$location.'/'.$cat->slug) }}" class="d-flex justify-content-between align-items-center text-decoration-none text-dark">
                                            <div class="d-flex gap-2">
                                                <div>
                                                    {{ $cat->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="custom-card mb-3 p-3">
                                <div class="mb-3">
                                    <h6 class="mb-3">{{ __('Location') }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="javascript:void(0)" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); setTimeout(() => { document.querySelector('.location-bar .dropdown button').click(); }, 300);" class="text-primary d-flex align-items-center gap-1">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>{{ get_location()?->display_name ? __(get_location()->display_name) : __('Select Location') }}</span>
                                        </a>
                                        <a href="javascript:void(0)" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); setTimeout(() => { document.querySelector('.location-bar .dropdown button').click(); }, 300);" class="text-primary small fw-bold">
                                            {{ __('Change') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-card">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('Price Range') }}
                                    </label>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input 
                                                wire:model="min_price"
                                                type="number" 
                                                class="form-control"
                                                placeholder="{{ __('Min') }}"
                                            >
                                        </div>

                                        <div class="col-6">
                                            <input 
                                                wire:model="max_price"
                                                type="number" 
                                                class="form-control"
                                                placeholder="{{ __('Max') }}"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn bg-gray" wire:click="clearFilters" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar">
                                        {{ __('Clear') }}
                                    </button>

                                    <button class="btn btn-primary" wire:click="applyPriceRange" data-bs-dismiss="offcanvas" data-bs-target="#filterSidebar">
                                        {{ __('Apply') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Listings -->
            <div class="col-lg-9">

                <div class="mb-3">
                    @if($search)
                        <h3 class="mb-1">{{ __('Search results for') }} "{{ $search }}" {{ __('in') }} {{ __($location) }}</h3>
                        <p>{{ __('Showing') }} {{ $listings->total() }} {{ $listings->total() === 1 ? __('result') : __('results') }} {{ __('matching') }} "{{ $search }}"</p>
                    @else
                        <h3 class="mb-1">{{ $category ? $category->name : __('All used products') }} {{ __('in') }} {{ __($location) }} </h3>
                        <p>{{ __('Get best deals on') }} {{ $category ? $category->name : __('all used products') }} {{ __('in') }} {{ __($location) }} </p>
                    @endif
                </div>
        
                <!-- Top Bar -->
                <div class="mb-3 d-lg-flex justify-content-between align-items-center gap-2 gap-lg-0">

                    <div class="mb-3  mb-lg-0 ">
                        <small class="text-muted">
                            {{ __('Showing') }} {{ $listings->total() }} {{ $listings->total() === 1 ? __('result') : __('results') }}
                        </small>
                    </div>

                    <div class="d-flex justify-content-between gap-2">
                        <!-- Toggle Button for Mobile Filters -->
                        <button class="btn btn-outline-secondary d-lg-none d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar" aria-controls="filterSidebar">
                            <i class="bi bi-funnel"></i>
                            <span>{{ __('Filters') }}</span>
                        </button>

                        <div class="dropdown">
                            <button class="btn dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span><b>{{ __('Sort By:') }}</b> {{ match($sort_by){
                                'latest' => __('Recently Added'),
                                'price_low_high' => __('Price - Low to High'),
                                'price_high_low' => __('Price - High to Low'),
                                'popular' => __('Most Viewed')
                            } }}</span>
                            <i class="bi bi-chevron-down text-sm"></i>
                            </button>
                            <ul class="dropdown-menu location-dropdown px-3">
                            <li wire:click="setSorting('latest')">
                                <a class="dropdown-item p-2" href="javascript:void(0)">
                                    <span>{{ __('Recently Added') }}</span>
                                </a>
                            </li>
                            
                            <li wire:click="setSorting('price_low_high')">
                                <a class="dropdown-item p-2" href="javascript:void(0)">
                                    <span>{{ __('Price - Low to High') }}</span>
                                </a>
                            </li>

                            <li wire:click="setSorting('price_high_low')">
                                <a class="dropdown-item p-2" href="javascript:void(0)">
                                    <span>{{ __('Price - High to Low') }}</span>
                                </a>
                            </li>

                             <li wire:click="setSorting('popular')">
                                <a class="dropdown-item p-2" href="javascript:void(0)">
                                    <span>{{ __('Most Viewed') }}</span>
                                </a>
                            </li>
                            
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- Listing Cards Area -->
                <div class="row mt-3">
                   @forelse($listings as $ad)
                        <div class="col-lg-4 col-md-6 mb-4 col-6 gx-2">

                            <livewire:components.ad-card
                                :ad="$ad"
                                :wire:key="'ad-'.$ad->id"
                                lazy
                            />

                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="custom-card shadow-sm rounded-4 p-2">
                                <div class="card-body py-4">
                                    <img src="{{ asset('icons/not-found-dog.png') }}" alt="No listings found" class="img-fluid mb-4 listing-empty-img" style="max-width: 250px;">
                                    <h4 class="fw-bold mb-2">{{ __('No Listings Found') }}</h4>
                                    <p class="text-muted mb-4 max-width-md mx-auto" style="max-width: 400px;">
                                        {{ __("We couldn't find any listings matching your current location or filter criteria. Try changing your search keywords or adjusting your filters.") }}
                                    </p>
                                    <button class="theme-btn-outline rounded-pill px-4 py-2" wire:click="clearFilters">
                                        {{ __('Reset Filters') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div>
                    {{ $listings->links() }}
                </div>

            </div>
        </div>

    </div>

</div>
