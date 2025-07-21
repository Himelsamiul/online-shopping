@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h2>Customer Questions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                <td>{!! $q->answer ? e(Str::limit($q->answer, 50)) : '<em>Not answered</em>' !!}</td>
                <td>
                    <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn btn-sm btn-primary">
                        {{ $q->answer ? 'Edit' : 'Answer' }}
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No questions submitted yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $questions->links() }}
</div>
@endsection
