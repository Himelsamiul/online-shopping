<!-- resources/views/frontend/pages/receipt.blade.php -->
@extends('frontend.master')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Pay Slip</title>
</head>
<body>
    <h1>PaySlip Details</h1>

    <h2>Customer Details</h2>
    <p><strong>Name:</strong> {{ $customer->name }}</p> <!-- Customer Name -->
    <p><strong>Phone:</strong> {{ $customer->phoneno }}</p> <!-- Customer Phone -->
    <p><strong>Address:</strong> {{ $order->address }}</p> <!-- Address from orders table -->

    <h3>Ordered Menu Items</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($order->orderDetails as $item)
            <tr>
                <td>{{ $item->product->name }}</td> <!-- Product Name -->
                <td>{{ $item->unit_price }} BDT</td> <!-- Unit Price -->
                <td>{{ $item->quantity }}</td> <!-- Quantity -->
                <td>{{ $item->subtotal }} BDT</td> <!-- Subtotal (Unit Price * Quantity) -->
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Discount: {{ $order->discount ?? 0 }} BDT</h3> <!-- Show discount if available, otherwise show 0 -->
    <h3>Total (Before Discount): {{ $order->total_amount }} BDT</h3> <!-- Show total before discount -->
    <h3>Total (After Discount): {{ $order->total_amount - ($order->discount ?? 0) }} BDT</h3> <!-- Total after discount -->
</body>
</html>
@endsection