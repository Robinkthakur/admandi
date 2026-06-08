<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserActivity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_type',
        'activity',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the owning user model (polymorphic).
     */
    public function user(): MorphTo
    {
        return $this->morphTo();
    }
}
