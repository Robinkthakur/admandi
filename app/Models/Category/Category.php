<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['parent_id', 'slug', 'name', 'in_hn', 'in_pb', 'status', 'image', 'order_no', 'custom_fields'])]
class Category extends Model
{
    protected $casts = [
        'custom_fields' => 'array',
    ];
    
    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function listings(){
        return $this->hasMany(\App\Models\listings\Listing::class, 'subcategory_id');
    }

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

}
