<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list()
    {
        $orders = Order::all();
        return view('backend.pages.order.list', compact('orders'));
 
    }

    public function viewOrderDetails($orderId)
{
    // Load order details, product relation, and the customer relation
    $order = Order::with('orderDetails.product', 'customer')->findOrFail($orderId);

    // Check if the customer is the same one who placed the order
    if ($order->customer_id !== auth()->guard('customerGuard')->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Pass both order and customer data to the view
    return view('frontend.pages.receipt', [
        'order' => $order,
        'customer' => $order->customer,  // Passing the customer details explicitly
    ]);
}


    

}
