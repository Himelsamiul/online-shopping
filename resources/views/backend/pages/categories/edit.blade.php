@extends('backend.master')

@section('content')
    <h1>Edit Category</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Category Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($category->image)
                <div class="mt-2">
                    <img class="img-thumbnail" src="{{ asset('image/category/' . $category->image) }}" alt="{{ $category->name }}" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
@endsection
