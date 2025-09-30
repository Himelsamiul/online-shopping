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
        $discount = $total > 1000 ? $total * 0.20: 0;
        $afterDiscount = $total - $discount;
        $vat = $afterDiscount * 0.10;
        $finalTotal = $afterDiscount + $vat;
    @endphp

    {{-- Fixed notifications --}}
    <div id="fixed-notifications">
        @if($total > 1000)
            <div class="fixed-notification congrats-notification" role="alert" aria-live="polite">
                <div class="notification-content">
                    🎉 20% Discount Applied!
                </div>
                <button type="button" class="notification-close" aria-label="Close notification">&times;</button>
            </div>
        @elseif($total > 0)
            <div class="fixed-notification info-notification" role="alert" aria-live="polite">
                <div class="notification-content">
                    🛒 Spend {{ number_format(1000 - $total, 2) }} more for 20% off!
                </div>
                <button type="button" class="notification-close" aria-label="Close notification">&times;</button>
            </div>
        @endif
    </div>

    <div class="row">
        {{-- Left side: Product list --}}
        <div class="col-lg-8 col-md-12 mb-4">
            <h2>Your Shopping Cart</h2>

            @if(count($cart) > 0)
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col" style="min-width: 140px;">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $id => $item)
                            @php $subtotal = $item['price'] * $item['quantity']; @endphp
                            <tr>
                                <td><img src="{{ url('image/product/' . $item['image']) }}" width="70" alt="{{ $item['name'] }}" class="img-thumbnail"></td>
                                <td>{{ $item['name'] }}</td>
                                <td>BDT. {{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <form action="{{ route('frontend.update.cart', $id) }}" method="POST" class="d-flex align-items-center justify-content-center" id="quantity-buttons-{{ $id }}">
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
            @else
                <div class="alert alert-info">Your cart is empty.</div>
            @endif
        </div>

        {{-- Right side: Calculation summary --}}
        <div class="col-lg-4 col-md-12">
            <div class="summary-box p-4 rounded shadow-sm bg-light">
                <h4 class="mb-3">Order Summary</h4>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span><strong>BDT {{ number_format($total, 2) }}</strong></span>
                </div>

                @if($discount > 0)
                <div class="d-flex justify-content-between mb-2 text-success">
                    <span>Discount (20%):</span>
                    <span><strong>- BDT {{ number_format($discount, 2) }}</strong></span>
                </div>
                @endif

                <div class="d-flex justify-content-between mb-2 text-primary">
                    <span>VAT (10%):</span>
                    <span><strong>+ BDT {{ number_format($vat, 2) }}</strong></span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total Payable:</span>
                    <span>BDT {{ number_format($finalTotal, 2) }}</span>
                </div>

                <a href="{{ route('frontend.checkout') }}" class="btn btn-success w-100 mt-4">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>

<script>
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

        const btn = change < 0 ? btnMinus : btnPlus;
        btn.classList.add('clicked');
        setTimeout(() => btn.classList.remove('clicked'), 200);
    }

    // Notification close functionality
    document.addEventListener('DOMContentLoaded', function() {
        const closeButtons = document.querySelectorAll('.notification-close');
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notification = this.closest('.fixed-notification');
                notification.style.animation = 'fadeOutRight 0.3s forwards';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            });
        });

        // Auto-dismiss after 5 seconds
        const notifications = document.querySelectorAll('.fixed-notification');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.style.animation = 'fadeOutRight 0.3s forwards';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        });
    });
</script>

<style>
/* Layout */
.summary-box {
    background: #f9f9f9;
    border: 1px solid #ddd;
}

/* Fixed notification container */
#fixed-notifications {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 300px;
}

/* Fixed notification styles */
.fixed-notification {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 15px;
    border-radius: 6px;
    font-size: 14px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    animation: slideInRight 0.3s forwards;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* Info notification */
.info-notification {
    background-color: #2196F3;
    color: white;
}

/* Congratulations notification */
.congrats-notification {
    background-color: #4CAF50;
    color: white;
}

.notification-content {
    padding-right: 20px;
}

.notification-close {
    background: transparent;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    padding: 0 0 0 10px;
    line-height: 1;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.notification-close:hover {
    opacity: 1;
}

/* Animations */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
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

/* Table row hover effect */
table.table tbody tr:hover {
    background-color: #f7f9f7;
    transition: background-color 0.3s ease;
}

/* Responsive tweaks */
@media (max-width: 767.98px) {
    .summary-box {
        margin-top: 20px;
    }
    
    #fixed-notifications {
        top: 10px;
        right: 10px;
        max-width: calc(100% - 20px);
    }
    
    .fixed-notification {
        font-size: 13px;
        padding: 10px 12px;
    }
}
</style>
@endsection