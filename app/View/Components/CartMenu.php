<?php

namespace App\View\Components;

use App\Models\Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CartMenu extends Component
{

    public $cart;

    public $total;

    public $count;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user_id = Auth::id();
        $cookie_id = App::make('cart.cookie_id');

        $this->cart = Cart::with('product')
            ->where('cookie_id', '=', $cookie_id)
            ->when($user_id, function($builder, $user_id) {
                $builder->where('user_id', '=', $user_id);
            })
            ->get();

        $this->total = $this->cart->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $this->count = $this->cart->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu', [
            // 'cart' => $this->cart,
        ]);
    }
}
