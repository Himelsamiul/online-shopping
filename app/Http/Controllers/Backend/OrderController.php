<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function list()
{
    $orders = Order::orderBy('created_at', 'desc')->paginate(10); // ✅ Show latest first
    $totalOrderAmount = Order::sum('total_amount');

    return view('backend.pages.order.list', compact('orders', 'totalOrderAmount'));
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

    public function details($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id); // eager load product if needed
        return view('backend.pages.order.details', compact('order'));
    }
    
}
