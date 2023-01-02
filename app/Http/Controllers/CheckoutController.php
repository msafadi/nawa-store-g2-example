<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function index(CartRepository $cart)
    {
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable'],
            'address' => ['required'],
            'city' => ['required'],
            'postal_code' => ['nullable'],
            'country' => ['required', 'size:2'],
        ]);

        DB::beginTransaction();
        try {
            $request->merge([
                'currency' => config('app.currency'),
                'total' => $cart->total(),
            ]);

            $order = Order::create($request->all());
            foreach ($cart->get() as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }
            DB::commit();

            // Trigger event!
            event(new OrderCreated($order));
            return 'Order created!';

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('payments', $order->id);
    }
}
