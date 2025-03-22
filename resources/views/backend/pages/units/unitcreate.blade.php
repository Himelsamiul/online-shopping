@extends('backend.master')

@section('content')
<div class="container">
    <h1>Create New Unit</h1>

    <form action="{{ route('units.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Unit Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Unit</button>
    </form>
</div>
@endsection
