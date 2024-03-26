<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        
        // Calculate total price
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart', ['cart' => $cart, 'total' => $total]);
    }

    public function addToCart(Product $product)
    {
        $cart = session()->get('cart', []);
        $itemId = $product->id;

        // Check if item already exists in cart
        if (array_key_exists($itemId, $cart)) {
            $cart[$itemId]['quantity']++;
        } else {
            $cart[$itemId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.view')->with('success', 'Item added to cart successfully.');
    }

    public function updateCart(Request $request, $itemId)
    {
        $cart = session()->get('cart', []);

        // Check if item exists in cart
        if (array_key_exists($itemId, $cart)) {
            $quantity = $request->input('quantity');
            $operation = $request->input('operation');

            // Increment or decrement quantity based on operation
            if ($operation === 'increment') {
                $cart[$itemId]['quantity']++;
            } elseif ($operation === 'decrement') {
                $cart[$itemId]['quantity']--;
                if ($cart[$itemId]['quantity'] <= 0) {
                    unset($cart[$itemId]); // Remove item if quantity becomes zero or negative
                }
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

        // Check if item exists in cart
        if (array_key_exists($itemId, $cart)) {
            unset($cart[$itemId]); // Remove item from cart
            session()->put('cart', $cart);
            return redirect()->route('cart.view')->with('success', 'Item removed from cart successfully.');
        } else {
            return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
        }
    }
    

}
