@extends('backend.master')

@section('content')
<div class="container">
    <h2>Product List</h2>

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

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Stock Value</th>
                <th>Status</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStockValue = 0;
                $totalProducts = 0;
            @endphp

            @foreach($products as $product)
                @php
                    $stockValue = $product->price * $product->quantity;
                    $totalStockValue += $stockValue;
                    $totalProducts += $product->quantity;
                @endphp
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->unit->name }}</td>
                    <td>{{ $product->price }} TK</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $stockValue }} TK</td> <!-- Stock Value calculation here -->
                    <td>{{ ucfirst($product->status) }}</td>
                    <td>
                        @if($product->image)
                            <img class="product-image" src="{{ asset('image/product/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn" data-product-name="{{ $product->name }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5"><strong>Total</strong></td>
                <td><strong>{{ $totalProducts }}</strong></td>
                <td><strong>{{ $totalStockValue }} TK</strong></td> <!-- Total Stock Value -->
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>

    <style>
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</div>

<!-- SweetAlert Delete Confirmation -->
<script>
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productName = button.getAttribute('data-product-name');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete the product: ${productName}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        });
    });
</script>
@endsection
