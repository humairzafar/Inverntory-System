<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Order;
use Illuminate\Support\Facades\Session as LaravelSession;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceGenerated;

class StripeController extends Controller
{
    public function start()
    {
        $orderData = LaravelSession::get('latest_order');
        $cart = LaravelSession::get('cart');

        if (!$orderData || !$cart) {
            return redirect()->route('home')->with('error', 'Session expired. Please try again.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount'  => $item['amount'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $order = Order::create([
            'name'           => $orderData['name'],
            'email'          => $orderData['email'],
            'phone'          => $orderData['phone'],
            'address'        => $orderData['address'],
            'payment_method' => 'stripe',
            'total'          => collect($cart)->sum(fn($item) => $item['amount'] * $item['quantity']),
            'status'         => 'pending',
        ]);

        $checkoutSession = StripeSession::create([
            'line_items'           => $lineItems,
            'payment_method_types' => ['card'],
            'mode'                 => 'payment',
            'success_url'          => route('stripe.success', ['order_id' => $order->id]),
            'cancel_url'           => route('checkout'),
            'customer_email'       => $orderData['email'],
        ]);

        $order->stripe_session_id = $checkoutSession->id;
        $order->save();

        return redirect($checkoutSession->url);
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadView('payment.invoice', compact('order'));
        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

    public function success(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = StripeSession::retrieve($order->stripe_session_id);

        if ($session->payment_status === 'paid') {
            $order->status = 'paid';
            $order->transaction_id = $session->payment_intent;
            $order->paid_at = Carbon::now();
            $order->save();

         
            $pdf = PDF::loadView('payment.invoice', compact('order'));

            
            Mail::to($order->email)->send(new InvoiceGenerated($order, $pdf->output()));

            
            try {
                $apiKey = env('CALLMEBOT_API_KEY'); // e.g. 123456abcd
                $phone  = $order->phone; // Format: 92xxxxxxxxxx

                $message = urlencode("Thank you {$order->name}, your payment for Order #{$order->id} was successful. Total: \${$order->total}");

                file_get_contents("https://api.callmebot.com/whatsapp.php?phone={$phone}&text={$message}&apikey={$apiKey}");
            } catch (\Exception $e) {
                // You can log error here
            }

           
            LaravelSession::forget('cart');
            LaravelSession::forget('latest_order');

            return view('payment.success', compact('order'));
        }

        return redirect()->route('checkout')->with('error', 'Payment failed or was cancelled.');
    }
}
