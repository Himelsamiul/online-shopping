@extends('frontend.master')

@section('content')
<!-- Profile Section -->
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

<!-- Order History Section -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Order History</h2>

    @if($orders->isEmpty())
    <p class="text-center">No orders found.</p>
    @else
    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>SL</th>
                <th>Total Price (BDT)</th>
                <th>Transaction ID</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($orders as $key => $order)
            @php
                $cartItems = json_decode($order->cart_data, true);
                $totalPrice = 0;
                if($cartItems){
                    foreach($cartItems as $item){
                        $totalPrice += $item['price'] * $item['quantity'];
                    }
                }
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ number_format($totalPrice, 2) }} BDT</td>
                <td>{{ $order->transaction_id }}</td>
                <td>{{ ucfirst($order->payment_method) }}</td>
                <td>{{ ucfirst($order->payment_status) }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('customer.order.details', $order->id) }}" class="btn btn-sm btn-primary">
                        View Products
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
