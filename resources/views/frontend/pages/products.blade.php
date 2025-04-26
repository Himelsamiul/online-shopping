@extends('frontend.master')

@section('content')

<div class="blue_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Products</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="project" class="project">
    <div class="container">
        <div class="row">
            <div class="product_main">
                @foreach($products as $product)
                <div class="project_box">
                    <div class="dark_white_bg">
                        <!-- Make image clickable -->
                        <a href="{{ route('product.single', $product->id) }}">
                            <img style="height: 270px; width: 250px;" src="{{ url('image/product/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    
                    <!-- Make name clickable -->
                    <h3>
                        <a href="{{ route('product.single', $product->id) }}">{{ $product->name }}</a>
                    </h3>

                    <h4>Price: {{$product->price}}</h4>

                    <a class="read_more" href="{{ route('add.to.cart', $product->id) }}">Add To Cart</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
