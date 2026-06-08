<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'message_type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
