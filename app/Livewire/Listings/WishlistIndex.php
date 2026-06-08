<?php

namespace App\Livewire\Listings;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Listings\Listing;

class WishlistIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sort_by = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'sort_by' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setSorting($value)
    {
        $this->sort_by = $value;
        $this->resetPage();
    }

    #[On('wishlist-updated')]
    public function refreshWishlist()
    {
        // Triggers component re-render when an item is removed from wishlist
    }

    public function render()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $query = $user->wishlistAds()
            ->where('status', 'active');

        // Apply Search Filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply Sorting
        switch ($this->sort_by) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                // Sort by the pivot table's ID to show recently saved first
                $query->orderBy('wishlists.id', 'desc');
                break;
        }

        $listings = $query->paginate(12);

        return view('livewire.listings.wishlist-index', [
            'listings' => $listings
        ]);
    }
}
