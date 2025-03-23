@extends('backend.master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Category</h2>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" class="form-control" required>{{ $category->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" class="form-control" id="imageInput">
                <br>
                @if($category->image && $category->image != 'no_image.jpg')
                    <p>Current Image: <img src="{{ asset('image/category/' . $category->image) }}" width="100" id="imagePreview"></p>
                    <button type="button" class="btn btn-danger" id="removeImage">Remove Image</button>
                @else
                    <p>No Image Available</p>
                @endif
                <small>If you don't want to change the image, leave this field empty.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>

    <script>
        // Remove image functionality for category
        document.getElementById('removeImage')?.addEventListener('click', function () {
            document.getElementById('imagePreview').style.display = 'none'; // Hide preview
            document.getElementById('imageInput').value = ''; // Clear file input

            // Add a hidden input to indicate image removal
            let imageInput = document.createElement('input');
            imageInput.type = 'hidden';
            imageInput.name = 'remove_image';
            imageInput.value = 'yes';
            document.forms[0].appendChild(imageInput); // Append it to the form
        });
    </script>
@endsection
