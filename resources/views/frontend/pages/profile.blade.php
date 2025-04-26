@extends('frontend.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">My Profile</h2>

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">

            @if(!empty(auth()->guard('customerGuard')->user()->image))
            <img src="{{ url('image/category/customer/' . auth()->guard('customerGuard')->user()->image) }}"
                alt="Profile Image"
                class="rounded-circle mb-3"
                style="width: 120px; height: 120px; object-fit: cover;">
            @else
            <img src="{{ asset('images/user.jpg') }}"
                alt="Default Image"
                class="rounded-circle mb-3"
                style="width: 120px; height: 120px; object-fit: cover;">
            @endif

            <h4>Name: {{ auth()->guard('customerGuard')->user()->name }}</h4>
            <p class="text-muted">Email: {{ auth()->guard('customerGuard')->user()->email }}</p>

            <hr>

            <div class="text-start">
                <p><strong>Phone: </strong> {{ auth()->guard('customerGuard')->user()->phoneno }}</p>
                <p><strong>Address: </strong> {{ auth()->guard('customerGuard')->user()->address }}</p>
            </div>

            <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>

        </div>
    </div>

</div>

<div class="container mt-5">
    <h2>Order History</h2>

    @if($orders->isEmpty())
    <p>No orders found.</p>
    @else
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Product Name</th>
                <th>Transaction ID</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Quantity</th>
                <th>Unit Cost (BDT)</th>
                <th>Total Cost (BDT)</th> <!-- New column -->
                <th>Action</th> <!-- New Action column -->
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            @php
            $cartItems = json_decode($order->cart_data, true);
            @endphp

            @if($cartItems)
                @foreach($cartItems as $index => $item)
                @php
                    $totalCost = $item['quantity'] * $item['price'];
                @endphp
                <tr id="orderRow{{ $order->id }}{{ $index }}">
                    <td>{{ $order->id }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $order->transaction_id }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'], 2) }} BDT</td>
                    <td>{{ number_format($totalCost, 2) }} BDT</td> <!-- Show total cost -->
                    <td>
                        <button class="btn btn-sm btn-success" onclick="printSingleOrder('orderRow{{ $order->id }}{{ $index }}')">Print</button>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="9">No products found for this order.</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<!-- Styling -->
<style>
    .product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

<!-- Print Single Row Script -->
<script>
function printSingleOrder(rowId) {
    var row = document.getElementById(rowId).outerHTML;
    var newWindow = window.open('', '', 'height=600,width=800');
    newWindow.document.write('<html><head><title>Print Order</title>');
    newWindow.document.write('</head><body>');
    newWindow.document.write('<table border="1" style="width:100%; border-collapse:collapse;">');
    newWindow.document.write('<thead><tr><th>Order Number</th><th>Product Name</th><th>Transaction ID</th><th>Payment Status</th><th>Payment Method</th><th>Quantity</th><th>Unit Cost (BDT)</th><th>Total Cost (BDT)</th></tr></thead>');
    newWindow.document.write('<tbody>');
    newWindow.document.write(row);
    newWindow.document.write('</tbody></table>');
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}
</script>

@endsection
