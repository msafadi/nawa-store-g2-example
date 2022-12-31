<?php

namespace App\View\Components;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CartMenu extends Component
{

    public $cart;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
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
