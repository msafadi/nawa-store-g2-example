<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'price', 'compare_price', 'description',
        'image_path', 'status', 'reviews_count', 'reviews_avg'
    ];

    // Inverse One-to-Many
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
}
