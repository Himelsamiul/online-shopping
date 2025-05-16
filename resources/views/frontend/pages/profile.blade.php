@extends('frontend.master')

@section('content')

<style>
    /* General styles */
    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Profile card */
    .profile-card {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .profile-icon {
        font-size: 80px;
        background-color: white;
        color: #007bff;
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .profile-info h4,
    .profile-info p {
        margin-bottom: 0.5rem;
    }

    .edit-btn {
        background-color: white;
        color: #007bff;
        font-weight: bold;
        margin-top: 1rem;
        padding: 0.5rem 1.5rem;
        border-radius: 30px;
        border: none;
        transition: background 0.3s;
    }

    .edit-btn:hover {
        background: #f0f0f0;
    }

    /* Order history */
    .order-history {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
    }

    .order-history table th {
        background-color: #007bff;
        color: white;
    }

    .order-history table td,
    .order-history table th {
        vertical-align: middle;
    }
</style>

<!-- Profile Section -->
<div class="container py-5">
    <h2 class="mb-4 text-center">My Profile</h2>

    <div class="profile-card mx-auto text-center" style="max-width: 600px;">
        <div class="profile-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#007bff" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
    </svg>
</div>

        <div class="profile-info">
            <h4>Name: {{ auth()->guard('customerGuard')->user()->name }}</h4>
            <p>Email: {{ auth()->guard('customerGuard')->user()->email }}</p>
            <hr style="border-top: 1px solid rgba(255,255,255,0.4);">
            <p><strong>Phone:</strong> {{ auth()->guard('customerGuard')->user()->phoneno }}</p>
            <p><strong>Address:</strong> {{ auth()->guard('customerGuard')->user()->address }}</p>

            <a href="{{ route('profile.edit') }}" class="edit-btn">Edit Profile</a>
        </div>
    </div>
</div>

<!-- Order History Section -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Order History</h2>

    @if($orders->isEmpty())
        <p class="text-center">No orders found.</p>
    @else
    <div class="order-history">
        <table class="table table-bordered table-striped table-hover">
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
                    <td>{{ $key + 1 }}</td>
                    <td>{{ number_format($totalPrice, 2) }} BDT</td>
                    <td>{{ $order->transaction_id }}</td>
                    <td>{{ ucfirst($order->payment_method) }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('customer.order.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            View Products
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection
