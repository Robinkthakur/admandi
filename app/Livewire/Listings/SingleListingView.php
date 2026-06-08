<?php

namespace App\Livewire\Listings;

use Livewire\Component;
use App\Models\Listings\Listing;
class SingleListingView extends Component
{
    public $ad;
    public $isWishlisted = false;
    public $reportReason = '';
    public $reportDescription = '';
    public $similarAds = [];

    public function mount($slug){
        if(!$slug) abort(404);

        $listing = Listing::where('slug', $slug)
            ->where('status','active')
            ->withCount('wishlists')
            ->firstOrFail();

        // Increment views count
        $listing->increment('views');

        if (config('activity.log_listing_views', true)) {
            $listing->viewsLogs()->create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        $this->ad = $listing;

        if (auth()->check()) {
        $this->isWishlisted = auth()->user()
                ->wishlistAds()
                ->where('listing_id', $this->ad->id)
                ->exists();
        }

        // Fetch similar ads in the same category, excluding current ad
        $this->similarAds = Listing::where('category_id', $this->ad->category_id)
            ->where('id', '!=', $this->ad->id)
            ->where('status', 'active')
            ->with(['location', 'category'])
            ->withCount('wishlists')
            ->latest()
            ->take(4)
            ->get();

        // Save to recently viewed ads in session
        $recentlyViewed = session()->get('recently_viewed_ads', []);
        if (($key = array_search($this->ad->id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }
        array_unshift($recentlyViewed, $this->ad->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 12);
        session()->put('recently_viewed_ads', $recentlyViewed);
    }
    public function render()
    {
        $title = $this->ad->title;
        if ($this->ad->price) {
            $title .= ' - ₹' . number_format($this->ad->price);
        }
        if ($this->ad->location?->name) {
            $title .= ' in ' . $this->ad->location->name;
        }
        $title .= ' | AdMandi';

        $rawDescription = strip_tags($this->ad->description);
        $cleanDescription = preg_replace('/\s+/', ' ', $rawDescription);
        $description = mb_strlen($cleanDescription) > 160 ? mb_substr($cleanDescription, 0, 157) . '...' : $cleanDescription;

        $keywords = implode(', ', array_filter([
            $this->ad->title,
            $this->ad->category?->name,
            $this->ad->subcategory?->name,
            $this->ad->location?->name,
            'classifieds',
            'buy',
            'sell',
            'AdMandi'
        ]));

        $ogImage = $this->ad->getFirstMediaUrl('listings', 'medium');
        if (!$ogImage) {
            $ogImage = asset('favicon.png');
        }

        return view('livewire.listings.single-listing-view')
            ->layout('layouts.app', [
                'title' => $title,
                'metaDescription' => $description,
                'metaKeywords' => $keywords,
                'ogImage' => $ogImage,
                'ogType' => 'article'
            ]);
    }

    public function toggleWishList()
    {
        if (!auth()->check()) {
            $this->dispatch('open-login-modal');
            return;
        }

        $user = auth()->user();

        // Example using belongsToMany relation
        if ($user->wishlistAds()->where('listing_id', $this->ad->id)->exists()) {

            // Remove from wishlist
            $user->wishlistAds()->detach($this->ad->id);

            $this->isWishlisted = false;

            \App\Services\ActivityLogger::log('Wishlist Removed', "Removed listing '{$this->ad->title}' (ID: {$this->ad->ad_id}) from wishlist.", $user);

            $this->dispatch('wishlist-updated');

            session()->flash('success', __('Removed from wishlist.'));

        } else {

            // Add to wishlist
            $user->wishlistAds()->attach($this->ad->id);

            $this->isWishlisted = true;

            \App\Services\ActivityLogger::log('Wishlist Added', "Added listing '{$this->ad->title}' (ID: {$this->ad->ad_id}) to wishlist.", $user);

            // Notify the seller
            $seller = $this->ad->user;
            if ($seller && $seller->id !== $user->id) {
                $seller->notify(new \App\Notifications\AdSaved($this->ad->title, $this->ad->slug));
            }

            $this->dispatch('wishlist-updated');

            session()->flash('success', __('Added to wishlist.'));
        }
    }

    public function startChat()
    {
        if (!auth()->check()) {
            $this->dispatch('open-login-modal');
            return;
        }

        if (auth()->id() === $this->ad->user_id) {
            session()->flash('error', __('You cannot chat with yourself.'));
            return;
        }

        // Find or create conversation
        $conversation = \App\Models\Chats\Conversation::where('listing_id', $this->ad->id)
            ->where('buyer_id', auth()->id())
            ->where('seller_id', $this->ad->user_id)
            ->first();

        if (!$conversation) {
            $conversation = \App\Models\Chats\Conversation::create([
                'listing_id' => $this->ad->id,
                'buyer_id' => auth()->id(),
                'seller_id' => $this->ad->user_id,
            ]);
        } else {
            // Restore chat view if previously deleted
            $conversation->update([
                'deleted_by_buyer' => false,
                'deleted_by_seller' => false,
            ]);
        }

        return redirect()->route('chat', ['c' => $conversation->id]);
    }

    public function submitReport()
    {
        $this->validate([
            'reportReason' => 'required',
            'reportDescription' => 'required|min:10',
        ]);

        $ip = request()->ip();
        $userId = auth()->id();

        // Check if this listing has already been reported by this user or IP
        $alreadyReported = \App\Models\Listings\ListingReport::where('listing_id', $this->ad->id)
            ->where(function($query) use ($userId, $ip) {
                if ($userId) {
                    $query->where('user_id', $userId)
                          ->orWhere('ip_address', $ip);
                } else {
                    $query->where('ip_address', $ip);
                }
            })
            ->exists();

        if ($alreadyReported) {
            $this->addError('reportReason', __('You have already reported this listing.'));
            return;
        }

        \App\Models\Listings\ListingReport::create([
            'listing_id' => $this->ad->id,
            'user_id' => $userId,
            'ip_address' => $ip,
            'reason' => $this->reportReason,
            'description' => $this->reportDescription,
        ]);

        \App\Services\ActivityLogger::log('Listing Reported', "Reported listing '{$this->ad->title}' (ID: {$this->ad->ad_id}). Reason: {$this->reportReason}.", $userId);

        session()->flash('report_success', __('Thank you for reporting this ad. We will review it shortly.'));
        $this->reset(['reportReason', 'reportDescription']);
        $this->dispatch('close-report-modal');
    }
}
