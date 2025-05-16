@extends('backend.master')

@section('content')
<div class="container">
    <h2>All Orders Report</h2>

    <!-- Date Filter Form -->
    <form method="GET" action="{{ route('report') }}" class="mb-3">
        <div class="form-row">
            <div class="col">
                <input type="date" name="start_date" class="form-control" value="{{ request()->get('start_date') }}">
            </div>
            <div class="col">
                <input type="date" name="end_date" class="form-control" value="{{ request()->get('end_date') }}">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Print Button -->
    <button onclick="window.print()" class="btn btn-primary mb-3">Print Report</button>

    <!-- Orders Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Product</th>
                <th>Total Amount</th>
                <th>Unit Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sl = 1; 
                $grandTotal = 0;
            @endphp

            @foreach ($orders as $order)
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                        <td>{{ $detail->product->name ?? 'N/A' }}</td>
                        <td>BDT.{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ number_format($detail->unit_price, 2) }}</td>
                        <td>{{ $detail->quantity }}</td>
                    </tr>
                @endforeach
                @php
                    $grandTotal += $order->total_amount;
                @endphp
            @endforeach
        </tbody>

        <!-- Grand Total Row -->
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right;"><strong>Grand Total Amount:</strong></td>
                <td colspan="3"><strong>BDT {{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        {{ $orders->links() }}
    </div>
</div>
@endsection
