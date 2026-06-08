<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'listing_id', 
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    public function listing(){
        return $this->belongsTo(\App\Models\Listings\Listing::class);
    }
}
