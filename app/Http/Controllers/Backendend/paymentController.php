<?php

namespace App\Http\Controllers\Backendend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class paymentController extends Controller
{
    
public function showUnpaidCODOrders(Request $request)
{
    $validator = Validator::make($request->all(), [
        'start_date' => 'nullable|date|before_or_equal:today',
        'end_date'   => 'nullable|date|before_or_equal:today|after_or_equal:start_date',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $ordersQuery = Order::where('payment_method', 'cash_on_delivery');

    if ($request->has('start_date') && $request->start_date) {
        $ordersQuery->whereDate('created_at', '>=', $request->start_date);
    }
    
    if ($request->has('end_date') && $request->end_date) {
        $ordersQuery->whereDate('created_at', '<=', $request->end_date);
    }

    $orders = $ordersQuery->paginate(20)->appends($request->all()); // Append filters to pagination

    return view('backend.pages.payment.cod_unpaid', compact('orders'));
}




public function collectCOD(Request $request, $orderId)
    {
        $request->validate([
            'collected_amount' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($orderId);

        $collected = $request->collected_amount;

        // Update payment info
        $order->collected_amount = $collected;
        $order->payment_status = 'paid'; // mark as paid
        $order->save();

        return redirect()->route('cod.unpaid')->with('success', 'Payment collected successfully.');
    }

}


   
    