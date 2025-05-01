@extends('backend.master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary"><i class="fas fa-envelope me-2"></i>Contact Us Messages</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow rounded">
            <thead class="bg-primary text-white">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $key => $contact)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>0{{ $contact->phone }}</td>
                        <td>{{ Str::limit($contact->message, 60) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-button" data-id="{{ $contact->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <!-- Hidden form for deletion -->
                            <form id="delete-form-{{ $contact->id }}" action="{{ route('contact.destroy', $contact->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const contactId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this message?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + contactId).submit();
                }
            });
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            timer: 3000
        });
    @endif
</script>
@endsection


