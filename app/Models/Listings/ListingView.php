<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class ListingView extends Model
{
    protected $fillable = [
        'listing_id',
        'ip_address',
        'user_agent',
    ];

    public function listing()
    {
        return $this->belongsTo(\App\Models\Listings\Listing::class);
    }
}
