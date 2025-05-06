@extends('backend.master')

@section('content')
<div class="container">
    <h2>Order</h2>

    <!-- ✅ Total Order Amount -->
    

    <!-- ✅ SweetAlert Success -->
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

    <table class="table table-bordered mt-3">
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
        @foreach($orders as $key => $data)
            <tr>
                <td>{{ $orders->firstItem() + $key }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->address }}</td>
                <td>BDT. {{ number_format($data->total_amount, 2) }}</td>
                <td>{{ $data->transaction_id }}</td>
                <td>{{ $data->payment_method }}</td>
                <td>{{ ucfirst($data->payment_status) }}</td>
                <td>
                    <a href="{{ route('order.details', $data->id) }}" class="btn btn-info btn-sm">Order Details</a>
                </td>
            </tr>
        @endforeach
    </tbody>

    <!-- ✅ Total Row in Table Footer -->
    <tfoot>
        <tr>
            <td colspan="4" class="text-end"><strong>Total Order Amount:</strong></td>
            <td colspan="5"><strong class="text-success">BDT. {{ number_format($totalOrderAmount, 2) }}</strong></td>
        </tr>
    </tfoot>
</table>


    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>

    <!-- Styling -->
    <style>
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .pagination .page-item .page-link {
            color: #007bff;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            margin: 0 3px;
            border-radius: 4px;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }
    </style>
</div>
@endsection
