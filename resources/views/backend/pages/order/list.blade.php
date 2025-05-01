@extends('backend.master')

@section('content')
<div class="container">
    <h2>Order</h2>

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
                <th>Total Amount</th>
                <th>Transaction ID</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->address }}</td>
                    <td>BDT. {{ number_format($data->total_amount, 2) }}</td>
                    <td>{{ $data->transaction_id }}</td>
                    <td>{{ $data->payment_method }}</td>
                    <td>{{ $data->payment_status }}</td>
                    <td><a href="{{ route('order.details', $data->id) }}" class="btn btn-info btn-sm">Order Details</a></td>
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
