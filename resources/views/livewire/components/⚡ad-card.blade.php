<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $ad;
    public $isWishlisted = false;

    public function mount($ad){
        $this->ad = $ad;
        $this->checkWishlistStatus();
    }

    #[On('wishlist-updated')]
    public function checkWishlistStatus()
    {
        if (auth()->check()) {
            $this->isWishlisted = auth()->user()
                ->wishlistAds()
                ->where('listing_id', $this->ad->id)
                ->exists();
        } else {
            $this->isWishlisted = false;
        }
    }

    public function toggleWishList()
    {
        if (!auth()->check()) {
            $this->dispatch('open-login-modal');
            return;
        }

        $user = auth()->user();

        if ($user->wishlistAds()->where('listing_id', $this->ad->id)->exists()) {
            $user->wishlistAds()->detach($this->ad->id);
            $this->isWishlisted = false;
            $this->dispatch('wishlist-updated');
            session()->flash('success', __('Removed from wishlist.'));
        } else {
            $user->wishlistAds()->attach($this->ad->id);
            $this->isWishlisted = true;

            // Notify the seller
            $seller = $this->ad->user;
            if ($seller && $seller->id !== $user->id) {
                $seller->notify(new \App\Notifications\AdSaved($this->ad->title, $this->ad->slug));
            }

            $this->dispatch('wishlist-updated');
            session()->flash('success', __('Added to wishlist.'));
        }
    }
};
?>


@placeholder
<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="width:100% !important">
    <style>
    .placeholder{
        animation: placeholder-glow 1.5s ease-in-out infinite;
    }
    </style>
    {{-- Image Placeholder --}}
    <div class="placeholder-glow">
        <div
            class="placeholder w-100"
            style="height:220px;">
        </div>
    </div>

    <div class="card-body">

        {{-- Price --}}
        <div class="placeholder-glow mb-3">
            <span class="placeholder col-4 rounded"></span>
        </div>

        {{-- Title --}}
        <div class="placeholder-glow mb-2">
            <span class="placeholder col-10 rounded"></span>
        </div>


    </div>
</div>
@endplaceholder

 <div class="ad-card {{ $ad->user?->isVerified() ? 'pro' : '' }}">
    @if($ad->user?->isVerified())
    <div class="verified">
        <i class="bi bi-shield-check"></i>
        <span>{{ __('Verified Seller') }}</span>
    </div>
    @endif
    <div class="image">
        <a href="{{ url($ad->slug) }}">
            @if($ad->getFirstMediaUrl('*','thumb'))
            <img src="{{ $ad->getFirstMediaUrl('*','thumb')}}"  style="object-fit: cover;object-position:center">
            @else
                <img src="{{ asset('images/no-product.webp') }}"  style="object-fit: cover;object-position:center">
            @endif
        </a>
        <span class="wishlist-icon" wire:click.stop="toggleWishList">
            @if($isWishlisted)
                <i class="bi bi-heart-fill text-danger"></i>
            @else
                <i class="bi bi-heart"></i>
            @endif
        </span>
        @if($ad->is_featured)
        <span class="featured">
            {{ __('Featured') }}
        </span>
        @endif
    </div>
    <div class="content">
        <a href="{{ url($ad->slug) }}">
        <h3 class="price">
            {{ price($ad->price) }}
        </h3>
        <p class="title">{{ substr($ad->title, 0, 100) }}</p>
        <div class="d-block d-lg-flex align-items-center gap-2 text-muted mb-0 location-time">
            <p class="location mb-0 text-truncate" style="max-width: 150px;">{{ substr($ad->location?->display_name ?? 'Unknown', 0, 25) }}</p>
            <span class="mb-0 d-none d-lg-block">•</span>
            <p class="time mb-0">{{ $ad->created_at?->diffForHumans() }}</p>
        </div>
        </a>
    </div>
</div>