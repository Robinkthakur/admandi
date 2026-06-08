<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'listing_ids', 'amount', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature', 'status'
    ];

    protected $casts = [
        'listing_ids' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
