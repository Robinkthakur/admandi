<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'otp_code', 'otp_expires_at', 'location_id', 'is_verified', 'featured_limit', 'verified_until', 'avatar', 'selfie', 'id_proof', 'is_suspended', 'last_active_at', 'inactive_notified_at'])]
#[Hidden(['password', 'otp_code', 'remember_token'])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *phone_verified_at
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'verified_until' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_suspended' => 'boolean',
            'last_active_at' => 'datetime',
            'inactive_notified_at' => 'datetime',
        ];
    }

    public function location(){
        return $this->belongsTo(\App\Models\Location\Location::class,'location_id');
    }

    public function wishlistAds(){
        return $this->belongsToMany(\App\Models\Listings\Listing::class, 'wishlists');
    }

    public function listings(){
        return $this->hasMany(\App\Models\Listings\Listing::class);
    }

    public function isVerified()
    {
        return $this->is_verified && (!$this->verified_until || $this->verified_until->isFuture());
    }

    public function hasPaidForVerification()
    {
        return \App\Models\Listings\VerificationPayment::where('user_id', $this->id)
            ->where('status', 'success')
            ->exists();
    }

    public function needsIdentityVerification()
    {
        return !$this->isVerified() && $this->hasPaidForVerification() && (!$this->selfie || !$this->id_proof);
    }

    public function activities(){
        return $this->morphMany(\App\Models\UserActivity::class, 'user');
    }
}


