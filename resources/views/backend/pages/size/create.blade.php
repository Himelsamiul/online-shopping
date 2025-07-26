@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h4>Add New Size</h4>
    <form action="{{ route('sizes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name">Size Name</label>
            <input type="text" class="form-control" name="name" placeholder="e.g. S, M, L, XL">
        </div>
        <button type="submit" class="btn btn-success">Add Size</button>
    </form>
</div>
@endsection
