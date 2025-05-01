@extends('frontend.master')
@section('content')
<section class="banner_main">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="text-bg">
          <h1> <span class="blodark"> Romofyi</span><br>
            Trands 2055</h1>
          <p>A huge fashion collection for ever</p>
          <a class="" href="https://www.free-css.com/free-css-templates"></a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="ban_img">
          <figure><img src="{{url('frontend/assets/images/ban_img.png')}}" alt="website template image"></figure>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="six_box">
  <div class="container-fluid">
    <div class="row">
      @foreach($category->take(6) as $data)
      <div class="col-md-2 col-sm-4 pa_left">
        <div class="six_probpx yellow_bg">
          <i><img style="width: 90px; height:90px;" src="{{ url('image/category/' . $data->image) }}" alt="website template image"></i>
          <span><a href="{{ route('products', ['categoryId' => $data->id]) }}">{{ $data->name }}</a></span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<div id="project" class="project">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="titlepage">
          <h2>Featured Products</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="product_main">
        @foreach($products->take(15) as $product)
        <div class="project_box">
          <div class="dark_white_bg">
            <a href="{{ route('product.single', $product->id) }}">
              <img style="height: 255px; width: 200px;" src="{{ url('image/product/' . $product->image) }}" alt="{{ $product->name }}">
            </a>
          </div>
          <h3><a href="{{ route('product.single', $product->id) }}">{{ $product->name }}</a></h3>
          <h4>BDT. {{$product->price}}</h4>
        </div>
        @endforeach
        <div class="col-md-12"><a class="read_more" href="{{route('products')}}">See More</a></div>
      </div>
    </div>
  </div>
</div>
@endsection