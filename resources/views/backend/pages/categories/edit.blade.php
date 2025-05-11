@extends('backend.master')

@section('content')
    <div class="container mt-5">
        <!-- Form Container -->
        <div class="card edit-card">
            <div class="card-body">
                <!-- Header Section Inside Form -->
                <div class="d-flex justify-content-between mb-4">
                    <h2 class="page-title">Edit Category</h2>
                </div>

                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control" required id="name">
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" class="form-control" required id="description">{{ $category->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" class="form-control" required id="status">
                            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" name="image" class="form-control" id="imageInput">
                        <br>

                        @if($category->image && $category->image != 'no_image.jpg')
                            <p>Current Image:</p>
                            <img src="{{ asset('image/category/' . $category->image) }}?t={{ time() }}" width="100" id="imagePreview">
                            <br>
                            <button type="button" class="btn btn-remove-image mt-2" id="removeImage" title="Remove Image">
                                <svg class="trash-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        @else
                            <p>No Image Available</p>
                            <img src="" id="imagePreview" style="display: none;" width="100">
                        @endif

                        <small>If you don't want to change the image, leave this field empty.</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Category</button>
                </form>
            </div>
        </div>
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

            // Add visual feedback
            this.classList.add('removing');
            setTimeout(() => this.classList.remove('removing'), 300);
        });
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
            width: 100%;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2.2em;
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 0;
        }

        .card {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            animation: slideUp 0.5s ease-out;
        }

        .card-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            color: #34495e;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 1em;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
        }

        .btn {
            padding: 12px;
            border-radius: 8px;
            font-size: 1.2em;
            background-color: #3498db;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .btn.w-100 {
            width: 100%;
        }

        .btn-remove-image {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: #e74c3c;
            border: none;
            border-radius: 50%;
            padding: 0;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }

        .btn-remove-image:hover {
            background-color: #c0392b;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-remove-image.removing {
            animation: pulse 0.3s ease;
        }

        .trash-icon {
            width: 18px;
            height: 18px;
            stroke: #fff;
            transition: stroke 0.3s ease;
        }

        .btn-remove-image:hover .trash-icon {
            stroke: #f1f1f1;
        }

        #imagePreview {
            border-radius: 8px;
            margin-top: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s ease;
        }

        small {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8em;
            }

            .container {
                padding: 15px;
            }

            .form-control {
                padding: 10px;
                font-size: 0.95em;
            }

            .btn {
                font-size: 1.1em;
                padding: 10px;
            }

            .btn-remove-image {
                width: 32px;
                height: 32px;
            }

            .trash-icon {
                width: 16px;
                height: 16px;
            }
        }
    </style>
@endsection