<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">Kaira</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="{{route('webpage')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="#">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="#">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="#">Cart</a>
                </li>

                @guest('customerGuard') <!-- Check if the user is not logged in -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary" href="{{ route('customer.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary" href="{{ route('reg') }}">Registration</a>
                    </li>
                @else <!-- If the user is logged in -->
                    <li class="nav-item">
                        <span class="nav-link text-danger">{{ auth('customerGuard')->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout.success') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-danger" style="border: none; padding: 0;">
                                Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
