@extends('layouts.app')

@section('title', $nieuws->title . ' - Rocket League Community')

@section('styles')
<style>
    .nieuws-detail {
        max-width: 900px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #3b82f6;
        text-decoration: none;
        margin-bottom: 2rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2563eb;
    }

    .nieuws-header {
        margin-bottom: 2rem;
    }

    .nieuws-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .nieuws-date {
        color: #3b82f6;
        font-weight: 500;
    }

    .nieuws-header h1 {
        font-size: 2.5rem;
        color: #ffffff;
        line-height: 1.2;
    }

    .nieuws-image-container {
        width: 100%;
        margin: 2rem 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #2a3150;
    }

    .nieuws-image-large {
        width: 100%;
        height: auto;
        display: block;
    }

    .nieuws-body {
        background: #0f1220;
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
        line-height: 1.8;
        color: #e0e0e0;
    }

    .nieuws-body p {
        margin-bottom: 1rem;
    }

    .nieuws-body h2 {
        color: #ffffff;
        font-size: 1.8rem;
        margin: 2rem 0 1rem;
    }

    .nieuws-body h3 {
        color: #ffffff;
        font-size: 1.4rem;
        margin: 1.5rem 0 0.75rem;
    }

    .nieuws-body ul,
    .nieuws-body ol {
        margin-left: 2rem;
        margin-bottom: 1rem;
    }

    .nieuws-body li {
        margin-bottom: 0.5rem;
    }

    .nieuws-footer {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #2a3150;
        text-align: center;
    }

    @media (max-width: 768px) {
        .nieuws-header h1 {
            font-size: 1.8rem;
        }

        .nieuws-body {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="nieuws-detail">
    <a href="{{ route('nieuws.index') }}" class="back-link">
        ← Terug naar nieuws overzicht
    </a>

    <article>
        <header class="nieuws-header">
            <div class="nieuws-meta">
                <span class="nieuws-date">
                    {{ $nieuws->published_at->format('d F Y') }}
                </span>
                <span>•</span>
                <span>{{ $nieuws->published_at->diffForHumans() }}</span>
            </div>
            <h1>{{ $nieuws->title }}</h1>
        </header>

        @if($nieuws->image)
            <div class="nieuws-image-container">
                <img src="{{ asset('storage/' . $nieuws->image) }}" alt="{{ $nieuws->title }}" class="nieuws-image-large">
            </div>
        @endif

        <div class="nieuws-body">
            {!! nl2br(e($nieuws->content)) !!}
        </div>

        <footer class="nieuws-footer">
            <a href="{{ route('nieuws.index') }}" class="btn btn-secondary">
                Terug naar overzicht
            </a>
        </footer>
    </article>
</div>
@endsection
