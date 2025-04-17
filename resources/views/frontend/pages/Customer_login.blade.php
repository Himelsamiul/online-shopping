@extends('frontend.master')

@section('content')

<style>
    /* Custom CSS */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f7f7f7;
    }

    .login-card {
        background: #fff;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
    }

    .login-card h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
        color: #007bff;
    }

    .input-field {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 1rem;
    }

    .input-field:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }

    .text-center {
        text-align: center;
        margin-top: 20px;
    }

    .text-center a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .text-center a:hover {
        text-decoration: underline;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .form-footer a {
        color: #007bff;
        text-decoration: none;
    }
</style>

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

        <div class="text-center">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </div>
</div>

@endsection
