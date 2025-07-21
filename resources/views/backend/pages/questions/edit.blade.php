@extends('backend.master')

@section('content')
<div class="container mt-4">
    <h2>Answer Question</h2>

    <div class="card">
        <div class="card-header">
            <strong>Question from:</strong> {{ $question->customer_name }}
        </div>
        <div class="card-body">
            <p><strong>Question:</strong> {{ $question->question }}</p>

            <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="answer" class="form-label">Your Answer</label>
                    <textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $question->answer) }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Save Answer</button>
                <a href="{{ route('admin.questions.answer') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
