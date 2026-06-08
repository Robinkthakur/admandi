<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'duration_in_days', 'price', 'description'
    ];
}
