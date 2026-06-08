<?php

namespace App\Livewire\Listings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category\Category;
use App\Models\Listings\Listing;
use App\Models\Location\Location;

class ListingIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $location;
    public $location_id;
    public $categories;
    public $category;
    public $sort_by = 'latest';
    public $min_price = 0;
    public $max_price = 10000000;
    public $search = '';

    protected $queryString = [
        'sort_by' => ['except' => 'latest'],
        'min_price' => ['except' => 0],
        'max_price' => ['except' => 10000000],
        'search' => ['except' => ''],
    ];

    public function mount($location = null, $category = null)
    {
        if ($location && $location !== 'all') {
            $loc = Location::where('slug', $location)->first();
            if ($loc) {
                set_location($loc->id);
                $this->location = $loc->name;
                $this->location_id = $loc->id;
            } else {
                $loc = get_location();
                $this->location = $loc?->name;
                $this->location_id = $loc?->id;
            }
        } else {
            $loc = get_location();
            $this->location = $loc?->name;
            $this->location_id = $loc?->id;
        }

        if ($category) {
            $this->category = Category::where(
                'slug',
                $category
            )->firstOrFail();
        }

        $this->categories = Category::query()
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('order_no', 'asc')
            ->withCount([
                'listings as listings_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->get();

        if (!$this->categories->count()) {
            abort(404);
        }
    }

    public function setSorting($value)
    {
        $this->sort_by = $value;
        $this->resetPage();
    }

    
    public function applyPriceRange()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->min_price = 0;
        $this->max_price = 10000000;
        $this->resetPage();
    }

    public function render()
    {
        $query = Listing::query()
            ->where('status', 'active');

        // Category Filter
        if ($this->category) {
            $query->where('category_id', $this->category->id);
        }

        // Search Filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Location Filter (Current + Nearby)
        if ($this->location_id) {
            $loc = Location::find($this->location_id);
            if ($loc) {
                if ($loc->type === 'city') {
                    if (!empty($loc->latitude) && !empty($loc->longitude)) {
                        $nearbyCityIds = Location::where('type', 'city')
                            ->where('latitude', '!=', '')
                            ->where('longitude', '!=', '')
                            ->select('id')
                            ->selectRaw(
                                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                                [$loc->latitude, $loc->longitude, $loc->latitude]
                            )
                            ->having('distance', '<=', 100) // 100 km radius
                            ->pluck('id')
                            ->toArray();

                        if (!in_array($loc->id, $nearbyCityIds)) {
                            $nearbyCityIds[] = $loc->id;
                        }

                        $query->whereIn('city_id', $nearbyCityIds);
                    } else {
                        $query->where('city_id', $loc->id);
                    }
                } elseif ($loc->type === 'state') {
                    $query->where('state_id', $loc->id);
                } else {
                    $query->where('city_id', $loc->id);
                }
            }
        }
        
        // Price Range Filter
        $query->whereBetween('price', [
            $this->min_price,
            $this->max_price
        ]);

        // Selected location ads first
        if ($this->location_id) {
            $query->orderByRaw('CASE WHEN city_id = ? THEN 0 ELSE 1 END', [$this->location_id]);
        }

        // Sorting
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

                $query->latest();

                break;
        }

        $data['listings'] = $query->paginate(15);

        // Dynamic SEO Metadata
        $titleParts = [];
        if ($this->category) {
            $titleParts[] = $this->category->name;
        } else {
            $titleParts[] = 'Classified Ads';
        }
        
        if ($this->location) {
            $titleParts[] = 'in ' . $this->location;
        }
        
        $title = implode(' ', $titleParts) . ' | AdMandi';

        $descCategory = $this->category ? $this->category->name : 'mobiles, cars, electronics, properties, furniture, and services';
        $descLocation = $this->location ? 'in ' . $this->location : 'near you';
        $description = "Browse verified classified ads for {$descCategory} {$descLocation} on AdMandi. Find the best deals, contact sellers directly, and post your ads for free.";

        $keywords = implode(', ', array_filter([
            $this->category?->name,
            $this->location,
            'classified ads',
            'buy and sell',
            'marketplace',
            'deals',
            'AdMandi'
        ]));

        return view('livewire.listings.listing-index', $data)
            ->layout('layouts.app', [
                'title' => $title,
                'metaDescription' => $description,
                'metaKeywords' => $keywords,
                'ogType' => 'website'
            ]);
    }
}
