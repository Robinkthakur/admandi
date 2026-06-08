<section class="py-4 bg-light min-vh-100">

    <div class="container-fluid px-lg-4">

        {{-- Header --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    {{ __('My Ads') }}
                </h3>

                <p class="text-muted mb-0">
                    {{ __('Manage your posted ads') }}
                </p>
            </div>

            <a href="{{ route('post-ad') }}" class="theme-btn text-decoration-none">
                <i class="bi bi-plus-lg me-2"></i>
                {{ __('Post New Ad') }}
            </a>

        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3 d-flex justify-content-between align-items-center" role="alert">
                <div>
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Filters --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <div class="row g-3 align-items-center">

                    {{-- Search --}}
                    <div class="col-lg-5">

                        <div class="position-relative">

                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                            <input
                                style="padding-left:40px !important"
                                type="text"
                                class="form-control rounded-3"
                                placeholder="{{ __('Search your ads...') }}"
                                wire:model.live.debounce.300ms="search"
                            >

                        </div>

                    </div>


                    {{-- Status Buttons --}}
                    <div class="col-lg-7">

                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">

                            <button 
                                class="btn {{ $status === 'all' ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill px-4"
                                wire:click="setStatus('all')"
                            >
                                {{ __('All') }}
                            </button>

                            <button 
                                class="btn {{ $status === 'active' ? 'btn-success text-white' : 'btn-outline-success' }} rounded-pill px-4"
                                wire:click="setStatus('active')"
                            >
                                {{ __('Active') }}
                            </button>

                            <button 
                                class="btn {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning' }} rounded-pill px-4"
                                wire:click="setStatus('pending')"
                            >
                                {{ __('Pending') }}
                            </button>

                            <button 
                                class="btn {{ $status === 'sold' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4"
                                wire:click="setStatus('sold')"
                            >
                                {{ __('Sold') }}
                            </button>

                            <button 
                                class="btn {{ $status === 'expired' ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-4"
                                wire:click="setStatus('expired')"
                            >
                                {{ __('Expired') }}
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        @if(count($selectedAdIds) > 0)
            <div class="alert alert-primary d-flex align-items-center justify-content-between rounded-4 shadow-sm mb-4 p-3 border-0" style="background-color: #f1efff !important; color: var(--primary) !important;">
                <div>
                    <i class="bi bi-info-circle-fill me-2 fs-5 text-primary"></i>
                    <span class="text-dark">{{ __('You have selected') }} <strong>{{ count($selectedAdIds) }}</strong> {{ \Illuminate\Support\Str::plural(__('ad'), count($selectedAdIds)) }} {{ __('to boost.') }}</span>
                </div>
                <div>
                    <button 
                        class="btn btn-primary rounded-pill px-4 py-2"
                        wire:click="selectBulkForBoost"
                    >
                        <i class="bi bi-lightning-fill me-1"></i> {{ __('Boost Selected Ads') }}
                    </button>
                </div>
            </div>
        @endif

        {{-- Grid --}}
        <div class="row">

            @forelse($listings as $listing)

                <div class="col-xl-3 col-lg-4 col-md-6 mb-4" wire:key="my-ad-col-{{ $listing->id }}">

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                        {{-- Image --}}
                        <div class="position-relative">

                            <a href="{{ url($listing->slug) }}">
                                @if($listing->getFirstMediaUrl('*', 'thumb'))
                                    <img
                                        src="{{ $listing->getFirstMediaUrl('*', 'thumb') }}"
                                        class="w-100"
                                        style="height:220px;object-fit:cover;"
                                    >
                                @else
                                    <img
                                        src="{{ asset('images/no-product.webp') }}"
                                        class="w-100"
                                        style="height:220px;object-fit:cover;"
                                    >
                                @endif
                            </a>

                            {{-- Checkbox or Featured Badge --}}
                            @if($listing->is_featured && $listing->featured_until && now()->lt($listing->featured_until))
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm" style="z-index: 10;">
                                    👑 {{ __('Featured') }}
                                </span>
                            @else
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="selectedAdIds" 
                                        value="{{ $listing->id }}"
                                        class="form-check-input border-2 border-primary" 
                                        style="width: 22px; height: 22px; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"
                                    >
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            @php
                                $badgeClass = match($listing->status) {
                                    'active' => 'bg-success',
                                    'pending' => 'bg-warning text-dark',
                                    'sold' => 'bg-primary',
                                    'expired' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
                                {{ __($listing->status) }}
                            </span>



                        </div>



                        {{-- Content --}}
                        <div class="card-body">

                            {{-- Price --}}
                            <h4 class="fw-bold text-primary mb-2">
                                {{ price($listing->price) }}
                            </h4>


                            {{-- Title --}}
                            <a href="{{ url($listing->slug) }}" class="text-dark">
                                <h6 class="fw-semibold mb-3 lh-base text-truncate" title="{{ $listing->title }}">
                                    {{ $listing->title }}
                                </h6>
                            </a>


                            {{-- Info --}}
                            <div class="d-flex flex-wrap gap-3 text-muted small mb-3">

                                <span>
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ $listing->location?->display_name ?? 'N/A' }}
                                </span>

                                <span>
                                    <i class="bi bi-eye me-1"></i>
                                    {{ $listing->views ?? 0 }}
                                </span>

                                <span>
                                    <i class="bi bi-heart me-1"></i>
                                    {{ $listing->wishlists_count }}
                                </span>

                            </div>


                            {{-- Footer --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">

                                <small class="text-muted">
                                    {{ __('Posted') }} {{ $listing->created_at->diffForHumans() }}
                                </small>

                                <div class="small fw-semibold {{ $listing->status === 'active' ? 'text-success' : 'text-danger' }}">
                                    <i class="bi bi-circle-fill me-1"></i>
                                    {{ __($listing->status) }}
                                </div>

                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-2 mt-3 pt-3 border-top flex-wrap">
                                @if($listing->status !== 'sold')
                                    <button 
                                        class="btn btn-sm btn-outline-primary rounded-3 py-2 px-3 text-nowrap"
                                        wire:click="markAsSold({{ $listing->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        <i class="bi bi-check-circle me-1"></i> {{ __('Sold') }}
                                    </button>
                                @endif

                                @if($listing->status !== 'sold')

                                    <button 
                                        class="btn btn-sm {{ $listing->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-3 py-2 px-3 text-nowrap"
                                        wire:click="toggleStatus({{ $listing->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        @if($listing->status === 'active')
                                            <i class="bi bi-pause-circle me-1"></i> {{ __('Pause') }}
                                        @else
                                            <i class="bi bi-play-circle me-1"></i> {{ __('Activate') }}
                                        @endif
                                    </button>

                                    @if($listing->is_featured && $listing->featured_until && now()->lt($listing->featured_until))
                                        <button class="btn btn-sm btn-warning text-dark rounded-3 py-2 px-3 text-nowrap" disabled title="{{ __('Featured ads cannot be changed') }}">
                                            <i class="bi bi-star-fill me-1"></i> {{ __('Featured') }}
                                        </button>
                                    @else
                                        <a 
                                            href="{{ url('/profile/boost-ads?ids=' . $listing->id) }}"
                                            class="btn btn-sm btn-outline-warning rounded-3 py-2 px-3 text-nowrap"
                                        >
                                            <i class="bi bi-lightning-fill me-1"></i> {{ __('Boost') }}
                                        </a>
                                    @endif

                                    <a 
                                        href="{{ route('edit-ad', $listing->id) }}" 
                                        class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-2"
                                        title="Edit Ad"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endif

                                <button 
                                    class="btn btn-sm btn-outline-danger rounded-3 px-3 py-2"
                                    wire:click="deleteAd({{ $listing->id }})"
                                    wire:confirm="{{ __('Are you sure you want to remove this ad?') }}"
                                    wire:loading.attr="disabled"
                                    title="{{ __('Remove Ad') }}"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <div class="card-body py-5">
                            <i class="bi bi-folder-x text-muted mb-3" style="font-size: 3.5rem;"></i>
                            <h4 class="fw-bold mb-2">{{ __('No ads found') }}</h4>
                            <p class="text-muted mb-4 max-width-md mx-auto" style="max-width: 400px;">
                                @if($status === 'all')
                                    {{ __("You haven't posted any ads yet. Start selling today!") }}
                                @else
                                    {{ __("You don't have any ads with status \":status\".", ['status' => __($status)]) }}
                                @endif
                            </p>
                            <a href="{{ route('post-ad') }}" class="theme-btn text-decoration-none">
                                {{ __('Post Your First Ad') }}
                            </a>
                        </div>
                    </div>
                </div>

            @endforelse

        </div>



        {{-- Pagination --}}
        <div class="mt-4">
            {{ $listings->links() }}
        </div>

    </div>

</section>