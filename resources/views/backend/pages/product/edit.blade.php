@extends('backend.master')

@section('content')
<style>
    .edit-product-container {
        max-width: 700px;
        margin: auto;
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .edit-product-container h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
        color: #343a40;
    }

    .form-group label {
        font-weight: 600;
        color: #444;
    }

    .form-control:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
    }

    .btn-primary {
        background-color: #6c63ff;
        border-color: #6c63ff;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #5a54e3;
        border-color: #5a54e3;
    }

    .btn-danger {
        margin-top: 10px;
    }

    #imagePreview {
        margin-top: 10px;
        border-radius: 10px;
        border: 2px solid #ccc;
        transition: transform 0.3s ease;
    }

    #imagePreview:hover {
        transform: scale(1.1);
    }
</style>

<div class="container mt-5">
    <div class="edit-product-container">
        <h2>Edit Product</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Name:</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Description:</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>Price:</label>
                <input type="number" id="price" name="price" 
                       value="{{ number_format($product->price, 2, '.', '') }}" 
                       class="form-control" step="any" required>
            </div>

            <div class="form-group mb-3">
                <label>Previous Price:</label>
                <input type="number" id="previous_price" name="previous_price" 
                       value="{{ number_format($product->previous_price, 2, '.', '') }}" 
                       class="form-control" step="any">
            </div>

            <div class="form-group mb-3">
                <label>Category:</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Unit:</label>
                <select name="unit_id" class="form-control" required>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $unit->id == $product->unit_id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Size:</label>
                <select name="size_id" class="form-control" required>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}" {{ $size->id == $product->size_id ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Quantity:</label>
                <input type="number" id="quantity" name="quantity" 
                       value="{{ $product->quantity }}" 
                       class="form-control" step="any" required>
            </div>

            <div class="form-group mb-3">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label>Image:</label>
                <input type="file" name="image" class="form-control" id="imageInput">
                @if($product->image && $product->image != 'no_image.jpg')
                    <div class="mt-2">
                        <p>Current Image:</p>
                        <img src="{{ asset('image/product/' . $product->image) }}" width="150" id="imagePreview">
                        <button type="button" class="btn btn-sm btn-danger" id="removeImage">Remove Image</button>
                    </div>
                @else
                    <p class="text-muted">No Image Available</p>
                @endif
                <small class="text-muted">Leave empty if you don’t want to change the image.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

<script>
    // Remove image handler
    document.getElementById('removeImage')?.addEventListener('click', function () {
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('imageInput').value = '';

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_image';
        hiddenInput.value = 'true';
        document.forms[0].appendChild(hiddenInput);
    });

    // Force step increment = 1 on arrow keys
    document.querySelectorAll('input[type="number"]').forEach(function (el) {
        el.addEventListener('keydown', function (event) {
            if (event.key === "ArrowUp") {
                event.preventDefault();
                el.value = (parseFloat(el.value) || 0) + 1;
            } else if (event.key === "ArrowDown") {
                event.preventDefault();
                el.value = (parseFloat(el.value) || 0) - 1;
            }
        });
    });
</script>
@endsection
