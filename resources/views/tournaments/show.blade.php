@extends('layouts.app')

@section('title', $tournament->name . ' - Toernooien')

@section('styles')
<style>
    .tournament-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .tournament-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .tournament-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: #fff;
        padding: 40px 20px;
    }

    .tournament-hero h1 {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .tournament-status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .status-upcoming {
        background: #10b981;
    }

    .status-ongoing {
        background: #f59e0b;
    }

    .status-completed {
        background: #6b7280;
    }

    .status-cancelled {
        background: #ef4444;
    }

    .tournament-meta-row {
        display: flex;
        gap: 30px;
        justify-content: center;
        flex-wrap: wrap;
        font-size: 16px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tournament-content-wrapper {
        max-width: 1200px;
        margin: -80px auto 40px;
        padding: 0 20px;
        position: relative;
        z-index: 3;
    }

    .tournament-main-card {
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 12px;
        padding: 40px;
        margin-bottom: 30px;
    }

    .tournament-description {
        color: #c0c0c0;
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .tournament-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: #0f1220;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #2a3150;
    }

    .detail-label {
        color: #9095a0;
        font-size: 14px;
        margin-bottom: 8px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .detail-value {
        color: #fff;
        font-size: 18px;
        font-weight: 600;
    }

    .registration-section {
        background: #0f1220;
        padding: 30px;
        border-radius: 8px;
        border: 1px solid #2a3150;
        margin-bottom: 30px;
    }

    .registration-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .registration-header h3 {
        color: #fff;
        font-size: 24px;
    }

    .spots-remaining {
        color: #10b981;
        font-size: 18px;
        font-weight: 600;
    }

    .spots-full {
        color: #ef4444;
    }

    .registration-progress {
        width: 100%;
        height: 12px;
        background: #2a3150;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .registration-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
        transition: width 0.3s ease;
    }

    .btn {
        display: inline-block;
        padding: 14px 28px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #3b82f6;
        color: #fff;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-disabled {
        background: #6b7280;
        color: #9095a0;
        cursor: not-allowed;
    }

    .btn-success {
        background: #10b981;
        color: #fff;
    }

    .participants-section {
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 12px;
        padding: 30px;
    }

    .participants-section h3 {
        color: #fff;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .participants-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .participant-card {
        background: #0f1220;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #2a3150;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .participant-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
    }

    .participant-info {
        flex: 1;
    }

    .participant-name {
        color: #fff;
        font-size: 14px;
        font-weight: 600;
    }

    .participant-status {
        color: #9095a0;
        font-size: 12px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #3b82f6;
        text-decoration: none;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .tournament-hero h1 {
            font-size: 32px;
        }

        .tournament-main-card {
            padding: 25px;
        }

        .tournament-details-grid {
            grid-template-columns: 1fr;
        }

        .registration-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="tournament-hero" @if($tournament->image) style="background-image: url('{{ asset($tournament->image) }}'); background-size: cover; background-position: center;" @endif>
    <div class="tournament-hero-content">
        <div class="tournament-status-badge {{ $tournament->getStatusBadgeClass() }}">
            {{ $tournament->getStatusLabel() }}
        </div>
        <h1>{{ $tournament->name }}</h1>
        <div class="tournament-meta-row">
            <div class="meta-item">
                <span>📅</span>
                <span>{{ $tournament->tournament_date->format('d M Y') }}</span>
            </div>
            <div class="meta-item">
                <span>⏰</span>
                <span>{{ \Carbon\Carbon::parse($tournament->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($tournament->end_time)->format('H:i') }}</span>
            </div>
            <div class="meta-item">
                <span>🎮</span>
                <span>{{ strtoupper($tournament->game_mode) }}</span>
            </div>
            @if($tournament->prize_pool)
                <div class="meta-item">
                    <span>💰</span>
                    <span>{{ $tournament->prize_pool }}</span>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="tournament-content-wrapper">
    <a href="{{ route('tournaments.index') }}" class="back-link">
        ← Terug naar alle toernooien
    </a>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <div class="tournament-main-card">
        <h2 style="color: #fff; font-size: 28px; margin-bottom: 20px;">Over dit Toernooi</h2>
        <p class="tournament-description">{{ $tournament->description }}</p>

        <div class="tournament-details-grid">
            <div class="detail-card">
                <div class="detail-label">Max Deelnemers</div>
                <div class="detail-value">{{ $tournament->max_participants }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Geregistreerd</div>
                <div class="detail-value">{{ $tournament->participants->count() }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Game Mode</div>
                <div class="detail-value">{{ strtoupper($tournament->game_mode) }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Organisator</div>
                <div class="detail-value">{{ $tournament->creator->name }}</div>
            </div>
        </div>

        @if($tournament->status === 'upcoming')
            <div class="registration-section">
                <div class="registration-header">
                    <h3>Registratie</h3>
                    @if($tournament->isFull())
                        <span class="spots-remaining spots-full">VOL</span>
                    @else
                        <span class="spots-remaining">{{ $tournament->getAvailableSpots() }} plekken over</span>
                    @endif
                </div>

                <div class="registration-progress">
                    <div class="registration-progress-bar" style="width: {{ ($tournament->participants->count() / $tournament->max_participants) * 100 }}%"></div>
                </div>

                @auth
                    @if($isRegistered)
                        <form method="POST" action="{{ route('tournaments.unregister', $tournament) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Weet je zeker dat je je wilt uitschrijven?')">
                                Uitschrijven
                            </button>
                        </form>
                        <p style="color: #10b981; margin-top: 15px; font-size: 14px;">✓ Je bent geregistreerd voor dit toernooi!</p>
                    @elseif($tournament->isFull())
                        <button class="btn btn-disabled" disabled>Toernooi is vol</button>
                    @else
                        <form method="POST" action="{{ route('tournaments.register', $tournament) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Registreer voor dit Toernooi
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Log in om te registreren
                    </a>
                @endauth
            </div>
        @endif
    </div>

    @if($tournament->participants->count() > 0)
        <div class="participants-section">
            <h3>Deelnemers ({{ $tournament->participants->count() }})</h3>
            <div class="participants-grid">
                @foreach($tournament->participants as $participant)
                    <div class="participant-card">
                        <div class="participant-avatar">
                            {{ strtoupper(substr($participant->name, 0, 1)) }}
                        </div>
                        <div class="participant-info">
                            <div class="participant-name">{{ $participant->username ?? $participant->name }}</div>
                            <div class="participant-status">Geregistreerd</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
