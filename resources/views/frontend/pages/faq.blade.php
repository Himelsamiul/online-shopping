@extends('frontend.master')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Frequently Asked Questions</h2>

    {{-- Default FAQ Section --}}
    <div class="accordion" id="faqAccordion">
        @php
        $faqs = [
        ['question' => 'What is your return policy?', 'answer' => 'You can return products within 7 days of purchase.'],
        ['question' => 'Do you offer international shipping?', 'answer' => 'Yes, we ship to select countries.'],
        ['question' => 'How can I track my order?', 'answer' => 'Use the tracking link sent to your email after shipping.'],
        ['question' => 'What payment methods are accepted?', 'answer' => 'We accept Visa, MasterCard, bKash, Nagad, and Rocket.']
        ];
        @endphp

        @foreach($faqs as $index => $faq)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $index }}">
                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                    {{ $faq['question'] }}
                </button>
            </h2>
            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    {{ $faq['answer'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Question Submission --}}
    <hr class="my-5">
    <h2 class="mb-4">Have a Question? Ask Here:</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('faq.store.question') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_name" class="form-label">Your Name</label>
            <input type="text" class="form-control" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Your Question</label>
            <textarea name="question" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Question</button>
    </form>

    {{-- Answered Questions --}}
    <hr class="my-5">
    <h2 class="mb-4">Answered Customer Questions</h2>

    <div class="accordion" id="answeredAccordion">
        @forelse($answeredQuestions as $index => $question)
        <div class="accordion-item">
            <h2 class="accordion-header" id="answeredHeading{{ $index }}">
                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#answeredCollapse{{ $index }}"
                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="answeredCollapse{{ $index }}">
                    {{ $question->customer_name }} asked: {{ $question->question }}
                </button>
            </h2>
            <div id="answeredCollapse{{ $index }}"
                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                aria-labelledby="answeredHeading{{ $index }}" data-bs-parent="#answeredAccordion">
                <div class="accordion-body">
                    {{ $question->answer }}
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info">No answered questions yet.</div>
        @endforelse
    </div>
</div>
@endsection