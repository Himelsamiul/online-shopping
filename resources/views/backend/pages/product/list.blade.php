@extends('backend.master')

@section('content')
<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">📦 Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success shadow float-button">
            <i class="fas fa-plus-circle"></i> Create Product
        </a>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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

    <div class="table-responsive animated fadeInUp">
        <table class="table table-striped table-hover table-bordered shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Description</th>

                    <th>Category</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Previous Price</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Stock Value</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
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
                        <td class="fw-normal text-primary">{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->unit->name }}</td>
                       <td>{{ $product->size->name ?? '-' }}</td>

                        <td>{{ $product->previous_price }} TK</td>
                        <td class="text-black fw-normal">{{ $product->price }} TK</td>
                        <td>{{ $product->quantity }}</td>
                        <td class="text-info">{{ $stockValue }} TK</td>
                        <td>
                            <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            @if($product->image)
                                <img class="product-image" src="{{ asset('image/product/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mb-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm mb-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-btn mb-1" data-product-name="{{ $product->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light text-center fw-bold">
                <tr>
                    <td colspan="8">Total</td>
                    <td>{{ $totalProducts }}</td>
                    <td>{{ $totalStockValue }} TK</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>

</div>

<!-- SweetAlert Delete Confirmation -->
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const productName = button.getAttribute('data-product-name');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete: ${productName}`,
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

<!-- Styles -->
<style>
    .product-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.1);
    }

    .float-button {
        position: relative;
        animation: floatUp 1s ease-out;
    }

    @keyframes floatUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated {
        animation: fadeIn 0.8s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    table.table-hover tbody tr:hover {
        background-color: #f0f9ff;
        cursor: pointer;
    }
</style>
@endsection
