@extends('frontend.master')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img style="height:400px; width:400px;" src="{{ url('image/product/' . $product->image) }}" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <h4>Price: BDT. {{ $product->price }}</h4>
            <p>{{ $product->description }}</p>
            <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-success mt-3">Add To Cart</a>
        </div>
    </div>
</div>

@endsection
