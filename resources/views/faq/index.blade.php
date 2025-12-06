@extends('layouts.app')

@section('title', 'FAQ - Rocket League Community')

@section('styles')
<style>
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-header h1 {
        font-size: 3rem;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        font-size: 1.2rem;
        color: #a0aec0;
    }

    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .faq-category {
        margin-bottom: 3rem;
    }

    .category-title {
        font-size: 2rem;
        color: #3b82f6;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #2a3150;
    }

    .faq-item {
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        border-color: #3b82f6;
    }

    .faq-question {
        padding: 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: #ffffff;
        user-select: none;
    }

    .faq-question:hover {
        background: #151b2e;
    }

    .faq-toggle {
        font-size: 1.5rem;
        color: #3b82f6;
        transition: transform 0.3s ease;
    }

    .faq-toggle.open {
        transform: rotate(180deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        border-top: 1px solid transparent;
    }

    .faq-answer.open {
        max-height: 1000px;
        border-top-color: #2a3150;
    }

    .faq-answer-content {
        padding: 1.5rem;
        color: #9095a0;
        line-height: 1.8;
    }

    .no-faq {
        text-align: center;
        padding: 4rem 2rem;
        color: #9095a0;
    }

    .no-faq h2 {
        font-size: 2rem;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .category-title {
            font-size: 1.5rem;
        }

        .faq-question {
            padding: 1rem;
            font-size: 0.95rem;
        }

        .faq-answer-content {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>Veelgestelde Vragen</h1>
    <p>Vind antwoorden op de meest gestelde vragen over Rocket League</p>
</div>

<div class="faq-container">
    @if($categories->count() > 0)
        @foreach($categories as $category)
            <div class="faq-category">
                <h2 class="category-title">{{ $category->name }}</h2>

                @if($category->faqItems->count() > 0)
                    @foreach($category->faqItems as $item)
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFaq({{ $item->id }})">
                                <span>{{ $item->question }}</span>
                                <span class="faq-toggle" id="toggle-{{ $item->id }}">▼</span>
                            </div>
                            <div class="faq-answer" id="answer-{{ $item->id }}">
                                <div class="faq-answer-content">
                                    {{ $item->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="color: #9095a0;">Geen vragen in deze categorie.</p>
                @endif
            </div>
        @endforeach
    @else
        <div class="no-faq">
            <h2>Geen FAQ items beschikbaar</h2>
            <p>Er zijn momenteel nog geen veelgestelde vragen beschikbaar.</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function toggleFaq(id) {
        const answer = document.getElementById('answer-' + id);
        const toggle = document.getElementById('toggle-' + id);

        answer.classList.toggle('open');
        toggle.classList.toggle('open');
    }
</script>
@endsection
