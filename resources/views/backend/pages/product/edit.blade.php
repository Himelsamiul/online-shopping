@extends('backend.master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Product</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Price:</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Category:</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Unit:</label>
                <select name="unit_id" class="form-control" required>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $unit->id == $product->unit_id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Quantity:</label>
                <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" class="form-control" id="imageInput">
                <br>
                @if($product->image && $product->image != 'no_image.jpg')
                    <p>Current Image: <img src="{{ asset('image/product/' . $product->image) }}" width="100" id="imagePreview"></p>
                    <button type="button" class="btn btn-danger" id="removeImage">Remove Image</button>
                @else
                    <p>No Image Available</p>
                @endif
                <small>If you don't want to change the image, leave this field empty.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <script>
        // Remove image functionality
        document.getElementById('removeImage')?.addEventListener('click', function () {
            document.getElementById('imagePreview').style.display = 'none'; // Hide preview
            document.getElementById('imageInput').value = ''; // Clear file input

            // Add a hidden input to indicate image removal
            let imageInput = document.createElement('input');
            imageInput.type = 'hidden';
            imageInput.name = 'remove_image';
            imageInput.value = 'true';
            document.forms[0].appendChild(imageInput); // Append it to the form
        });
    </script>
@endsection
