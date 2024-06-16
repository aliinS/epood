<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, fn ($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);

        return view('cart', compact('cart', 'total'));
    }

    public function addToCart(Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, request()->input('quantity', 1));
        $itemId = $product->id;

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += $quantity;
        } else {
            $cart[$itemId] = $product->toArray();
            $cart[$itemId]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Item added to cart successfully.');
    }

    public function updateCart(Request $request, $itemId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            $quantity = $request->input('quantity');
            $operation = $request->input('operation');

            if ($operation === 'increment') {
                $cart[$itemId]['quantity']++;
            } elseif ($operation === 'decrement' && $cart[$itemId]['quantity'] > 1) {
                $cart[$itemId]['quantity']--;
            } elseif ($operation === 'remove') {
                unset($cart[$itemId]);
            }

            session()->put('cart', $cart);

            return redirect()->route('cart.view')->with('success', 'Cart updated successfully.');
        } else {
            return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
        }
    }

    public function removeFromCart($itemId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);

            return redirect()->route('cart.view')->with('success', 'Item removed from cart successfully.');
        } else {
            return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
        }
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, fn ($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);

        return view('checkout', compact('cart', 'total'));
    }
}
