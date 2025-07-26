@extends('backend.master')

@section('content')
    <h1>Category List</h1>

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

    @if(session('success'))
        <div id="success-message" data-message="{{ session('success') }}"></div>
    @endif

    <form action="{{ route('categories.list') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="search" class="form-control custom-select">
                    <option value="">Select Category</option>
                    @foreach($allCategories as $cat)
                        <option value="{{ $cat->name }}" {{ request('search') == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-control custom-select">
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

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped text-center">
            <thead>
                <tr>
                    <th>SL</th>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                       <td>
    <span class="badge badge-{{ $category->status === 'active' ? 'success' : 'secondary' }}" 
          style="background-color: {{ $category->status === 'active' ? '#28a745' : '#6c757d' }}; 
                 color: white;">
        {{ ucfirst($category->status) }}
    </span>
</td>
                        <td>
                            @if($category->image && $category->image !== 'no_image.jpg')
                                <img style="width:80px; height:80px; object-fit:cover;" src="{{ asset('image/category/' . $category->image) }}?t={{ time() }}" alt="{{ $category->name }}">
                            @else
                                <img style="width:80px; height:80px; object-fit:cover;" src="{{ asset('image/no_image.jpg') }}" alt="No Image">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if($category->products->count() == 0)
                                <form action="{{ route('categories.delete', $category->id) }}" method="POST" class="d-inline delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <button
                                    class="btn btn-secondary btn-sm"
                                    type="button"
                                    title="This category is already in use, you can't delete it."
                                    style="cursor: not-allowed; position: relative;"
                                    onmouseenter="showTooltip(this)"
                                    onmouseleave="hideTooltip(this)"
                                    onclick="showLockNotification(event)"
                                >
                                    <i class="fas fa-lock"></i>
                                    <span class="tooltip-text" style="
                                        visibility: hidden;
                                        background-color: black;
                                        color: #fff;
                                        text-align: center;
                                        border-radius: 4px;
                                        padding: 5px;
                                        position: absolute;
                                        z-index: 1;
                                        bottom: 125%;
                                        left: 50%;
                                        transform: translateX(-50%);
                                        white-space: nowrap;
                                        font-size: 12px;
                                    ">This category is already in use, you can't delete it.</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const successMessage = document.getElementById("success-message");
            if (successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage.getAttribute("data-message"),
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            }

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

        function showTooltip(btn) {
            const tooltip = btn.querySelector('.tooltip-text');
            tooltip.style.visibility = 'visible';
        }
        function hideTooltip(btn) {
            const tooltip = btn.querySelector('.tooltip-text');
            tooltip.style.visibility = 'hidden';
        }
        function showLockNotification(event) {
            event.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Cannot Delete',
                text: "This category is already in use, you can't delete it.",
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    </script>
    @endpush
@endsection
