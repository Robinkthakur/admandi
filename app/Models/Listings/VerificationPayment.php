<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Model;

class VerificationPayment extends Model
{
    protected $fillable = [
        'user_id', 'verification_package_id', 'amount', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function package()
    {
        return $this->belongsTo(VerificationPackage::class, 'verification_package_id');
    }
}
