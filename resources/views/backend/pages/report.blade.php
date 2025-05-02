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
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                        <td>{{ $detail->product->name ?? 'N/A' }}</td>
                        <td>{{ number_format($detail->unit_price, 2) }}</td>
                        <td>{{ $detail->quantity }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
