<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PublicItemController extends Controller
{
    public function index()
    {
        $items = Item::with('brand', 'model')->latest()->get();
        return view('public.home', compact('items'));
    }

    public function addToCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $item = Item::findOrFail($id);
            $cart[$id] = [
                'name' => $item->name,
                'amount' => $item->amount,
                'image' => $item->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart!');
    }
    public function cart()
{
    $cart = session()->get('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['amount'] * $item['quantity'];
    }

    return view('public.cart', compact('cart', 'total'));
}
public function updateCart(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
    }

    return redirect()->route('cart')->with('success', 'Cart updated successfully!');
}
public function remove($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Item removed from cart.');
}
public function checkout()
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('home')->with('warning', 'Your cart is empty.');
    }

    return view('checkout', compact('cart'));
}

public function processCheckout(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string',
        'phone' => 'required|int',
        'address' => 'required|string',
        'payment_method' => 'required|string|in:cod,stripe',
    ]);

    // Save order to DB (next step)
    // For now, just clear the cart and show success
    session()->forget('cart');

    return redirect()->route('home')->with('success', 'Order placed successfully!');
}

}
