<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'price', 'compare_price', 'description',
        'image_path', 'status', 'reviews_count', 'reviews_avg'
    ];

    protected $appends = [
          'image_url', 'url',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'image_path',
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

    // $product->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
                return $this->image_path;
            }
            return asset('storage/' . $this->image_path);
        }
        return asset('assets/images/default-thumbnail.jpg');
    }

    public function getUrlAttribute()
    {
        return route('products.show', $this->slug);
    }
}
