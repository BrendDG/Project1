@extends('layouts.app')

@section('title', 'Nieuws - Rocket League Community')

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

    .nieuws-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .nieuws-card {
        background: #0f1220;
        border-radius: 8px;
        border: 1px solid #2a3150;
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .nieuws-card:hover {
        border-color: #3b82f6;
        background: #151b2e;
        transform: translateY(-5px);
    }

    .nieuws-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #1a1f35;
    }

    .nieuws-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .nieuws-date {
        color: #3b82f6;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .nieuws-title {
        font-size: 1.5rem;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    .nieuws-excerpt {
        color: #9095a0;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
    }

    .read-more {
        color: #3b82f6;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        background: #0f1220;
        border: 1px solid #2a3150;
        color: #c0c0c0;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .pagination .active {
        background: #3b82f6;
        color: #ffffff;
        border-color: #3b82f6;
    }

    .no-nieuws {
        text-align: center;
        padding: 4rem 2rem;
        color: #9095a0;
    }

    .no-nieuws h2 {
        font-size: 2rem;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .nieuws-grid {
            grid-template-columns: 1fr;
        }

        .page-header h1 {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>📰 Laatste Nieuws</h1>
    <p>Blijf op de hoogte van de nieuwste Rocket League updates en evenementen</p>
</div>

@if($nieuws->count() > 0)
    <div class="nieuws-grid">
        @foreach($nieuws as $item)
            <a href="{{ route('nieuws.show', $item->id) }}" class="nieuws-card">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="nieuws-image">
                @else
                    <div class="nieuws-image"></div>
                @endif

                <div class="nieuws-content">
                    <div class="nieuws-date">
                        {{ $item->published_at->format('d M Y') }}
                    </div>
                    <h2 class="nieuws-title">{{ $item->title }}</h2>
                    <p class="nieuws-excerpt">
                        {{ Str::limit(strip_tags($item->content), 150) }}
                    </p>
                    <span class="read-more">
                        Lees meer →
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination">
        @if ($nieuws->onFirstPage())
            <span>&laquo; Vorige</span>
        @else
            <a href="{{ $nieuws->previousPageUrl() }}">&laquo; Vorige</a>
        @endif

        @for ($i = 1; $i <= $nieuws->lastPage(); $i++)
            @if ($i == $nieuws->currentPage())
                <span class="active">{{ $i }}</span>
            @else
                <a href="{{ $nieuws->url($i) }}">{{ $i }}</a>
            @endif
        @endfor

        @if ($nieuws->hasMorePages())
            <a href="{{ $nieuws->nextPageUrl() }}">Volgende &raquo;</a>
        @else
            <span>Volgende &raquo;</span>
        @endif
    </div>
@else
    <div class="no-nieuws">
        <h2>Geen nieuws items gevonden</h2>
        <p>Er zijn momenteel nog geen nieuws items beschikbaar.</p>
    </div>
@endif
@endsection
