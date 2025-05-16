@extends('frontend.master')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@php
    $cart = session('cart', []);
    $total = 0;
@endphp

<div class="container mt-5">

    @foreach($cart as $id => $item)
        @php 
            $subtotal = $item['price'] * $item['quantity']; 
            $total += $subtotal; 
        @endphp
    @endforeach

    @php
        $discount = $total > 1000 ? $total * 0.20 : 0;
        $finalTotal = $total - $discount;
    @endphp

    {{-- Floating Discount Notification - ALWAYS SHOWN --}}
    <div id="discount-float" class="discount-floating-notification">
        🎉 20% discount on orders over 1000 BDT!
    </div>

    <h2>Your Shopping Cart</h2>

    @if(count($cart) > 0)

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td><img src="{{ url('image/product/' . $item['image']) }}" width="70"></td>
                        <td>{{ $item['name'] }}</td>
                        <td>BDT. {{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('frontend.update.cart', $id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] }}" id="quantity-{{ $id }}">
                                <button type="button" onclick="changeQuantity({{ $id }}, -1)" class="btn btn-sm btn-secondary">-</button>
                                <span class="mx-2" id="display-qty-{{ $id }}">{{ $item['quantity'] }}</span>
                                <button type="button" onclick="changeQuantity({{ $id }}, 1)" class="btn btn-sm btn-secondary">+</button>
                                <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                            </form>
                        </td>
                        <td>BDT. {{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('frontend.remove.from.cart', $id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-4">
            <h5>Subtotal: <strong>BDT {{ number_format($total, 2) }}</strong></h5>
            @if($discount > 0)
                <h5 class="text-success">Discount (20%): <strong>- BDT {{ number_format($discount, 2) }}</strong></h5>
            @endif
            <h4 class="fw-bold">Total Payable: <strong>BDT {{ number_format($finalTotal, 2) }}</strong></h4>

            <a href="{{ route('frontend.checkout') }}" class="btn btn-success mt-3">Proceed to Checkout</a>
        </div>

    @else
        <div class="alert alert-info">Your cart is empty.</div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    function changeQuantity(id, change) {
        let qtyInput = document.getElementById('quantity-' + id);
        let displayQty = document.getElementById('display-qty-' + id);
        let currentQty = parseInt(qtyInput.value);
        let newQty = currentQty + change;
        if (newQty < 1) return;

        qtyInput.value = newQty;
        displayQty.innerText = newQty;
    }
</script>

<style>
.discount-floating-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: linear-gradient(135deg, #4caf50, #81c784);
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    font-weight: 600;
    font-size: 16px;
    z-index: 1050;
}
</style>
@endsection
