<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category\Category;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
