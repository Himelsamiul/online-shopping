@extends('backend.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div class="container">
    <h1>Units List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('units.create') }}" class="btn btn-primary mb-3">Add New Unit</a>

    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width:50px; text-align:center;">SL</th>
                <th>Name</th>
                <th>Status</th>
                <th style="width:140px; text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
                <tr>
                    <td style="text-align:center;">{{ $units->firstItem() + $loop->index }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->status ? 'Active' : 'Inactive' }}</td>
                    <td style="text-align:center;">
                        <!-- Show Button -->
                        <a href="{{ route('units.show', $unit->id) }}" class="btn btn-info btn-sm" title="Show Unit">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm" title="Edit Unit">
                            <i class="fas fa-edit"></i>
                        </a>

                        @if($unit->products->count() == 0)
                            <!-- Delete Button -->
                            <form id="deleteForm_{{ $unit->id }}" action="{{ route('units.delete', $unit->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" title="Delete Unit" onclick="confirmDelete({{ $unit->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @else
                            <!-- Lock Button with Tooltip -->
                            <div class="lock-btn-wrapper d-inline-block" style="position: relative; overflow: visible;">
                                <button 
                                    class="btn btn-secondary btn-sm lock-btn" 
                                    type="button"
                                    aria-describedby="lock-tooltip-{{ $unit->id }}"
                                    title="Unit in use and cannot be deleted"
                                >
                                    <i class="fas fa-lock"></i>
                                </button>
                                <div id="lock-tooltip-{{ $unit->id }}" class="lock-tooltip" role="tooltip">
                                    You cannot delete this unit because it is already in use.
                                </div>
                            </div>
                        @endif
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

<style>
    /* Limit container width and center it */
    .container {
        max-width: 850px;
        margin: 0 auto;
    }

    /* Make the table full width within container but max width limited */
    table.table {
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
        table-layout: fixed;
    }

    /* Tooltip styling */
    .lock-tooltip {
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%) scale(0.9);
        background-color: rgb(56, 58, 184);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        white-space: normal; /* allow line breaks */
        font-size: 13px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease, transform 0.3s ease;
        z-index: 1050; /* higher z-index */
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        max-width: 280px; /* increased max-width */
        text-align: center;
        word-wrap: break-word; /* wrap long words */
    }

    .lock-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: rgb(56, 58, 184) transparent transparent transparent;
    }

    .lock-tooltip.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(-50%) scale(1);
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    /* Ensure parent wrapper allows overflow for tooltip */
    .lock-btn-wrapper {
        position: relative;
        overflow: visible;
    }
</style>

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
                document.getElementById('deleteForm_' + unitId).submit();
            }
        });
    }

    // Lock tooltip functionality
    document.addEventListener('DOMContentLoaded', function () {
        const lockButtons = document.querySelectorAll('.lock-btn');

        lockButtons.forEach(button => {
            const tooltip = button.nextElementSibling;

            button.addEventListener('mouseenter', function () {
                document.querySelectorAll('.lock-tooltip.show').forEach(t => t.classList.remove('show'));
                tooltip.classList.add('show');
            });

            button.addEventListener('mouseleave', function () {
                setTimeout(() => {
                    if (!tooltip.matches(':hover')) {
                        tooltip.classList.remove('show');
                    }
                }, 100);
            });

            tooltip.addEventListener('mouseenter', function () {
                tooltip.classList.add('show');
            });

            tooltip.addEventListener('mouseleave', function () {
                tooltip.classList.remove('show');
            });
        });
    });
</script>
@endsection
