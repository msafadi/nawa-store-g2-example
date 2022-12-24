<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'image_path',
    ];

    // protected $guarded = [];

    protected static function booted()
    {
        // static::addGlobalScope('parent', function(Builder $query) {
        //     $query->whereNotNull('categories.parent_id');
        // });
    }

    // Local Scopes
    public function scopeParent(Builder $query)
    {
        $query->whereNotNull('categories.parent_id');
    }

    public function scopeSearch(Builder $query, $options)
    {

        $query->when($options['search'] ?? false, function($query, $value) {
            $query->where('categories.name', 'LIKE', "%{$value}%");
        });

        $query->when($options['p'] ?? false, function($query, $value) {
            $query->where('categories.parent_id', '=', $value);
        });

        // if ($options['search'] ?? false) {
        //     $query->where('categories.name', 'LIKE', "%{$options['search']}%");
        // }
        // if ($options['p'] ?? false) {
        //     $query->where('categories.parent_id', '=', $options['p']);
        // }
    }

    // Accessors Functions
    // $category->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('assets/images/default-thumbnail.jpg');
    }

    public function getNameAttribute($value)
    {
        return Str::title($value); // ucwords()
    }

    // Mutators
    // $category->name = 'Watches';
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::upper($value);
    }
}
