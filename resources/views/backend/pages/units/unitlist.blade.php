@extends('backend.master')

@section('content')
<div class="container">
    <h1>Units List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('units.create') }}" class="btn btn-primary mb-3">Add New Unit</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th> <!-- New Actions Column -->
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
                <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <!-- Show Button -->
                        <a href="{{ route('units.show', $unit->id) }}" class="btn btn-info btn-sm">Show</a>

                        <!-- Edit Button -->
                        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete Button (With SweetAlert) -->
                        <form id="deleteForm_{{ $unit->id }}" action="{{ route('units.delete', $unit->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $unit->id }})">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $units->links() }}
    </div>
</div>

{{-- Include SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Success alert for unit update
    @if(session('success'))
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    @endif

    // Delete confirmation with SweetAlert
    function confirmDelete(unitId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this unit!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm_' + unitId).submit(); // Submit the form if confirmed
            }
        });
    }
</script>

@endsection
