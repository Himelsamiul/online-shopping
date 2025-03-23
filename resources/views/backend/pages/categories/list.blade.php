@extends('backend.master')

@section('content')
    <h1>Category List</h1>

    <!-- Create New Category Button -->
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

    @if(session('success'))
        <div id="success-message" data-message="{{ session('success') }}"></div>
    @endif

    <!-- Search & Filter Form -->
    <form action="{{ route('categories.list') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="search" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($allCategories as $cat)
                        <option value="{{ $cat->name }}" {{ request('search') == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-control">
                    <option value="">Filter by status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success">Search</button>
                <a href="{{ route('categories.list') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Category Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ ucfirst($category->status) }}</td>
                    <td>
                        @if($category->image && $category->image !== 'no_image.jpg')
                            <img class="category-image" src="{{ asset('image/category/' . $category->image) }}?t={{ time() }}" alt="{{ $category->name }}">
                        @else
                            <img class="category-image" src="{{ asset('image/no_image.jpg') }}" alt="No Image">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.delete', $category->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>

    <style>
        .category-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show success message using SweetAlert
            const successMessage = document.getElementById("success-message");
            if (successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage.getAttribute("data-message"),
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }

            // SweetAlert confirmation for delete action
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const categoryName = form.closest('tr').querySelector('td:nth-child(2)').textContent;
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete the category: ${categoryName}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @endpush
@endsection
