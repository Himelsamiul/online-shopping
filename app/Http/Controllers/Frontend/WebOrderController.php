<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class WebOrderController extends Controller
{
    public function addToCart($productId)
    {
        $cart = session()->get('cart', []);
    
        // Check if the product is already in the cart
        if (isset($cart[$productId])) {
            return redirect()->back()->with('error', 'This product is already in the cart!');
        }
    
        // If the product is not in the cart, add it
        $product = Product::findOrFail($productId);
        $cart[$productId] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image
        ];
    
        // Save the updated cart to the session
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    

    public function viewCart()
    {
        return view('frontend.pages.addToCart');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = $request->input('quantity');
            $cart[$id]['quantity'] = max(1, (int) $quantity); // Prevent zero or negative
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('webpage')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('frontend.pages.checkout', compact('cart', 'total'));
    }


    public function checkoutSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);

        $cart = session('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $customer = auth()->guard('customerGuard')->user();
        Order::create([
            'customer_id' => $customer->id, 
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'total_amount' => $total,
            'cart_data' => json_encode($cart), 
        ]);

        session()->forget('cart');

        return redirect()->route('frontend.checkout')->with('success', 'Order placed successfully!');
    }
}
