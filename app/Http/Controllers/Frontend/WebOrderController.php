<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebOrderController extends Controller
{
    public function addToCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $product = Product::findOrFail($productId);
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

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

        if (!isset($cart[$id])) {
            return redirect()->back()->with('error', 'Product not found in cart.');
        }

        $quantity = (int) $request->input('quantity');
        if ($quantity > 10) {
            return redirect()->back()->with('error', 'You cannot take more than 10 items per product.');
        }
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($product->quantity < $quantity) {
            return redirect()->back()->with('error', 'Only ' . $product->quantity . ' items available in stock.');
        }

        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);

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
        // 1. Validate form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:sslcommerz,cash_on_delivery',
        ]);

        // 2. Get cart from session
        $cart = session('cart', []);

        // 3. Check if cart is empty
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // 4. Check stock availability before placing the order
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product || $product->quantity < $item['quantity']) {
                return redirect()->back()->with('error', "Insufficient stock for product: {$product->name}");
            }
        }

        // 5. Calculate total amount
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // 6. Get authenticated customer
        $customer = auth()->guard('customerGuard')->user();

        // 7. Generate transaction ID and payment status
        $transactionId = date('Ym') . strtoupper(uniqid());
        $paymentStatus = $validated['payment_method'] === 'sslcommerz' ? 'paid' : 'pending';

        // 8. Create the order
        $order = Order::create([
            'customer_id' => $customer->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'total_amount' => $total,
            'cart_data' => json_encode($cart),
            'transaction_id' => $transactionId,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $paymentStatus,
        ]);

        // 9. Create order details and reduce stock
        foreach ($cart as $productId => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'productid' => $productId,
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            $product = Product::find($productId);
            $product->decrement('quantity', $item['quantity']);
        }
        // dd($order);

        Mail::to($validated['email'])->send(new OrderPlacedMail($order));
        // 10. Clear the cart session
        session()->forget('cart');

        // 11. Redirect with success message
        return redirect()->route('frontend.checkout')->with('success', 'Order placed successfully!');
    }
}
