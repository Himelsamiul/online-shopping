<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default query to get all orders with relationships
        $query = Order::with(['orderDetails.product']);
        
        // Check if start_date and end_date are provided in the request
        if ($request->has('start_date') && $request->has('end_date')) {
            // Get the start and end date from the request
            $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
            
            // Filter the orders within the date range
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Execute the query and get the orders
        $orders = $query->paginate(10); // You can adjust the number 10 based on how many items you want per page

        // Return the view with the orders data
        return view('backend.pages.report', compact('orders'));
    }
}
