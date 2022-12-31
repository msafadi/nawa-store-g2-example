<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'phone_number',
        'address', 'city', 'postal_code', 'country',
        'status', 'payment_status', 'total', 'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
        ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot(['quantity', 'price']);
    }
}
