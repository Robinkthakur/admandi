<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class ListingReport extends Model
{
    protected $fillable = [
        'listing_id',
        'user_id',
        'ip_address',
        'reason',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function listing()
    {
        return $this->belongsTo(\App\Models\Listings\Listing::class);
    }
}
