@extends('backend.master')

@section('content')
<div class="container">
    <h2>Product List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th> <!-- ID Column -->
                <th>Name</th> <!-- Name Column -->
                <th>Category</th> <!-- Category Column -->
                <th>Unit</th> <!-- Unit Column -->
                <th>Price</th> <!-- Price Column -->
                <th>Quantity</th> <!-- Quantity Column -->
                <th>Image</th> <!-- Image Column -->
                <th>Status</th> <!-- Status Column -->
                <th>Actions</th> <!-- Actions Column -->
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td> <!-- Product ID -->
                <td>{{ $product->name }}</td> <!-- Product Name -->
                <td>{{ $product->category->name }}</td> <!-- Category Name -->
                <td>{{ $product->unit->name }}</td> <!-- Unit Name -->
                <td>{{ $product->price }}</td> <!-- Product Price -->
                <td>{{ $product->quantity }}</td> <!-- Quantity -->
                <td>
                    @if($product->image)
                    <img class="product-image" src="{{ asset('image/product/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        No Image
                    @endif
                </td> <!-- Product Image -->
                <td>{{ ucfirst($product->status) }}</td> <!-- Product Status -->
                <td>
                    <a href="" class="btn btn-warning btn-sm">Edit</a>
                    <form action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
    <style>
        .product-image {
            width: 80px; /* Set a fixed width */
            height: 80px; /* Set a fixed height */
            object-fit: cover; /* Ensures the image maintains aspect ratio */
            border-radius: 5px; /* Optional: Adds rounded corners */
        }
    </style>
</div>
@endsection
