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
        $query = Order::with('orderDetails.product');

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            // Restrict end date to today or earlier
            $endDate = Carbon::parse($request->end_date)->greaterThan(Carbon::today())
                ? Carbon::today()
                : Carbon::parse($request->end_date);

            $query->whereDate('created_at', '<=', $endDate);
        }

        $orders = $query->paginate(20);

        // Return the view with the orders data
        return view('backend.pages.report', compact('orders'));
    }
}
