@extends('layouts.app')

@section('title', 'Toernooien - Rocket League Community')

@section('styles')
<style>
    .tournaments-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 40px;
    }

    .tournaments-hero h1 {
        color: #fff;
        font-size: 48px;
        margin-bottom: 15px;
    }

    .tournaments-hero p {
        color: #e0e0e0;
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
    }

    .filters-section {
        background: #1a1f35;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 40px;
    }

    .filters-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        color: #9095a0;
        font-size: 14px;
        font-weight: 500;
    }

    .filter-group select {
        padding: 12px 16px;
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 6px;
        color: #e0e0e0;
        font-size: 14px;
        cursor: pointer;
        min-width: 200px;
    }

    .filter-group select:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .tournaments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .tournament-card {
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .tournament-card:hover {
        transform: translateY(-5px);
        border-color: #3b82f6;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .tournament-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        position: relative;
    }

    .tournament-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .tournament-status {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-upcoming {
        background: #10b981;
        color: #fff;
    }

    .status-ongoing {
        background: #f59e0b;
        color: #fff;
    }

    .status-completed {
        background: #6b7280;
        color: #fff;
    }

    .status-cancelled {
        background: #ef4444;
        color: #fff;
    }

    .tournament-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .tournament-content h3 {
        color: #fff;
        font-size: 22px;
        margin-bottom: 12px;
    }

    .tournament-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 15px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #9095a0;
        font-size: 14px;
    }

    .meta-icon {
        font-size: 16px;
    }

    .tournament-description {
        color: #c0c0c0;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }

    .tournament-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #2a3150;
    }

    .participants-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #9095a0;
        font-size: 14px;
    }

    .game-mode-badge {
        padding: 6px 12px;
        background: #3b82f6;
        color: #fff;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #1a1f35;
        border-radius: 12px;
    }

    .empty-state-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #fff;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .empty-state p {
        color: #9095a0;
        font-size: 16px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination a,
    .pagination span {
        padding: 10px 16px;
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 6px;
        color: #e0e0e0;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    .pagination .active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: #fff;
    }

    @media (max-width: 768px) {
        .tournaments-hero h1 {
            font-size: 32px;
        }

        .tournaments-grid {
            grid-template-columns: 1fr;
        }

        .filters-row {
            flex-direction: column;
        }

        .filter-group select {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="tournaments-hero">
    <h1>🏆 Toernooien</h1>
    <p>Doe mee aan spannende Rocket League toernooien en bewijs dat jij de beste bent!</p>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="filters-section">
        <form method="GET" action="{{ route('tournaments.index') }}" id="filterForm">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="filter">Status Filter</label>
                    <select name="filter" id="filter" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Alle Toernooien</option>
                        <option value="upcoming" {{ $filter === 'upcoming' ? 'selected' : '' }}>Binnenkort</option>
                        @auth
                            <option value="my-tournaments" {{ $filter === 'my-tournaments' ? 'selected' : '' }}>Mijn Toernooien</option>
                        @endauth
                    </select>
                </div>

                <div class="filter-group">
                    <label for="game_mode">Game Mode</label>
                    <select name="game_mode" id="game_mode" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ $gameMode === 'all' ? 'selected' : '' }}>Alle Modes</option>
                        <option value="1v1" {{ $gameMode === '1v1' ? 'selected' : '' }}>1v1 Duel</option>
                        <option value="2v2" {{ $gameMode === '2v2' ? 'selected' : '' }}>2v2 Doubles</option>
                        <option value="3v3" {{ $gameMode === '3v3' ? 'selected' : '' }}>3v3 Standard</option>
                        <option value="hoops" {{ $gameMode === 'hoops' ? 'selected' : '' }}>Hoops</option>
                        <option value="rumble" {{ $gameMode === 'rumble' ? 'selected' : '' }}>Rumble</option>
                        <option value="dropshot" {{ $gameMode === 'dropshot' ? 'selected' : '' }}>Dropshot</option>
                        <option value="snowday" {{ $gameMode === 'snowday' ? 'selected' : '' }}>Snow Day</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    @if($tournaments->count() > 0)
        <div class="tournaments-grid">
            @foreach($tournaments as $tournament)
                <a href="{{ route('tournaments.show', $tournament) }}" class="tournament-card">
                    <div class="tournament-image">
                        @if($tournament->image)
                            <img src="{{ asset($tournament->image) }}" alt="{{ $tournament->name }}">
                        @else
                            🏆
                        @endif
                        <div class="tournament-status {{ $tournament->getStatusBadgeClass() }}">
                            {{ $tournament->getStatusLabel() }}
                        </div>
                    </div>

                    <div class="tournament-content">
                        <h3>{{ $tournament->name }}</h3>

                        <div class="tournament-meta">
                            <div class="meta-item">
                                <span class="meta-icon">📅</span>
                                <span>{{ $tournament->tournament_date->format('d M Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-icon">⏰</span>
                                <span>{{ \Carbon\Carbon::parse($tournament->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($tournament->end_time)->format('H:i') }}</span>
                            </div>
                        </div>

                        <p class="tournament-description">
                            {{ Str::limit($tournament->description, 120) }}
                        </p>

                        <div class="tournament-footer">
                            <div class="participants-info">
                                <span>👥</span>
                                <span>{{ $tournament->participants->count() }} deelnemers</span>
                            </div>
                            <div class="game-mode-badge">
                                {{ strtoupper($tournament->game_mode) }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination">
            {{ $tournaments->links('pagination::simple-default') }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🏆</div>
            <h3>Geen toernooien gevonden</h3>
            <p>Er zijn momenteel geen toernooien die aan je filters voldoen.</p>
        </div>
    @endif
</div>
@endsection
