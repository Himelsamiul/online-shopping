@extends('frontend.master')

@section('content')

<div class="blue_bg py-5 text-white text-center">
    <div class="container">
        <h2 class="display-5 fw-bold">Explore Our Products</h2>
        <p class="lead">Find the perfect items for your needs</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3 d-flex">
            <div class="card shadow-sm w-100 product-card border-0 rounded-4">
                <div class="image-container">
                    <a href="{{ route('product.single', $product->id) }}">
                        <img src="{{ url('image/product/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="card-body bg-light-subtle d-flex flex-column">
                    <h5 class="card-title">
                        <a href="{{ route('product.single', $product->id) }}" class="text-decoration-none text-dark fw-semibold">
                            {{ $product->name }}
                        </a>
                    </h5>
                    <p class="mb-1"><strong>Price:</strong> {{ $product->price }} TK</p>
                    <p class="mb-3"><strong>Available:</strong> {{ $product->quantity }}</p>
                    <button class="btn btn-primary mt-auto w-100 add-to-cart-btn" data-url="{{ route('add.to.cart', $product->id) }}" data-name="{{ $product->name }}">
                        Add To Cart
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Styles for uniform image & card design -->
<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(127, 69, 69, 0.15);
    }
    .image-container {
        width: 100%;
        height: 250px;
        overflow: hidden;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-container img {
        height: 100%;
        width: auto;
        object-fit: contain;
    }
</style>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                const productName = this.getAttribute('data-name');

                // Simulate form submission
                fetch(url)
                    .then(response => {
                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Added to Cart!',
                                text: `${productName} has been added to your cart.`,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            throw new Error('Failed to add product.');
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    });
            });
        });
    });
</script>

@endsection
