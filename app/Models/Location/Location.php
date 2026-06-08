<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name', 'in_hn','in_pb', 'type', 'parent_id', 'slug', 'latitude', 'longitude'
    ];

    public function getNameAttribute($value)
    {
        $locale = app()->getLocale();
        if ($locale === 'hi' && !empty($this->in_hn)) {
            return $this->in_hn;
        }
        if ($locale === 'pa' && !empty($this->in_pb)) {
            return $this->in_pb;
        }
        return $value;
    }

    public function getDisplayNameAttribute()
    {
        if ($this->type === 'country') {
            return $this->name;
        }

        if ($this->parent) {
            return $this->name . ', ' . $this->parent->name;
        }

        return $this->name;
    }

    public function parent(){
        return $this->belongsTo(Location::class,'parent_id');
    }

    public function children(){
        return $this->hasMany(Location::class,'parent_id');
    }
}
