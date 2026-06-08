<?php

use Livewire\Component;
use App\Models\Listings\Listing;
use App\Models\Location\Location;

new class extends Component
{
    public $listings = [];

    public $loadLimit = 12;

    public $hasMore = true;

    public function mount()
    {
        $this->getListings();
    }

    public function getListings()
    {
        $location = get_location();
        $query = Listing::where('status', 'active');
        $hasLocationFilter = false;

        if ($location) {
            if ($location->type === 'city') {
                if (!empty($location->latitude) && !empty($location->longitude)) {
                    $nearbyCityIds = Location::where('type', 'city')
                        ->where('latitude', '!=', '')
                        ->where('longitude', '!=', '')
                        ->select('id')
                        ->selectRaw(
                            '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                            [$location->latitude, $location->longitude, $location->latitude]
                        )
                        ->having('distance', '<=', 50)
                        ->pluck('id')
                        ->toArray();

                    if (!in_array($location->id, $nearbyCityIds)) {
                        $nearbyCityIds[] = $location->id;
                    }

                    $query->whereIn('city_id', $nearbyCityIds)
                          ->orderByRaw('CASE WHEN city_id = ? THEN 0 ELSE 1 END', [$location->id]);
                    $hasLocationFilter = true;
                } else {
                    $query->where('city_id', $location->id);
                    $hasLocationFilter = true;
                }
            } elseif ($location->type === 'state') {
                $query->where('state_id', $location->id);
                $hasLocationFilter = true;
            }
        }

        // Clone query to check count first
        $countQuery = clone $query;
        $totalListings = $countQuery->count();

        // If no listings in nearby location, fallback to global listings
        if ($totalListings === 0 && $hasLocationFilter) {
            $query = Listing::where('status', 'active');
            $totalListings = Listing::where('status', 'active')->count();
        }

        $this->listings = $query->latest()
            ->limit($this->loadLimit)
            ->get();

        $this->hasMore = $this->loadLimit < $totalListings;
    }

    public function loadMore()
    {
        $this->loadLimit += 12;

        $this->getListings();
    }
};
?>

<section class="ads-area section-padding-50">
    <div class="container">

        {{-- Heading --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    Recommendations For You
                </h4>
                <p class="text-muted mb-0">Discover top deals in {{ get_location()?->display_name ?? 'your area' }} and surrounding locations</p>
            </div>
        </div>

        {{-- Listings --}}
        <div class="row g-2">

            @foreach($listings as $ad)

                <div
                    class="col-lg-3 col-md-6 col-6 mb-lg-4"
                    wire:key="listing-{{ $ad->id }}"
                >

                    <livewire:components.ad-card
                        :ad="$ad"
                        :wire:key="'ad-card-'.$ad->id"
                        lazy
                    />

                </div>

            @endforeach


            {{-- Loading Skeleton Cards --}}
            <div
                class="row"
                wire:loading.flex
                wire:target="loadMore"
            >

                @for($i = 0; $i < 4; $i++)

                    <div class="col-lg-3 col-md-6 col-6 mb-4">

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                            {{-- Image Placeholder --}}
                            <div class="placeholder-glow">
                                <span
                                    class="placeholder d-block w-100"
                                    style="height:220px;">
                                </span>
                            </div>

                            <div class="card-body">

                                {{-- Price --}}
                                <div class="placeholder-glow mb-3">
                                    <span class="placeholder col-4"></span>
                                </div>

                                {{-- Title --}}
                                <div class="placeholder-glow mb-2">
                                    <span class="placeholder col-10"></span>
                                </div>

                                <div class="placeholder-glow mb-3">
                                    <span class="placeholder col-7"></span>
                                </div>

                                {{-- Footer --}}
                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="placeholder-glow w-50">
                                        <span class="placeholder col-6"></span>
                                    </div>

                                    <span
                                        class="placeholder rounded-circle"
                                        style="width:36px;height:36px;">
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                @endfor

            </div>

        </div>

        {{-- Load More --}}
        @if($hasMore)

            <div class="text-center mt-4">

                <button
                    class="theme-btn px-4"
                    wire:click="loadMore"
                    wire:loading.attr="disabled"
                >

                    {{-- Normal Text --}}
                    <span
                        wire:loading.remove
                        wire:target="loadMore"
                    >
                        Load More
                    </span>

                    {{-- Loading --}}
                    <span
                        wire:loading
                        wire:target="loadMore"
                    >

                        <span
                            class="spinner-border spinner-border-sm me-2"
                            role="status">
                        </span>

                        Loading...

                    </span>

                </button>

            </div>

        @endif

    </div>
</section>