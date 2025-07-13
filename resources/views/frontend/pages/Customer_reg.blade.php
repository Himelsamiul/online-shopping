
@extends('frontend.master')
@section('content')

<style>
.registration-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90vh;
    padding: 20px;
    background-color:rgb(255, 255, 255);
}

.registration-form {
    background-color:rgba(161, 173, 246, 0.83);
    padding: 40px 30px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    width: 100%;
    max-width: 500px;
    position: relative;
}

.registration-form h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: bold;
    color: #4c4c4c;
}

.registration-form .form-group {
    margin-bottom: 20px;
}

.registration-form .form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 16px;
    color: #4c4c4c;
}

.registration-form .form-control {
    border: none;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 10px;
    box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
    transition: 0.3s;
    width: 100%;
}

.registration-form .form-control:focus {
    box-shadow: 0 0 8px rgba(59, 130, 246, 0.6);
}

.registration-form button {
    width: 100%;
    padding: 12px;
    border: none;
    background-color: #6366f1;
    color: white;
    border-radius: 10px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.registration-form button:hover {
    background-color: #4f46e5;
}
</style>

<div class="registration-wrapper">
    <div class="registration-form">
        <h1>Customer Registration</h1>

        <form action="{{ route('customer.done') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" value="{{ old('address') }}">
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</div>

@endsection
