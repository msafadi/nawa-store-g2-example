<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartController extends Controller
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query()
    {
        $user_id = Auth::id();
        $cookie_id = App::make('cart.cookie_id');

        return Cart::where('cookie_id', '=', $cookie_id)
            ->when($user_id, function($builder, $user_id) {
                $builder->where('user_id', '=', $user_id);
            });
    }
    public function index()
    {
        $cart = $this->query()->get();

        return view('front.cart', [
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $cart = $this->query()
            ->where('product_id', '=', $request->post('product_id'))
            ->first();

        if ($cart) {
            $cart->increment('quantity', $request->post('quantity', 1)); // update quantity = quantity + 2
        } else {
            $cookie_id = app('cart.cookie_id');
            $cart = Cart::create([
                'cookie_id' => $cookie_id,
                'user_id' => Auth::id(),
                'product_id' => $request->post('product_id'),
                'quantity' => $request->post('quantity', 1),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Product add to cart.');
    }
}
