<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Throwable;

class PaymentsController extends Controller
{
    public function create($order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->payment_status == 'paid') {
            return 'Order alreay paid';
        }

        $client = app()->make('paypal.client');
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->id,
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => $order->currency,
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('payments.cancel', $order->id),
                "return_url" => route('payments.return', $order->id),
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            if ($response->statusCode == 201) {
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);
        } catch (Throwable $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }
    }

    public function store(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        //return $request->all();

        $client = app('paypal.client');

        $capRequest = new OrdersCaptureRequest($request->token);
        $capRequest->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($capRequest);
            if ($response->statusCode == 201 && $response->result->status == 'COMPLETED') {
                $order->update([
                    'payment_status' => 'paid',
                ]);
            }

            return 'Thank you!';
            
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);

        }catch (Throwable $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }

    }

    public function cancel($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order->update([
            'payment_status' => 'failed',
        ]);

        return 'Payment Cancelled!';
    }
}
