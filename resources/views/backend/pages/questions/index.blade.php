@extends('backend.master')

@section('content')
<style>
    /* Container Styling */
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Heading */
    h2 {
        font-weight: 700;
        font-size: 2.4rem;
        color: #343a40;
        margin-bottom: 30px;
        text-align: center;
        letter-spacing: 1px;
        text-transform: uppercase;
        user-select: none;
    }

    /* Success alert */
    .alert-success {
        background: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 8px;
        padding: 15px 20px;
        box-shadow: 0 0 10px rgba(21, 87, 36, 0.3);
        transition: all 0.3s ease;
        margin-bottom: 25px;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    thead tr {
        background: #007bff;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 0.95rem;
        border-radius: 12px;
    }

    thead th {
        padding: 15px 20px;
        user-select: none;
    }

    tbody tr {
        background: #f9f9f9;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        cursor: pointer;
        border-radius: 10px;
    }

    tbody tr:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        background: #e9f2ff;
    }

    tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        color: #555;
        font-size: 1rem;
        border-bottom: none !important;
    }

    /* For no questions */
    tbody tr.empty-row td {
        text-align: center;
        font-style: italic;
        color: #888;
        font-size: 1.1rem;
    }

    /* Answer preview styling */
    .answer-preview {
        max-width: 350px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-style: italic;
        color: #777;
    }

    /* Action buttons */
    .btn-primary {
        background: #007bff;
        border: none;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 6px;
        transition: background 0.3s ease;
        user-select: none;
        box-shadow: 0 3px 6px rgba(0,123,255,0.4);
    }
    .btn-primary:hover {
        background: #0056b3;
        box-shadow: 0 5px 15px rgba(0,86,179,0.7);
        text-decoration: none;
    }

    /* Pagination style */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 20px 0 0 0;
        list-style: none;
        user-select: none;
    }
    .pagination li {
        margin: 0 6px;
    }
    .pagination li a, .pagination li span {
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #007bff;
        color: #007bff;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }
    .pagination li.active span, 
    .pagination li a:hover {
        background: #007bff;
        color: white;
        box-shadow: 0 3px 8px rgba(0,123,255,0.6);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }
        tbody td, thead th {
            padding: 10px 12px;
            font-size: 0.9rem;
        }
        h2 {
            font-size: 1.8rem;
        }
        .answer-preview {
            max-width: 150px;
        }
    }
</style>

<div class="container mt-4">
    <h2>Customer Questions</h2>

    @if(session('success'))
        <div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $q)
            <tr>
                <td>{{ $q->id }}</td>
                <td>{{ $q->customer_name }}</td>
                <td>{{ $q->question }}</td>
                <td class="answer-preview">{!! $q->answer ? e(Str::limit($q->answer, 50)) : '<em>Not answered</em>' !!}</td>
                <td>
                    <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn btn-primary">
                        {{ $q->answer ? 'Edit' : 'Answer' }}
                    </a>
                </td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="5">No questions submitted yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $questions->links() }}
</div>

<script>
    // Auto-hide success alert after 4 seconds
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('successAlert');
        if(successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transition = 'opacity 0.8s ease';
                setTimeout(() => successAlert.remove(), 800);
            }, 4000);
        }
    });
</script>

@endsection
