@extends('frontend.master')

@section('content')

<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div style="border:1px solid #ddd; padding:10px; width:100%; max-width:400px; height:400px; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                <img src="{{ url('image/product/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:100%; max-height:100%; object-fit:contain;">
            </div>
        </div>

        <!-- Product Details and Review (Side by Side on Desktop) -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <h4 class="text-success">Price: BDT {{ $product->price }}</h4>
            <p class="text-muted">{{ $product->description }}</p>
            <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-success mt-3">Add To Cart</a>

            <!-- Submit Review Section (directly below product details) -->
            @auth
                <div class="mt-5">
                    <h4 class="mb-3">Leave a Review</h4>
                    <form action="{{ route('submit.review', $product->id) }}" method="POST">
                        @csrf
                        <!-- Star Rating -->
                        <div class="form-group mb-3">
                            <label>Your Rating:</label><br>
                            <div class="star-rating d-flex gap-1" style="font-size: 30px;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" style="display:none;">
                                    <label for="star{{ $i }}" style="cursor:pointer; color: #ccc;">&#9733;</label>
                                @endfor
                            </div>
                        </div>

                        <!-- Review Text -->
                        <div class="form-group mb-3">
                            <label for="review">Your Review:</label>
                            <input type="text" name="review" id="review" class="form-control" placeholder="Write your thoughts..." required>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</div>

<script>
    // Highlight stars left to right on selection
    const labels = document.querySelectorAll('.star-rating label');
    const inputs = document.querySelectorAll('.star-rating input');

    inputs.forEach((input, idx) => {
        input.addEventListener('change', function () {
            labels.forEach((label, labelIdx) => {
                label.style.color = (labelIdx <= idx) ? '#ffc107' : '#ccc';
            });
        });
    });
</script>

@endsection
