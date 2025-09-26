@extends('backend.master')

@section('content')
<style>
    /* Container */
    .form-wrapper {
        max-width: 600px;
        margin: 40px auto;
        background: #f9faff;
        border-radius: 12px;
        padding: 40px 35px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: background-color 0.3s ease;
    }
    .form-wrapper:hover {
        background-color: #e7f0ff;
    }

    /* Title */
    .form-title {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        color: #1a237e;
        letter-spacing: 1.1px;
    }

    /* Labels */
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #303f9f;
    }

    /* Input fields */
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #bbdefb;
        border-radius: 8px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
        color: #222;
    }
    .form-control:focus {
        border-color: #1e88e5;
        box-shadow: 0 0 8px rgba(30, 136, 229, 0.4);
    }

    /* Select inputs */
    select.form-control {
        background-color: white;
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3csvg fill="%23303f9f" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"%3e%3cpath d="M7 10l5 5 5-5z"/%3e%3c/svg%3e');
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px 18px;
        cursor: pointer;
    }

    /* Submit button */
    .btn-primary {
        width: 100%;
        padding: 14px;
        font-weight: 700;
        border-radius: 8px;
        background-color: #1e88e5;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        user-select: none;
    }
    .btn-primary:hover:not(:disabled) {
        background-color: #1565c0;
    }
    .btn-primary:disabled {
        background-color: #90caf9;
        cursor: not-allowed;
    }

    /* Top left button */
    .top-left-button {
        margin-bottom: 25px;
    }
    .top-left-button a {
        padding: 8px 20px;
        background-color: #1e88e5;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(30, 136, 229, 0.4);
        display: inline-block;
        transition: background-color 0.3s ease;
        user-select: none;
    }
    .top-left-button a:hover {
        background-color: #1565c0;
    }

    /* Form row */
    .form-row {
        display: flex;
        gap: 20px;
    }
    .form-row .form-group {
        flex: 1;
    }

    /* Image preview */
    #imagePreview {
        display: block;
        margin: 15px auto 30px;
        max-width: 100%;
        max-height: 250px;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(30, 136, 229, 0.25);
        object-fit: contain;
    }
</style>

<div class="form-wrapper">
    <!-- List Button -->
    <div class="top-left-button">
        <a href="{{ route('products.list') }}">← List</a>
    </div>

    <h2 class="form-title">Create New Product</h2>

    <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- Name -->
        <div class="form-group mb-3">
            <label for="name">Product Name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <!-- Category, Unit & Size -->
        <div class="form-row mb-3">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="unit_id">Unit</label>
                <select id="unit_id" name="unit_id" class="form-control" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="size_id">Size</label>
                <select id="size_id" name="size_id" class="form-control" required>
                    <option value="">Select Size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <!-- Price & Previous Price -->
        <div class="form-row mb-3">
            <div class="form-group">
                <label for="price">Price</label>
                <input id="price" type="number" name="price" class="form-control" 
                       value="{{ old('price') }}" step="any" required>
            </div>

            <div class="form-group">
                <label for="previous_price">Previous Price</label>
                <input id="previous_price" type="number" name="previous_price" class="form-control" 
                       value="{{ old('previous_price') }}" step="any">
            </div>
        </div>

        <!-- Quantity -->
        <div class="form-group mb-3">
            <label for="quantity">Quantity</label>
            <input id="quantity" type="number" name="quantity" class="form-control" 
                   value="{{ old('quantity') }}" step="any" required>
        </div>

        <!-- Status -->
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="">Select Status</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Image -->
        <div class="form-group mb-4">
            <label for="image">Product Image</label>
            <input id="image" type="file" name="image" class="form-control" accept="image/*">
            <img id="imagePreview" src="#" alt="Image Preview" style="display:none;" />
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button id="submitBtn" type="submit" class="btn btn-primary" disabled>Create Product</button>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productForm');
        const submitBtn = document.getElementById('submitBtn');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        // Enable submit button only if all required fields are filled
        function validateForm() {
            const requiredFields = ['name', 'category_id', 'unit_id', 'size_id', 'description', 'price', 'quantity', 'status'];
            let isValid = true;

            for (const fieldId of requiredFields) {
                const el = document.getElementById(fieldId);
                if (!el || !el.value.trim()) {
                    isValid = false;
                    break;
                }
            }

            submitBtn.disabled = !isValid;
        }

        // Preview selected image
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.src = '#';
            }
        });

        // Validate on input change
        form.addEventListener('input', validateForm);
        form.addEventListener('change', validateForm);

        // Initial validation check
        validateForm();

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
    });
</script>
@endsection
