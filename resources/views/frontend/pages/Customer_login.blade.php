@extends('frontend.master')

@section('content')


<div class="container">
    <div class="login-card">
        <h2>Login</h2>
        <form action="{{ route('customer.success') }}" method="POST">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Enter your email" class="input-field" value="{{ old('email') }}" required>
            </div>

            <div>
                <input type="password" name="password" placeholder="Enter your password" class="input-field" required>
            </div>

            <div class="form-footer">
                <div>
                    <input type="checkbox" name="remember-me" id="remember-me">
                    <label for="remember-me">Remember Me</label>
                </div>
                <div>
                    <a href="#">Forgot Password?</a>
                </div>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>

        
    </div>
</div>

@endsection
