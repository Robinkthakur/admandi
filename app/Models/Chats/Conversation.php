<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Model;
use App\Models\Listings\Listing;
use App\Models\User;

class Conversation extends Model
{
    protected $fillable = [
        'listing_id',
        'buyer_id',
        'seller_id',
        'last_message_at',
        'buyer_blocked',
        'seller_blocked',
        'deleted_by_buyer',
        'deleted_by_seller',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'buyer_blocked' => 'boolean',
        'seller_blocked' => 'boolean',
        'deleted_by_buyer' => 'boolean',
        'deleted_by_seller' => 'boolean',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id')->latestOfMany();
    }
}
