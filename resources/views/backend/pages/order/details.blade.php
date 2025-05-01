@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h3>Order Details - Order #{{ $order->id }}</h3>

    <div class="mb-3">
        <strong>Customer:</strong> {{ $order->name }}<br>
        <strong>Email:</strong> {{ $order->email }}<br>
        <strong>Address:</strong> {{ $order->address }}<br>
        <strong>Payment Method:</strong> {{ $order->payment_method }}<br>
        <strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}<br>
        <strong>Total:</strong> BDT {{ number_format($order->total_amount, 2) }}
    </div>

    <h4>Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->product->name ?? 'N/A' }}</td>
                <td>BDT {{ number_format($detail->unit_price, 2) }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>BDT {{ number_format($detail->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection