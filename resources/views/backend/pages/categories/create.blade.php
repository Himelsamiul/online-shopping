@extends('backend.master')

@section('content')
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<style>
    .card {
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background: #f9f9fb;
        padding: 30px;
        width: 100%;
        max-width: 500px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control, .form-select {
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #4a69bd;
        border-color: #4a69bd;
    }

    .btn-primary:hover {
        background-color: #3b55a0;
    }

    .top-btn {
        position: absolute;
        top: 20px;
        right: 40px;
    }

    .top-btn a {
        background-color: #10ac84;
        color: white;
        font-weight: bold;
        padding: 8px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .top-btn a:hover {
        background-color: #079e6d;
    }

    .full-height {
        min-height: 100vh;
    }

    .header-title {
        position: absolute;
        top: 20px;
        left: 40px;
        font-size: 24px;
        font-weight: bold;
        color: #4a69bd;
    }

    .char-counter {
        font-size: 0.875rem;
        color: #666;
        text-align: right;
    }
</style>

<div class="container-fluid full-height d-flex justify-content-center align-items-center position-relative">
    <!-- Header title -->
    <div class="header-title">Category Create</div>

    <!-- Top Right Button -->
    <div class="top-btn">
        <a href="{{ route('categories.list') }}">Category List</a>
    </div>

    <!-- Centered Form Card -->
    <div class="card">
        <h2 class="mb-4 text-center text-primary">Create New Category</h2>

        <form id="category-form" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Category Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" maxlength="300" required>{{ old('description') }}</textarea>
                <div class="char-counter" id="desc-counter">0 / 300</div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Category Image (Optional)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <img id="image-preview" src="#" alt="Preview" style="display:none; margin-top:10px; max-height:150px;" />
            </div>

            <button type="submit" class="btn btn-primary w-100" id="submit-btn">Create Category</button>
        </form>
    </div>
</div>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('image-preview');
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '';
        }
    });

    // Character counter
    const description = document.getElementById('description');
    const counter = document.getElementById('desc-counter');
    description.addEventListener('input', function () {
        counter.textContent = `${description.value.length} / 300`;
    });

    // Disable submit button on form submit
    document.getElementById('category-form').addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.textContent = 'Submitting...';
    });
</script>

@if(session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif

@endsection
