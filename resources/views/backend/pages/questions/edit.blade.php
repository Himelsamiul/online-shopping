@extends('backend.master')

@section('content')
<style>
    .container {
        max-width: 700px;
        margin: 40px auto 80px;
        background: #fff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        font-weight: 700;
        font-size: 2.4rem;
        color: #343a40;
        margin-bottom: 30px;
        text-align: center;
        letter-spacing: 1px;
        user-select: none;
    }

    

    /* Card */
    .card {
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        border: none;
        overflow: visible;
    }

    .card-header {
        background: #007bff;
        color: #fff;
        font-weight: 600;
        font-size: 1.2rem;
        padding: 20px 30px;
        user-select: none;
        border-radius: 12px 12px 0 0;
    }

    .card-body {
        padding: 30px 35px;
        font-size: 1rem;
        color: #555;
        position: relative;
    }

    /* Floating Label Container */
    .floating-label {
        position: relative;
        margin-bottom: 1.5rem;
    }

    /* Textarea */
    textarea.form-control {
        width: 100%;
        padding: 20px 15px 10px;
        border-radius: 10px;
        border: 1.8px solid #ced4da;
        font-size: 1.1rem;
        font-family: inherit;
        line-height: 1.5;
        background: #fff;
        resize: vertical;
        min-height: 140px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        transition: border-color 0.4s ease, box-shadow 0.4s ease;
    }
    textarea.form-control:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 10px rgba(106, 17, 203, 0.7);
        outline: none;
        background: #fefaff;
    }

    /* Label */
    .floating-label label {
        position: absolute;
        top: 20px;
        left: 15px;
        color: #6c757d;
        font-size: 1.1rem;
        font-weight: 500;
        pointer-events: none;
        background: #fff;
        padding: 0 8px;
        transition: all 0.3s ease;
        border-radius: 4px;
        user-select: none;
    }

    /* When textarea focused or has text */
    textarea.form-control:focus + label,
    textarea.form-control:not(:placeholder-shown) + label {
        top: -8px;
        left: 12px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #6a11cb;
        box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Character Count */
    .char-count {
        margin-top: 6px;
        font-size: 0.9rem;
        color: #6a11cb;
        user-select: none;
        text-align: right;
        font-style: italic;
        font-weight: 600;
    }

    /* Buttons */
    button.btn-success {
        background-color: #6a11cb;
        border: none;
        padding: 14px 30px;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(106, 17, 203, 0.7);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        user-select: none;
    }
    button.btn-success:disabled {
        background-color: #c8b9e9;
        box-shadow: none;
        cursor: not-allowed;
    }
    button.btn-success:hover:not(:disabled) {
        background-color: #4b0fa1;
        box-shadow: 0 8px 25px rgba(75, 15, 161, 0.9);
    }

    a.btn-secondary {
        margin-left: 15px;
        background-color: #6c757d;
        border: none;
        padding: 14px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.5);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        user-select: none;
        text-decoration: none;
        color: #fff;
    }
    a.btn-secondary:hover {
        background-color: #5a6268;
        box-shadow: 0 6px 20px rgba(90, 98, 104, 0.8);
        color: #fff;
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .container {
            padding: 20px;
            margin: 20px auto 60px;
        }
        button.btn-success, a.btn-secondary {
            width: 100%;
            margin: 10px 0 0 0;
            display: block;
            text-align: center;
        }
        a.btn-secondary {
            margin-left: 0;
        }
    }
</style>

<div class="container mt-4" id="answer-container">
    <h2>Answer Question</h2>

    <!-- Question styled box -->
    

    <div class="card">
        <div class="card-header">
            <strong>Question from:</strong> {{ $question->customer_name }}
        </div>
        <div class="card-body">
            <form id="answerForm" action="{{ route('admin.questions.update', $question->id) }}" method="POST" novalidate>
                @csrf
                <div class="floating-label">
                    <textarea id="answer" name="answer" class="form-control" rows="5" placeholder=" " required>{{ old('answer', $question->answer) }}</textarea>
                    <label for="answer">Your Answer</label>
                    <div class="char-count" id="charCount">0 characters</div>
                </div>
                <button type="submit" id="submitBtn" class="btn btn-success" disabled>Save Answer</button>
                <a href="{{ route('admin.questions.answer') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Scroll smoothly to form container
        document.getElementById('answer-container').scrollIntoView({ behavior: 'smooth' });

        const textarea = document.getElementById('answer');
        const charCount = document.getElementById('charCount');
        const submitBtn = document.getElementById('submitBtn');

        // Function to update character count and enable/disable submit button
        function updateCharCount() {
            const length = textarea.value.trim().length;
            charCount.textContent = length + (length === 1 ? ' character' : ' characters');
            submitBtn.disabled = length === 0;
        }

        // Initial update
        updateCharCount();

        // Auto-focus textarea on load
        textarea.focus();

        // Update on input
        textarea.addEventListener('input', updateCharCount);

        // Confirmation on submit
        const form = document.getElementById('answerForm');
        form.addEventListener('submit', function (e) {
            if (!confirm('Are you sure you want to save this answer?')) {
                e.preventDefault();
            }
        });

        // Keyboard shortcut Ctrl+Enter to submit
        textarea.addEventListener('keydown', function (e) {
            if (e.ctrlKey && e.key === 'Enter') {
                if (!submitBtn.disabled) {
                    form.requestSubmit();
                }
            }
        });
    });
</script>
@endsection
