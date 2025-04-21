@extends('frontend.master')

<!-- @section('title', 'Welcome to Kaira Fashion Store') -->

@section('content')
<div class="text-center mb-5">
    <h1 class="fw-bold text-primary">Welcome to Kaira</h1>
    <p class="lead text-muted">Your one-stop shop for trendy fashion & accessories!</p>
</div>

<h2 class="mb-3">Latest Dresses</h2>
<div class="scrolling-wrapper">
    @for ($i = 1; $i <= 8; $i++)
        <div class="card border-0 shadow-sm" style="min-width: 220px;">
            <img src="https://via.placeholder.com/300x200?text=Dress+{{ $i }}" class="card-img-top" alt="Dress {{ $i }}">
            <div class="card-body">
                <h5 class="card-title text-primary">Dress {{ $i }}</h5>
                <p class="card-text text-muted">$49.99</p>
                <a href="#" class="btn btn-outline-primary btn-sm">Add to Cart</a>
            </div>
        </div>
    @endfor
</div>
@endsection
