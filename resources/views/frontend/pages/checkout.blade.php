@extends('frontend.master')

@section('content')
<style>
    .checkout-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-bottom: 20px;
    }

    .checkout-title {
        font-weight: bold;
        color: #343a40;
        margin-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 10px;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold text-primary">Checkout Page</h2>

    <div class="row g-4">
        {{-- Left Column: Customer Info & Payment --}}
        <div class="col-md-4">
            <div class="checkout-card">
                <h5 class="checkout-title">Customer Info</h5>
                <form action="{{ route('frontend.checkout.submit') }}" method="POST" id="checkoutForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"
                            value="{{ auth()->guard('customerGuard')->user()->name }}" readonly required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ auth()->guard('customerGuard')->user()->email }}" readonly required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone"
                            value="{{ auth()->guard('customerGuard')->user()->phoneno }}" readonly required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" required>{{ old('address', auth()->guard('customerGuard')->user()->address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cash_on_delivery"
                                {{ old('payment_method') === 'cash_on_delivery' || !old('payment_method') ? 'checked' : '' }}>
                            <label class="form-check-label" for="cod">
                                Cash on Delivery
                            </label>
                        </div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="sslcommerz" value="sslcommerz"
                                {{ old('payment_method') === 'sslcommerz' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sslcommerz">
                                SSLCommerz (Online Payment)
                            </label>
                        </div>
                    </div>

            </div>
        </div>

        {{-- Middle Column: Product Details --}}
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4 bg-white rounded border-0">
                <h5 class="border-bottom pb-2 mb-3 text-primary">🛒 Your Items</h5>

                @foreach($cart as $item)
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <strong>{{ $item['name'] }}</strong><br>
                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                    </div>
                    <div class="text-end text-dark fw-semibold">
                        BDT {{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
                @if(!$loop->last)
                <hr class="my-2">
                @endif
                @endforeach
            </div>
        </div>


        {{-- Right Column: Order Summary --}}
        <div class="col-md-4">
            <div class="checkout-card">
                <h5 class="checkout-title">Order Summary</h5>

                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <strong>BDT. {{ number_format($total, 2) }}</strong>
                    </li>

                    @if($discount > 0)
                    <li class="list-group-item d-flex justify-content-between text-success">
                        <span>Discount (20%)</span>
                        <strong>- BDT. {{ number_format($discount, 2) }}</strong>
                    </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between text-primary">
                        <span>VAT (10%)</span>
                        <strong>+ BDT. {{ number_format($vat, 2) }}</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between fw-bold text-danger">
                        <span>Total Payable:</span>
                        <span>BDT. {{ number_format($finalTotal, 2) }}</span>
                    </li>
                </ul>

                @if($discount > 0)
                <div class="alert alert-success small">
                    🎉 You’ve received a 20% discount for orders over 1000 BDT!
                </div>
                @endif

                <input type="hidden" name="discount" value="{{ $discount }}">
                <input type="hidden" name="vat" value="{{ $vat }}">
                <input type="hidden" name="final_total" value="{{ $finalTotal }}">

                <button type="submit" class="btn btn-success w-100 mt-3">Place Order</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const originalAction = '{{ route("frontend.checkout.submit") }}';
        const sslAction = '{{ url("/pay") }}';

        // Set action on change
        $('input[name="payment_method"]').on('change', function() {
            const selectedMethod = $(this).val();
            if (selectedMethod === 'sslcommerz') {
                $('#checkoutForm').attr('action', sslAction);
            } else {
                $('#checkoutForm').attr('action', originalAction);
            }
        });

        // Also set correct action just before submit
        $('#checkoutForm').on('submit', function() {
            const selectedMethod = $('input[name="payment_method"]:checked').val();
            if (selectedMethod === 'sslcommerz') {
                $(this).attr('action', sslAction);
            } else {
                $(this).attr('action', originalAction);
            }
        });

        // Trigger once on page load
        $('input[name="payment_method"]:checked').trigger('change');
    });
</script>
@endsection