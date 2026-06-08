<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class VerificationPackage extends Model
{
    protected $fillable = [
        'identifier', 'name', 'duration_in_months', 'price', 'featured_limit', 'color', 'badge', 'popular'
    ];

    protected $casts = [
        'popular' => 'boolean',
    ];
}
