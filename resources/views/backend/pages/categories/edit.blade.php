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
                    <p>Current Image:</p>
                    <img src="{{ asset('image/category/' . $category->image) }}?t={{ time() }}" width="100" id="imagePreview">
                    <br>
                    <button type="button" class="btn btn-danger mt-2" id="removeImage">Remove Image</button>
                @else
                    <p>No Image Available</p>
                    <img src="" id="imagePreview" style="display: none;" width="100">
                @endif

                <small>If you don't want to change the image, leave this field empty.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>

    <script>
        document.getElementById('imageInput')?.addEventListener('change', function (event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('imagePreview').src = reader.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        document.getElementById('removeImage')?.addEventListener('click', function () {
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('imageInput').value = '';

            let removeInput = document.createElement('input');
            removeInput.type = 'hidden';
            removeInput.name = 'remove_image';
            removeInput.value = 'yes';
            document.forms[0].appendChild(removeInput);
        });
    </script>
@endsection
