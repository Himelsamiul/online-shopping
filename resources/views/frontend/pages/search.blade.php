@extends('frontend.master')
@section('content')

  <div class="container">
    <h2>Search Results for: "{{ $searchTerm }}"</h2>

    @if($products->isEmpty())
      <p>No products found matching your search.</p>
    @else
      <div class="row">
        @foreach($products as $product)
          <div class="col-md-4">
            <div class="card">
            <img style="height: 270px; width: 250px;" src="{{ url('image/product/' . $product->image) }}" alt="{{ $product->name }}">
              <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
               
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
