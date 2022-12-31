<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CartRepository
{

    protected $cookie_id;
    protected $user_id;

    public function __construct($cookie_id, $user_id = null)
    {
        $this->cookie_id = $cookie_id;
        $this->user_id = $user_id;    
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query()
    {

        return Cart::with('product')
            ->where('cookie_id', '=', $this->cookie_id)
            ->when($this->user_id, function($builder, $user_id) {
                $builder->where('user_id', '=', $user_id);
            });
    }
    
    public function get()
    {
        return $this->query()->get();
    }

    public function add($id, $qty = 1)
    {
        $cart = $this->query()
            ->where('product_id', '=', $id)
            ->first();

        if ($cart) {
            return $cart->increment('quantity', $qty); // update quantity = quantity + 2
        }

        $cookie_id = app('cart.cookie_id');
        return Cart::create([
                'cookie_id' => $this->cookie_id,
                'user_id' => $this->user_id,
                'product_id' => $id,
                'quantity' => $qty,
            ]);
    }

    public function total()
    {
        return $this->get()->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function count()
    {
        return $this->get()->count();
    }
}