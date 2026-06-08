<?php

use Livewire\Component;
use App\Models\Listings\Listing;

new class extends Component
{
    public $listings = [];

    public function mount()
    {
        $this->getRecentlyViewed();
    }

    public function getRecentlyViewed()
    {
        $ids = session()->get('recently_viewed_ads', []);
        if (empty($ids)) {
            $this->listings = collect();
            return;
        }

        $fetched = Listing::whereIn('id', $ids)
            ->where('status', 'active')
            ->with(['location', 'category'])
            ->withCount('wishlists')
            ->get()
            ->keyBy('id');

        $this->listings = collect($ids)
            ->map(fn($id) => $fetched->get($id))
            ->filter()
            ->take(4);
    }
};
?>

<div>
    @if($listings->count() > 0)
    <section class="ads-area section-padding-50 py-5 bg-light">
        <div class="container">

            {{-- Heading --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-clock-history text-primary me-2"></i> Recently Viewed Ads
                    </h4>
                    <p class="text-muted mb-0">Pick up where you left off with ads you recently looked at</p>
                </div>
            </div>

            {{-- Listings --}}
            <div class="row g-2">

                @foreach($listings as $ad)

                    <div
                        class="col-lg-3 col-md-6 col-6 mb-lg-4"
                        wire:key="recent-view-{{ $ad->id }}"
                    >

                        <livewire:components.ad-card
                            :ad="$ad"
                            :wire:key="'recent-view-card-'.$ad->id"
                        />

                    </div>

                @endforeach

            </div>

        </div>
    </section>
    @endif
</div>
