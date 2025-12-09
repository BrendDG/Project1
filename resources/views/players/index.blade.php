@extends('layouts.app')

@section('title', 'Spelers Zoeken - Rocket League Tracker')

@section('styles')
<style>
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: #4a9eff;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        font-size: 1.125rem;
        color: #9095a0;
    }

    .players-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .player-card {
        background: #0f1220;
        border: 2px solid #2a3150;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .player-card:hover {
        border-color: #4a9eff;
        background: #151b2e;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(74, 158, 255, 0.2);
    }

    .player-card-link {
        text-decoration: none;
        color: inherit;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .player-card-actions {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #2a3150;
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-message {
        background: #3b82f6;
        color: white;
    }

    .btn-message:hover {
        background: #2563eb;
    }

    .btn-view {
        background: transparent;
        color: #4a9eff;
        border: 1px solid #4a9eff;
    }

    .btn-view:hover {
        background: #4a9eff;
        color: white;
    }

    .player-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #2a3150;
        margin: 0 auto 1rem;
        display: block;
    }

    .player-card:hover .player-avatar {
        border-color: #4a9eff;
    }

    .player-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #e0e0e0;
        margin-bottom: 0.5rem;
    }

    .player-username {
        font-size: 0.875rem;
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .player-ranks {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .rank-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background: #1a1f35;
        border-radius: 6px;
        font-size: 0.75rem;
        color: #c0c0c0;
    }

    .rank-badge img {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        background: #0f1220;
        border: 2px dashed #2a3150;
        border-radius: 12px;
    }

    .no-results svg {
        width: 64px;
        height: 64px;
        color: #6b7280;
        margin: 0 auto 1rem;
        display: block;
    }

    .no-results h3 {
        font-size: 1.5rem;
        color: #e0e0e0;
        margin-bottom: 0.5rem;
    }

    .no-results p {
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        background: #0f1220;
        border: 2px solid #2a3150;
        border-radius: 6px;
        color: #e0e0e0;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        border-color: #4a9eff;
        background: #151b2e;
    }

    .pagination .active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .results-info {
        text-align: center;
        color: #9095a0;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>Spelers Zoeken</h1>
    <p>Zoek spelers op username en bekijk hun Rocket League ranks</p>
</div>

{{-- Search Component with CSRF protection --}}
<x-search-bar
    :search="$search"
    placeholder="Zoek op username of naam..."
    :action="route('players.index')"
/>

{{-- Alert Component for validation errors --}}
@if($errors->any())
    <x-alert type="error" :message="$errors->first()" />
@endif

{{-- Results Info --}}
@if($search)
    <div class="results-info">
        Zoekresultaten voor "<strong>{{ e($search) }}</strong>" - {{ $players->total() }} {{ $players->total() === 1 ? 'speler' : 'spelers' }} gevonden
    </div>
@else
    <div class="results-info">
        Totaal {{ $players->total() }} {{ $players->total() === 1 ? 'speler' : 'spelers' }}
    </div>
@endif

{{-- Players Grid --}}
@if($players->count() > 0)
    <div class="players-grid">
        @foreach($players as $player)
            <div class="player-card">
                <a href="{{ route('players.show', $player) }}" class="player-card-link">
                    <img
                        src="{{ $player->profile_photo_url }}"
                        alt="{{ e($player->display_name) }}"
                        class="player-avatar"
                        onerror="this.src='{{ asset('default-avatar.png') }}'"
                    >
                    <div class="player-name">{{ e($player->display_name) }}</div>
                    @if($player->username)
                        <div class="player-username">@\{{ e($player->username) }}</div>
                    @endif

                    {{-- Show top 3 ranks --}}
                    <div class="player-ranks">
                        @php
                            $rankedModes = collect([
                                ['mmr' => $player->mmr_1v1, 'label' => '1v1'],
                                ['mmr' => $player->mmr_2v2, 'label' => '2v2'],
                                ['mmr' => $player->mmr_3v3, 'label' => '3v3'],
                            ])
                            ->filter(fn($mode) => $mode['mmr'] !== null)
                            ->sortByDesc('mmr')
                            ->take(3);
                        @endphp

                        @if($rankedModes->count() > 0)
                            @foreach($rankedModes as $mode)
                                <span class="rank-badge">
                                    <img src="{{ $player->getRankImage($mode['mmr']) }}" alt="Rank">
                                    {{ $mode['label'] }}
                                </span>
                            @endforeach
                        @else
                            <span class="rank-badge">Unranked</span>
                        @endif
                    </div>
                </a>

                @auth
                    @if(auth()->id() !== $player->id)
                        <div class="player-card-actions">
                            <a href="{{ route('messages.create', ['to' => $player->id]) }}" class="btn-sm btn-message">
                                Stuur bericht
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($players->hasPages())
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if($players->onFirstPage())
                <span class="disabled">&laquo; Vorige</span>
            @else
                <a href="{{ $players->previousPageUrl() }}">&laquo; Vorige</a>
            @endif

            {{-- Page Numbers --}}
            @foreach($players->getUrlRange(1, $players->lastPage()) as $page => $url)
                @if($page == $players->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if($players->hasMorePages())
                <a href="{{ $players->nextPageUrl() }}">Volgende &raquo;</a>
            @else
                <span class="disabled">Volgende &raquo;</span>
            @endif
        </div>
    @endif
@else
    <div class="no-results">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
        </svg>
        <h3>Geen spelers gevonden</h3>
        <p>
            @if($search)
                Er zijn geen spelers gevonden die overeenkomen met "{{ e($search) }}"
            @else
                Er zijn nog geen spelers geregistreerd
            @endif
        </p>
        @if($search)
            <a href="{{ route('players.index') }}" class="btn btn-primary">Bekijk alle spelers</a>
        @endif
    </div>
@endif
@endsection
