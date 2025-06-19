<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Step 1: Validate common fields
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        // Step 2: Get cart items
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['amount'] * $item['quantity'];
        });

        // Step 3: Handle Cash on Delivery
        if ($request->payment_method === 'cod') {
            $order = new Order();
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->payment_method = 'cod';
            $order->total = $totalAmount;
            $order->payment_status = 'pending';
            $order->save();

            Session::forget('cart');

            return redirect()->route('order.success')->with('success', 'Your COD order has been placed!');
        }

        // Step 4: Handle Stripe payment
        $request->validate([
            'stripe_payment_method_id' => 'required|string',
        ]);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Stripe expects amount in cents
                'currency' => 'usd',
                'payment_method' => $request->stripe_payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            // Step 5: Handle 3D Secure (if required)
            if (
                $paymentIntent->status === 'requires_action' &&
                $paymentIntent->next_action->type === 'use_stripe_sdk'
            ) {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                ]);
            }

            // Step 6: Successful Payment
            if ($paymentIntent->status === 'succeeded') {
                $order = new Order();
                $order->name = $request->name;
                $order->email = $request->email;
                $order->phone = $request->phone;
                $order->address = $request->address;
                $order->payment_method = 'stripe';
                $order->total = $totalAmount;
                $order->payment_status = 'paid';
                $order->save();

                Session::forget('cart');

                return redirect()->route('order.success')->with('success', 'Payment successful! Your order has been placed.');
            }

            return back()->with('error', 'Payment could not be completed. Please try again.');

        } catch (Exception $e) {
            return back()->with('error', 'Stripe error: ' . $e->getMessage());
        }
    }
}
