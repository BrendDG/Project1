@extends('layouts.app')

@section('title', e($user->display_name) . ' - Speler Profiel')

@section('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #ffffff;
        text-decoration: none;
        margin-bottom: 2rem;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        background: #3b82f6;
        border-radius: 8px;
    }

    .back-link:hover {
        background: #2563eb;
    }

    .back-link svg {
        width: 20px;
        height: 20px;
    }

    .profile-header {
        background: #0f1220;
        border: 2px solid #2a3150;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #4a9eff;
    }

    .profile-info h1 {
        font-size: 2rem;
        color: #e0e0e0;
        margin-bottom: 0.5rem;
    }

    .profile-username {
        font-size: 1.125rem;
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .profile-bio {
        color: #c0c0c0;
        line-height: 1.6;
    }

    .ranks-section h2 {
        font-size: 1.75rem;
        color: #4a9eff;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .ranks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .rank-card {
        background: #0f1220;
        border: 2px solid #2a3150;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .rank-card:hover {
        border-color: #4a9eff;
        background: #151b2e;
        transform: translateY(-3px);
    }

    .rank-card.unranked {
        opacity: 0.6;
    }

    .game-mode-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #e0e0e0;
        margin-bottom: 1rem;
    }

    .rank-display {
        margin: 1.5rem 0;
    }

    .rank-image {
        width: 120px;
        height: 120px;
        object-fit: contain;
        margin: 0 auto 1rem;
        display: block;
    }

    .rank-name {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4a9eff;
        margin-bottom: 0.5rem;
    }

    .rank-division {
        font-size: 1rem;
        color: #9095a0;
        margin-bottom: 0.75rem;
    }

    .rank-mmr {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #1a1f35;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #c0c0c0;
    }

    .rank-mmr strong {
        color: #4a9eff;
        font-size: 1.125rem;
    }

    .unranked-text {
        font-size: 1.25rem;
        color: #6b7280;
        padding: 2rem 0;
    }

    .stats-summary {
        background: #0f1220;
        border: 2px solid #2a3150;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .stats-summary h3 {
        color: #4a9eff;
        margin-bottom: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .stat-item {
        padding: 1rem;
        background: #1a1f35;
        border-radius: 8px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4a9eff;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #9095a0;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .ranks-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<a href="{{ route('players.index') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
    </svg>
    Terug naar spelers
</a>

{{-- Profile Header --}}
<div class="profile-header">
    <img
        src="{{ $user->profile_photo_url }}"
        alt="{{ e($user->display_name) }}"
        class="profile-avatar"
        onerror="this.src='{{ asset('default-avatar.png') }}'"
    >
    <div class="profile-info">
        <h1>{{ e($user->display_name) }}</h1>
        @if($user->username)
            <div class="profile-username">@\{{ e($user->username) }}</div>
        @endif
        @if($user->about_me)
            <div class="profile-bio">{{ e($user->about_me) }}</div>
        @endif
    </div>
</div>

{{-- Stats Summary --}}
@php
    $rankedModes = collect($gameModes)->filter(fn($mode) => $mode['mmr'] !== null);
    $avgMMR = $rankedModes->count() > 0 ? round($rankedModes->avg('mmr')) : 0;
    $highestMMR = $rankedModes->max('mmr') ?? 0;
@endphp

@if($rankedModes->count() > 0)
    <div class="stats-summary">
        <h3>Statistieken Overzicht</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $rankedModes->count() }}</div>
                <div class="stat-label">Gerankte Modi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $avgMMR }}</div>
                <div class="stat-label">Gemiddelde MMR</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $highestMMR }}</div>
                <div class="stat-label">Hoogste MMR</div>
            </div>
            @php
                $highestMode = $rankedModes->sortByDesc('mmr')->first();
            @endphp
            <div class="stat-item">
                <div class="stat-value">{{ e($highestMode['rank']) }}</div>
                <div class="stat-label">Hoogste Rank</div>
            </div>
        </div>
    </div>
@endif

{{-- Ranks Section --}}
<div class="ranks-section">
    <h2>Rocket League Ranks</h2>
    <div class="ranks-grid">
        @foreach($gameModes as $mode)
            <div class="rank-card {{ $mode['mmr'] === null ? 'unranked' : '' }}">
                <div class="game-mode-name">{{ e($mode['name']) }}</div>

                @if($mode['mmr'] !== null)
                    <div class="rank-display">
                        <img
                            src="{{ $mode['image'] }}"
                            alt="{{ e($mode['rank']) }}"
                            class="rank-image"
                            onerror="this.src='{{ asset('unranked.png') }}'"
                        >
                        <div class="rank-name">{{ e($mode['rank']) }}</div>
                        @if($mode['division'])
                            <div class="rank-division">{{ e($mode['division']) }}</div>
                        @endif
                        <div class="rank-mmr">
                            MMR: <strong>{{ $mode['mmr'] }}</strong>
                        </div>
                    </div>
                @else
                    <div class="rank-display">
                        <img
                            src="{{ asset('unranked.png') }}"
                            alt="Unranked"
                            class="rank-image"
                        >
                        <div class="unranked-text">Unranked</div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
