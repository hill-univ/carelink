<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('client.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Medicine $medicine)
    {
        if ($medicine->stock < 1 || $medicine->requires_prescription) {
            return redirect()->back()->with('error', 'Medicine not available');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$medicine->id])) {
            if ($cart[$medicine->id]['quantity'] >= $medicine->stock) {
                return redirect()->back()->with('error', 'Cannot add more than available stock');
            }
            $cart[$medicine->id]['quantity']++;
        } else {
            $cart[$medicine->id] = [
                'name' => $medicine->name,
                'price' => $medicine->price,
                'image' => $medicine->image,
                'quantity' => 1,
                'stock' => $medicine->stock,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Medicine added to cart');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = $request->quantity;
            
            if ($quantity > $cart[$id]['stock']) {
                return redirect()->back()->with('error', 'Cannot exceed available stock');
            }

            if ($quantity < 1) {
                return redirect()->back()->with('error', 'Quantity must be at least 1');
            }

            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared');
    }
}