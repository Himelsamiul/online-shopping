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
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <!-- Correct SL with pagination -->
                <td>{{ $products->firstItem() + $loop->index }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->unit->name }}</td>
                <td>{{ $product->price }}TK</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    @if($product->image)
                        <img class="product-image" src="{{ asset('image/product/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ ucfirst($product->status) }}</td>
                <td>
                    <!-- View -->
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>

                    <!-- Edit -->
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Delete -->
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
            <!-- Add the totals row at the bottom of the Price column -->
            <tr>
                <td colspan="4"><strong>Total</strong></td> <!-- Total label spanning 4 columns -->
                <td><strong>{{ $totalAmount }} TK</strong></td> <!-- Total Amount in Price column -->
                <td><strong>{{ $totalProducts }}</strong></td> <!-- Total Quantity -->
                <td></td> <!-- Empty for Image column -->
                <td></td> <!-- Empty for Status column -->
                <td></td> <!-- Empty for Actions column -->
            </tr>
        </tfoot>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>

    <!-- Styling -->
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
