<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Listing extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'ad_id', 'user_id', 'category_id', 'subcategory_id', 'city_id', 'state_id', 'area_id', 'title', 'slug', 'description', 'price', 'old_price', 'status', 'is_featured', 'featured_until', 'custom_fields'
    ];  

    protected $casts = [
        'created_at' => 'datetime',
        'featured_until' => 'datetime',
        'custom_fields' => 'array',
    ];

    protected static function booted()
    {
        static::addGlobalScope('active_user', function ($builder) {
            if (!request()->is('console*') && !app()->runningInConsole()) {
                $builder->whereHas('user', function ($query) {
                    $query->where('is_suspended', false);
                });
            }
        });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(500)
            ->height(500)
            ->quality(70)
            ->optimize()
            ->watermark(public_path('logo.png'),
                paddingX: 30,
                paddingY: 30,
                width: 200,
            )
            ->nonQueued();

        // Medium Image
        $this->addMediaConversion('medium')
            ->format('webp')
            ->width(1200)
            ->height(1200)
            ->quality(80)
            ->optimize()
            ->watermark(public_path('logo.png'),  
                paddingX: 30,
                paddingY: 30,
                width: 200,
            )
            ->nonQueued();
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(\App\Models\Category\Category::class, 'category_id');
    }

    public function subcategory(){
        return $this->belongsTo(\App\Models\Category\Category::class, 'subcategory_id');
    }

    public function location(){
        return $this->belongsTo(\App\Models\Location\Location::class, 'city_id');
    }

    public function wishlists(){
        return $this->hasMany(\App\Models\Listings\Wishlist::class, 'listing_id');
    }

    public function reports(){
        return $this->hasMany(\App\Models\Listings\ListingReport::class, 'listing_id');
    }

    public function viewsLogs(){
        return $this->hasMany(\App\Models\Listings\ListingView::class, 'listing_id');
    }

    public function getIsFeaturedAttribute($value)
    {
        if ($value && $this->featured_until && now()->gt($this->featured_until)) {
            return false;
        }
        return (bool) $value;
    }
}
