<header>
  <div class="header">
    <div class="header_top d_none1">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <ul class="conta_icon">
              <li>
                <a href="https://wa.me/8801795-053841" target="_blank">
                  <img src="{{ url('frontend/assets/images/call.png') }}" alt="call">
                  WhatsApp: 01795-053841
                </a>
              </li>
            </ul>
          </div>
          <div class="col-md-4"></div>
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
              <li>
                <a href="https://www.free-css.com/free-css-templates">
                  <img src="{{ url('frontend/assets/images/email.png') }}" alt="email">elegance.bd@gmail.com
                </a>
              </li>
            </ul>
          </div>

          <!-- TEXT LOGO START -->
          <div class="col-md-4 text-center">
            <a class="logo" href="https://www.free-css.com/free-css-templates" style="font-size: 30px; font-weight: bold; text-decoration: none; font-family: 'Poppins', sans-serif; letter-spacing: 1px;">
              <span style="color: rgb(47, 93, 140); text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Elegance</span><span style="color: #FFD700; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Bd</span>
            </a>
          </div>
          <!-- TEXT LOGO END -->

          <div class="col-md-4">
            <ul class="right_icon d_none1" style="display: flex; align-items: center;">
              @php
                $cart = session('cart', []);
                $cartCount = count($cart); 
              @endphp

              <li style="margin-right: 15px;">
                <a href="{{ route('view.cart') }}" style="display: inline-flex; align-items: center; gap: 2px;">
                  <img src="{{ url('frontend/assets/images/shopping.png') }}" alt="cart" style="width: 20px; height: auto;">
                  <span style="color: red;">({{ $cartCount }})</span>
                </a>
              </li>

              @guest('customerGuard')
                <a href="{{ route('reg') }}" class="order">Registration</a>
                <a href="{{ route('login') }}" class="order">Login</a>
              @endguest

              @auth('customerGuard')
                <a href="#" id="logout-btn" class="order">Logout</a>
                <a href="{{ route('profile') }}" class="order">Profile</a>
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
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item"><a class="nav-link" href="{{ route('webpage') }}">Home</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Products
                    </a>
                    <div class="dropdown-menu" aria-labelledby="productsDropdown">
                      @foreach($categories as $category)
                        <a class="dropdown-item" href="{{ route('products', ['categoryId' => $category->id]) }}">
                          {{ $category->name }}
                        </a>
                      @endforeach
                    </div>
                  </li>
                  <li class="nav-item"><a class="nav-link" href="{{ route('contactus') }}">Contact Us</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{ route('aboutus') }}">About Us</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('frequently.ask.question')}}">FAQ</a></li>
                </ul>
              </div>
            </nav>
          </div>
          <div class="col-md-4">
            <div class="search">
              <form action="{{ route('search.products') }}" method="GET">
                <input class="form_sea" type="text" placeholder="Search" name="search" value="{{ request('search') }}">
                <button type="submit" class="seach_icon"><i class="fa fa-search"></i></button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const logoutBtn = document.getElementById('logout-btn');
      if(logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
          e.preventDefault();

          Swal.fire({
            title: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "{{ route('logout.success') }}";
            }
          });
        });
      }
    });
  </script>
</header>
