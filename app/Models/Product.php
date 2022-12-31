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

    // Many-to-Many
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, 
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartUsers()
    {
        return $this->belongsToMany(User::class, 'cart')
            ->withPivot(['id', 'cookie_id', 'quantity', 'product_id'])
            ->withTimestamps();
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
}
