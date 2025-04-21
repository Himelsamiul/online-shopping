@extends('frontend.master')
@section('content')

<style>
    /* Custom CSS */
    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: bold;
        font-size: 1.1rem;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        border: none;
        border-radius: 6px;
        font-size: 1.1rem;
        color: white;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-header h1 {
        font-size: 2rem;
        color: #007bff;
        font-weight: bold;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
    }

    .form-footer a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    .alert-danger {
        color: #dc3545;
        font-size: 0.9rem;
    }
</style>

<div class="col-9 pt-4">
    <div class="container">
        <div class="form-header">
            <h1>Customer Registration</h1>
        </div>

        <form action="{{ route('customer.done') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" value="{{ old('address') }}">
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        
    </div>
</div>

@endsection
