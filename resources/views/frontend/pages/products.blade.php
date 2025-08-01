@extends('frontend.master')

@section('content')

<div class="blue_bg py-5 text-white text-center">
    <div class="container">
        <h2 class="display-5 fw-bold">Explore Our Products</h2>
        <p class="lead">Find the perfect items for your needs</p>
    </div>
</div>

<div class="container my-5">
    <!-- Message Area -->
    <div id="cartMessage" class="alert alert-warning text-center d-none" role="alert" style="font-weight: bold; font-size: 16px;">
    </div>

    <div class="row g-4">
        @php
            $cart = session('cart', []);
        @endphp

        @foreach($products as $product)
        <div class="col-md-4 col-lg-3 d-flex">
            <div class="card shadow-sm w-100 product-card border-0 rounded-4">
                <a href="{{ route('product.single', $product->id) }}">
                    <img src="{{ url('image/product/' . $product->image) }}" class="card-img-top rounded-top-4" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                </a>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <a href="{{ route('product.single', $product->id) }}" class="text-decoration-none text-dark fw-semibold">
                            {{ $product->name }}
                        </a>
                    </h5>

                    <p class="mb-1">
                        <strong>Price:</strong> 
                        @if($product->previous_price && $product->previous_price > $product->price)
                            <span style="text-decoration: line-through; color: red;">
                                {{ $product->previous_price }} TK
                            </span>
                            &nbsp;
                        @endif
                        <span style="color: green;">{{ $product->price }} TK</span>
                    </p>

                    <p class="mb-3"><strong>Available:</strong> {{ $product->quantity }}</p>
                    <p class="mb-3"><strong>Description:</strong> {{ $product->description }}</p>

                    @php
                        $inCart = isset($cart[$product->id]);
                    @endphp

                    @if($inCart)
                        <button 
                            class="btn btn-light border border-danger text-danger mt-auto w-100 already-in-cart-btn" 
                            data-product="{{ $product->name }}">
                            <strong>Already in Cart</strong>
                        </button>
                    @else
                        <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-primary mt-auto w-100">Add To Cart</a>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }

    .btn.already-in-cart-btn {
        background-color: #ffdddd;
        border: 1px solid red;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartButtons = document.querySelectorAll('.already-in-cart-btn');
        const cartMessage = document.getElementById('cartMessage');

        cartButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const productName = btn.getAttribute('data-product');
                cartMessage.classList.remove('d-none');
                cartMessage.innerHTML = `🛒 <strong>${productName}</strong> is <span style="color: red;">already in your cart</span>. You can increase the quantity from your <a href="{{ route('view.cart') }}" class="text-primary text-decoration-underline">cart</a>.`;

                setTimeout(() => {
                    cartMessage.classList.add('d-none');
                }, 4000);
            });
        });
    });
</script>

@endsection
