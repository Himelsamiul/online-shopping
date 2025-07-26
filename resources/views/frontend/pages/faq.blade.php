@extends('frontend.master')

@section('title', 'Frequently Asked Questions')

@section('content')
<style>
    .faq-section {
        background: #f9f9f9;
        padding: 60px 0;
    }
    .faq-heading {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 30px;
    }
    .accordion-button::after {
        transition: transform 0.3s ease;
    }
    .accordion-button:not(.collapsed)::after {
        transform: rotate(180deg);
    }
    .accordion-item {
        border: none;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .accordion-button {
        font-weight: 500;
        color: #333;
        background-color: #fff;
    }
    .accordion-body {
        background-color: #fcfcfc;
        color: #555;
    }
    .form-section {
        background: #ffffff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
</style>

<div class="container faq-section">
    <div class="text-center mb-5">
        <h2 class="faq-heading">📌 Frequently Asked Questions</h2>
        <p class="text-muted">Find answers to common questions. Still have something to ask? Submit below!</p>
    </div>

    {{-- Default FAQ --}}
    <div class="accordion" id="faqAccordion">
        @php
        $faqs = [
            ['question' => '📦 What is your return policy?', 'answer' => 'You can return products within 7 days of purchase with the receipt.'],
            ['question' => '🌍 Do you offer international shipping?', 'answer' => 'Yes, we ship to select countries worldwide.'],
            ['question' => '📫 How can I track my order?', 'answer' => 'A tracking link will be emailed to you after dispatch.'],
            ['question' => '💳 What payment methods are accepted?', 'answer' => 'We accept Visa, MasterCard, bKash, Nagad, Rocket, and COD.'],
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

    {{-- Submit Question --}}
    <hr class="my-5">
    <div class="form-section">
        <h3 class="mb-4">❓ Have a Question? Ask Here:</h3>

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
            <button type="submit" class="btn btn-success">➤ Submit Question</button>
        </form>
    </div>

    {{-- Answered Questions --}}
    <hr class="my-5">
    <h3 class="mb-4">✅ Customer Asked & We Answered</h3>

    <div class="accordion" id="answeredAccordion">
        @forelse($answeredQuestions as $index => $q)
        <div class="accordion-item">
            <h2 class="accordion-header" id="answeredHeading{{ $index }}">
                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                    data-bs-toggle="collapse" data-bs-target="#answeredCollapse{{ $index }}"
                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="answeredCollapse{{ $index }}">
                    🧑 {{ $q->customer_name }} asked: "{{ $q->question }}"
                </button>
            </h2>
            <div id="answeredCollapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                aria-labelledby="answeredHeading{{ $index }}" data-bs-parent="#answeredAccordion">
                <div class="accordion-body">
                    💬 <strong>Answer:</strong> {{ $q->answer }}
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info">There are no answered customer questions yet. Be the first to ask!</div>
        @endforelse
    </div>
</div>
@endsection
