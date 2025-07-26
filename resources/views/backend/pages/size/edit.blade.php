@extends('backend.master')

@section('content')
<div class="container mt-5">
    <h2>Edit Size</h2>

    <form action="{{ route('sizes.update', $size->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Size Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $size->name) }}" class="form-control" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Size</button>
    </form>
</div>
@endsection
