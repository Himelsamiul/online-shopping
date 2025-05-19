@extends('frontend.master')

@section('content')
<style>
    /* Container box style */
    .dynamic-box {
        background: linear-gradient(145deg, #f0f4f8, #d9e2ec);
        border-radius: 12px;
        box-shadow: 6px 6px 15px #bcccdc,
                    -6px -6px 15px #ffffff;
        padding: 25px;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .dynamic-box:hover {
        box-shadow: 4px 4px 10px #a8badc,
                    -4px -4px 10px #ffffff;
        transform: translateY(-4px);
    }

    /* Payment method container */
    .payment-method-group {
        display: flex;
        gap: 25px;
        margin-top: 12px;
    }

    /* Each payment option box */
    .payment-method-option {
        position: relative;
        padding: 12px 32px 12px 50px;
        border-radius: 40px;
        cursor: pointer;
        font-weight: 600;
        color: #34495e;
        user-select: none;
        background: #e0e7ef;
        box-shadow: inset 4px 4px 6px #c1cad7,
                    inset -4px -4px 6px #ffffff;
        transition: background 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        flex: 1;
        display: flex;
        align-items: center;
        font-size: 1.1rem;
    }
    .payment-method-option:hover {
        background: #d0daf5;
        box-shadow: inset 6px 6px 8px #b0b9d6,
                    inset -6px -6px 8px #e3eaff;
        color: #1a4db7;
    }

    /* Hide default radio */
    .payment-method-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Custom dot with checkmark */
    .custom-dot {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 3px solid #3498db;
        background: #e0e7ef;
        box-shadow: 4px 4px 6px #c1cad7,
                    -4px -4px 6px #ffffff;
        transition: background-color 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Inner filled circle when checked */
    .payment-method-option input[type="radio"]:checked ~ .custom-dot {
        background: #3498db;
        border-color: #1a4db7;
        box-shadow: inset 2px 2px 4px #2570c8,
                    inset -2px -2px 4px #3da0ff;
    }

    /* Checkmark icon shown when selected */
    .payment-method-option input[type="radio"]:checked ~ .custom-dot::after {
        content: "✓";
        color: white;
        font-size: 18px;
        font-weight: bold;
        line-height: 1;
        user-select: none;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .payment-method-group {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>

<div class="container mt-5 mb-5" style="max-width: 1100px;">
    {{-- Discount message at top full width --}}
    @if($discount > 0)
    <div class="alert alert-success shadow-sm mb-4 text-center fw-semibold" role="alert" style="font-size: 1.1rem;">
        🎉 Congratulations! You’ve received a 20% discount for orders over 1000 BDT!
    </div>
    @endif

    <h2 class="mb-4 text-center fw-bold" style="color: #2c3e50;">Checkout</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('frontend.checkout.submit') }}" method="POST" id="checkoutForm" class="dynamic-box">
        @csrf

        <div class="row g-4">
            {{-- Left side: user info + payment method + place order --}}
            <div class="col-md-4 d-flex flex-column justify-content-start">
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Name *</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="{{ auth()->guard('customerGuard')->user()->name }}" readonly required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email *</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="{{ auth()->guard('customerGuard')->user()->email }}" readonly required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                    <input type="text" id="phone" name="phone" class="form-control" 
                           value="{{ auth()->guard('customerGuard')->user()->phoneno }}" readonly required>
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label fw-semibold">Address *</label>
                    <textarea id="address" name="address" class="form-control" rows="3" required>{{ old('address', auth()->guard('customerGuard')->user()->address) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Payment Method *</label>
                    <div class="payment-method-group">
                        <label class="payment-method-option" for="payment_cod">
                            <input type="radio" id="payment_cod" name="payment_method" value="cash_on_delivery" required>
                            <span class="custom-dot"></span>
                            Cash on Delivery
                        </label>
                        <label class="payment-method-option" for="payment_ssl">
                            <input type="radio" id="payment_ssl" name="payment_method" value="sslcommerz" required>
                            <span class="custom-dot"></span>
                            SSLCommerz (Online Payment)
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg fw-semibold shadow-sm mt-auto w-100" style="margin-top: auto;">
                    Place Order
                </button>
            </div>

            {{-- Middle: Order Summary Table --}}
            <div class="col-md-4 d-flex flex-column">
                <h4 class="fw-bold mb-3 text-center" style="color: #34495e;">Order Summary</h4>
                <div class="table-responsive shadow-sm rounded flex-grow-1 dynamic-box">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col" class="text-center">Qty</th>
                                <th scope="col" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td class="text-end">BDT {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right side: Payment Summary --}}
            <div class="col-md-4 d-flex flex-column align-items-center">
                <div class="dynamic-box w-100 text-center">
                    <h5 class="fw-semibold mb-3" style="color:#2c3e50;">Payment Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Original Total:</span>
                        <span><strong>BDT {{ number_format($total, 2) }}</strong></span>
                    </div>

                    @if($discount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount (20%):</span>
                        <span>- BDT {{ number_format($discount, 2) }}</span>
                    </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span><strong>Subtotal (Discount):</strong></span>
                        <span><strong>BDT {{ number_format($total - $discount, 2) }}</strong></span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>VAT (10%):</span>
                        <span>+ BDT {{ number_format($vat, 2) }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-0">
                        <h5>Total Payable:</h5>
                        <h5 style="color:#27ae60;">BDT {{ number_format($finalTotal, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="discount" value="{{ $discount }}">
        <input type="hidden" name="vat" value="{{ $vat }}">
        <input type="hidden" name="final_total" value="{{ $finalTotal }}">
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const paymentOptions = document.querySelectorAll('.payment-method-option input[type="radio"]');
        paymentOptions.forEach(radio => {
            radio.addEventListener('change', () => {
                paymentOptions.forEach(r => {
                    if (r.checked) {
                        r.parentElement.style.background = '#d0daf5';
                        r.parentElement.style.boxShadow = 'inset 6px 6px 8px #b0b9d6, inset -6px -6px 8px #e3eaff';
                        r.parentElement.style.color = '#1a4db7';
                    } else {
                        r.parentElement.style.background = '#e0e7ef';
                        r.parentElement.style.boxShadow = 'inset 4px 4px 6px #c1cad7, inset -4px -4px 6px #ffffff';
                        r.parentElement.style.color = '#34495e';
                    }
                });
            });
        });
    });
</script>
@endsection
