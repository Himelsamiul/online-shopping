@extends('frontend.master')

@section('content')
<div class="container mt-5">
    <h2>Your Shopping Cart</h2>

    @php
    $cart = session('cart', []);
    $total = 0;
    @endphp

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
            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
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

    <div class="text-end">
        <h4>Total: BDT. {{ number_format($total, 2) }}</h4>
        <a href="{{ route('frontend.checkout') }}" class="btn btn-success">Proceed to Checkout</a>
    </div>
    @else
    <div class="alert alert-info">Your cart is empty.</div>
    @endif
</div>
@endsection

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