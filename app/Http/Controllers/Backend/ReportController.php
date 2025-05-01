<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'orderDetails.product'])->get();

        return view('backend.pages.report', compact('orders'));
    }
}
