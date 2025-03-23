@extends('backend.master')

@section('content')
    <div class="container mt-4">
        <h2>Product Details</h2>

        <div class="card">
            <div class="card-header">
                <h4>{{ $product->name }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p><strong>Unit:</strong> {{ $product->unit->name }}</p>
                <p><strong>Price:</strong> ${{ $product->price }}</p>
                <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $product->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </p>
                <p><strong>Description:</strong> {{ $product->description }}</p>

                <div class="mb-3">
                    <img src="{{ asset('image/product/'.$product->image) }}" width="200" class="img-thumbnail">
                </div>

                <a href="{{ route('products.list') }}" class="btn btn-secondary">Back to List</a>
                <!-- You can also add edit and delete buttons here -->
            </div>
        </div>
    </div>
@endsection
