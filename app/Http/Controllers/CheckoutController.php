<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        if ($request->payment_method === 'cod') {
            
            $order = new Order();
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->payment_method = 'cod';
            $order->total = collect($cart)->sum(function ($item) {
        return $item['amount'] * $item['quantity'];
    });

          
            $order->save();

            
            Session::forget('cart');

            return redirect()->route('order.success')->with('success', 'Your COD order has been placed!');
        } else {
            
            Session::put('latest_order', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_method' => 'stripe',
                
            ]);

            return redirect()->route('stripe.start');
        }
    }
}
