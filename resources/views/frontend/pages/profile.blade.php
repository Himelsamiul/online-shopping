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

            {{-- Optional: Edit Profile Button --}}
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
                <th>Order ID</th>
                <th>Products</th>
                <th>Total Amount</th>
                <th>Status</th>
                <!-- Add more columns if you want -->
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>
                    @php
                    $cartItems = json_decode($order->cart_data, true);
                    @endphp

                    @if($cartItems)
                    <ul style="list-style: none; padding: 0;">
                        @foreach($cartItems as $item)
                        <li class="d-flex align-items-center mb-2">
                            <img src="{{ url('image/product/' . $item['image']) }}" class="product-image me-2" alt="{{ $item['name'] }}">
                            <div>
                                <strong> Name: {{ $item['name'] }}</strong><br>
                                Quantity: {{ $item['quantity'] }}<br>
                                Price: {{ $item['price'] }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    No products found.
                    @endif
                </td>
                <td>{{ $order->total_amount }}</td>
                <td>
                    <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-sm btn-success">
                        Download Receipt
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <!-- Styling -->
    <style>
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</div>

@endsection