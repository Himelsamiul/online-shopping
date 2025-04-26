@extends('backend.master')

@section('content')
<div class="container">
    <h2>Order Details</h2>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Products</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->address }}</td>
                    <td>
                        @php
                            $cartItems = json_decode($data->cart_data, true);
                        @endphp

                        @if($cartItems)
                            <ul style="list-style: none; padding: 0;">
                                @foreach($cartItems as $item)
                                    <li class="d-flex align-items-center mb-2">
                                        <img src="{{ url('image/product/' . $item['image']) }}" class="product-image me-2" alt="{{ $item['name'] }}">
                                        <div>
                                            <strong>{{ $item['name'] }}</strong><br>
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
                    <td>BDT. {{ number_format($data->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Styling -->
    <style>
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</div>
@endsection
