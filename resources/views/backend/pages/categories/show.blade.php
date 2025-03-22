@extends('backend.master')

@section('content')
    <div class="container">
        <h2>Category Details</h2>

        <div class="card">
            <div class="card-header">
                <h3>{{ $category->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $category->description }}</p>
                <p><strong>Status:</strong> {{ ucfirst($category->status) }}</p>
                <p><strong>Image:</strong></p>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="200">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>

        <a href="{{ route('categories.list') }}" class="btn btn-primary">Back to Categories</a>
    </div>
@endsection
