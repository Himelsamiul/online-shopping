@extends('frontend.master')
@section('content')

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
