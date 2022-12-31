<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartController extends Controller
{

    public function index(CartRepository $cart)
    {
        //$cart = App::make(CartRepository::class);

        return view('front.cart', [
            'cart' => $cart,
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $item = $cart->add($request->post('product_id'), $request->post('quantity', 1));

        if ($request->expectsJson()) {
            return $item;
        }

        return redirect()->back()
            ->with('success', 'Product add to cart.');
    }
}
