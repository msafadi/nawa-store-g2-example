<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    // Primary key is not auto increment
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'cookie_id', 'user_id', 'product_id', 'quantity',
    ];

    protected static function booted()
    {
        // Event Listener "creating"
        static::creating(function(Cart $cart) {
            $cart->id = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
