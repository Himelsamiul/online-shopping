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
        $afterDiscount = $total - $discount;
        $vat = $afterDiscount * 0.10;
        $finalTotal = $afterDiscount + $vat;
    @endphp

    {{-- Floating Discount Notification with close button --}}
    <div id="discount-float" class="discount-floating-notification" role="alert" aria-live="polite">
        🎉 20% discount on orders over 1000 BDT!
        <span id="discount-close-btn" aria-label="Close discount notification" role="button" tabindex="0">&times;</span>
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
                        <td><img src="{{ url('image/product/' . $item['image']) }}" width="70" alt="{{ $item['name'] }}"></td>
                        <td>{{ $item['name'] }}</td>
                        <td>BDT. {{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('frontend.update.cart', $id) }}" method="POST" class="d-flex align-items-center" id="quantity-buttons-{{ $id }}">
                                @csrf
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] }}" id="quantity-{{ $id }}">
                                <button type="button" onclick="changeQuantity({{ $id }}, -1)" class="btn btn-sm btn-secondary btn-minus" aria-label="Decrease quantity">-</button>
                                <span class="mx-2" id="display-qty-{{ $id }}">{{ $item['quantity'] }}</span>
                                <button type="button" onclick="changeQuantity({{ $id }}, 1)" class="btn btn-sm btn-secondary btn-plus" aria-label="Increase quantity">+</button>
                                <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                            </form>
                        </td>
                        <td>BDT. {{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('frontend.remove.from.cart', $id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm" aria-label="Remove {{ $item['name'] }} from cart">Remove</button>
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
            <h5 class="text-primary">VAT (10%): <strong>+ BDT {{ number_format($vat, 2) }}</strong></h5>
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
    // Show discount notification with slide-in animation
    document.addEventListener('DOMContentLoaded', () => {
        const discountFloat = document.getElementById('discount-float');

        // Check if user dismissed before
        if(localStorage.getItem('discountDismissed') === 'true') {
            discountFloat.style.display = 'none';
            return;
        }

        // Slide in after 0.5s delay
        setTimeout(() => {
            discountFloat.classList.add('show');
        }, 500);

        // Close button handler
        const closeBtn = document.getElementById('discount-close-btn');
        closeBtn.addEventListener('click', () => {
            discountFloat.classList.remove('show');
            setTimeout(() => discountFloat.style.display = 'none', 500);
            // Save dismissal so it doesn't show again
            localStorage.setItem('discountDismissed', 'true');
        });
    });

    // Quantity change with button animation
    function changeQuantity(id, change) {
        let qtyInput = document.getElementById('quantity-' + id);
        let displayQty = document.getElementById('display-qty-' + id);
        let btnMinus = document.querySelector(`#quantity-buttons-${id} .btn-minus`);
        let btnPlus = document.querySelector(`#quantity-buttons-${id} .btn-plus`);

        let currentQty = parseInt(qtyInput.value);
        let newQty = currentQty + change;
        if (newQty < 1) return;

        qtyInput.value = newQty;
        displayQty.innerText = newQty;

        // Animate button scale on click
        const btn = change < 0 ? btnMinus : btnPlus;
        btn.classList.add('clicked');
        setTimeout(() => btn.classList.remove('clicked'), 200);
    }
</script>

<style>
/* Floating discount notification */
.discount-floating-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: linear-gradient(135deg, #4caf50, #81c784);
    color: white;
    padding: 15px 20px 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    font-weight: 600;
    font-size: 16px;
    z-index: 1050;
    opacity: 0;
    transform: translateX(120%);
    transition: transform 0.5s ease, opacity 0.5s ease;
    display: flex;
    align-items: center;
    max-width: 320px;
}

/* Show slide-in */
.discount-floating-notification.show {
    opacity: 1;
    transform: translateX(0);
}

/* Close button */
#discount-close-btn {
    margin-left: auto;
    cursor: pointer;
    font-weight: bold;
    font-size: 20px;
    line-height: 1;
    padding-left: 15px;
    color: white;
    user-select: none;
    transition: color 0.3s ease;
}
#discount-close-btn:hover {
    color: #d0f0c0;
}

/* Quantity buttons container */
form.d-flex.align-items-center {
    gap: 5px;
}

/* Quantity buttons */
form.d-flex.align-items-center button.btn-secondary {
    width: 28px;
    height: 28px;
    padding: 0;
    font-size: 18px;
    line-height: 1;
    border-radius: 4px;
    transition: background-color 0.3s ease, transform 0.1s ease;
    user-select: none;
}

/* Hover effect on buttons */
form.d-flex.align-items-center button.btn-secondary:hover {
    background-color: #3a8d3a;
    color: white;
    transform: scale(1.1);
}

/* Click animation */
button.btn-secondary.clicked {
    transform: scale(0.9);
    background-color: #2e6f2e !important;
}

/* Display quantity text */
span[id^="display-qty-"] {
    min-width: 24px;
    text-align: center;
    font-weight: 600;
    user-select: none;
    display: inline-block;
}

/* Subtotal and totals */
.text-end h5, .text-end h4 {
    transition: color 0.3s ease;
}

/* Table row hover effect */
table.table tbody tr:hover {
    background-color: #f7f9f7;
    transition: background-color 0.3s ease;
}
</style>
@endsection
