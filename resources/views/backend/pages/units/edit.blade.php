@extends('backend.master')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Unit</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('units.update', $unit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Unit Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $unit->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="1" {{ $unit->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$unit->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update Unit</button>
                    <a href="{{ route('units.list') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
