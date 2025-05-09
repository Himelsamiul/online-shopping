@extends('frontend.master')

@section('content')
<div class="container mt-5">
    <h2>Checkout</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('frontend.checkout.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name *</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ auth()->guard('customerGuard')->user()->name }}" readonly required>
        </div>

        <div class="mb-3">
            <label>Email *</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ auth()->guard('customerGuard')->user()->email }}" readonly required>
        </div>

        <div class="mb-3">
            <label>Phone Number *</label>
            <input type="text" name="phone" class="form-control" 
                   value="{{ auth()->guard('customerGuard')->user()->phoneno }}" readonly required>
        </div>

        <div class="mb-3">
            <label>Address *</label>
            <textarea name="address" class="form-control" required>{{ old('address', auth()->guard('customerGuard')->user()->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Payment Method *</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash_on_delivery">Cash on Delivery</option>
                <option value="sslcommerz">SSLCommerz (Online Payment)</option>
            </select>
        </div>

        <h4>Order Summary</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>BDT. {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total: BDT. {{ number_format($total, 2) }}</h4>
            <button type="submit" class="btn btn-success">Place Order</button>
        </div>
    </form>
</div>
@endsection
