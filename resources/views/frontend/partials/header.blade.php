<header>
  <div class="header">
    <div class="header_top d_none1">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <ul class="conta_icon">
              <li><a href="https://www.free-css.com/free-css-templates"><img src="{{url('frontend/assets/images/call.png')}}" alt="website template image">Call us: 0126 - 922 - 0162</a></li>
            </ul>
          </div>
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
            <div class="se_fonr1">
              <span class="time_o"> Open hour: 8.00 - 18.00</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header_midil">
      <div class="container">
        <div class="row d_flex">
          <div class="col-md-4">
            <ul class="conta_icon d_none1">
              <li><a href="https://www.free-css.com/free-css-templates"><img src="{{url('frontend/assets/images/email.png')}}" alt="website template image"> mail@domain.com</a></li>
            </ul>
          </div>

          <div class="col-md-4"><a class="logo" href="https://www.free-css.com/free-css-templates"><img src="{{url('frontend/assets/images/logo.png')}}" alt="website template image"></a></div>
          <div class="col-md-4">
            <ul class="right_icon d_none1">
              @php
              $cart = session('cart', []);
              $cartCount = collect($cart)->sum('quantity');
              @endphp

              <li>
                <a href="{{route('view.cart')}}">
                  <img src="{{ url('frontend/assets/images/shopping.png') }}" alt="cart">
                  <span style="color: red;">({{$cartCount}})</span>
                </a>
              </li>

              @guest('customerGuard')
              <a href="{{ route('reg') }}" class="order">Registration</a>
              <a href="{{ route('login') }}" class="order">Login</a>
              @endguest

              @auth('customerGuard')
              <a href="{{ route('logout.success') }}" class="order">Logout</a>
              @endauth

            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="header_bottom">
      <div class="container">
        <div class="row">
          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
            <nav class="navigation navbar navbar-expand-md navbar-dark">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
              <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item"><a class="nav-link" href="{{route('webpage')}}">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('products')}}">Products</a></li>
                  <li class="nav-item"><a class="nav-link" href="pages/contact.php">Contact Us</a></li>
                </ul>
              </div>
            </nav>
          </div>
          <!-- <div class="col-md-4">
            <div class="search">
              <form action="#" method="post">
                <input class="form_sea" type="text" placeholder="Search" name="search">
                <button type="submit" class="seach_icon"><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</header>