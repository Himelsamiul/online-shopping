@extends('backend.master')

@section('content')
<div class="container">
    <h2>All Orders Report</h2>

    <button onclick="window.print()" class="btn btn-primary mb-3">Print Report</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Total Amount</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ ucfirst($order->payment_method) }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                    <td>{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        @foreach ($order->orderDetails as $detail)
                            <strong>{{ $detail->product->name ?? 'N/A' }}</strong><br>
                            Unit Price: {{ number_format($detail->unit_price, 2) }}<br>
                            Qty: {{ $detail->quantity }}<br>
                            <hr>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection