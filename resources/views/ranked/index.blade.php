@extends('layouts.app')

@section('title', 'Ranked Systeem - MMR Ranges')

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

    .ranked-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .gamemode-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .tab-button {
        padding: 1rem 2rem;
        background: #0f1220;
        border: 2px solid #2a3150;
        border-radius: 8px;
        color: #a0aec0;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tab-button:hover,
    .tab-button.active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: #ffffff;
    }

    .gamemode-content {
        display: none;
    }

    .gamemode-content.active {
        display: block;
    }

    .rank-table-container {
        background: #0f1220;
        border-radius: 8px;
        border: 1px solid #2a3150;
        overflow-x: auto;
    }

    .rank-table {
        width: 100%;
        border-collapse: collapse;
    }

    .rank-table thead {
        background: #151b2e;
    }

    .rank-table th {
        padding: 1rem;
        text-align: center;
        color: #ffffff;
        font-weight: 600;
        border-bottom: 2px solid #2a3150;
    }

    .rank-table th:first-child {
        text-align: left;
        padding-left: 2rem;
    }

    .rank-table tbody tr {
        border-bottom: 1px solid #1a1f35;
        transition: background 0.2s ease;
    }

    .rank-table tbody tr:hover {
        background: #151b2e;
    }

    .rank-table td {
        padding: 1.25rem 1rem;
        text-align: center;
        color: #c0c0c0;
    }

    .rank-table td:first-child {
        text-align: left;
        padding-left: 2rem;
    }

    .rank-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .rank-image {
        width: 50px;
        height: 50px;
        object-fit: contain;
        max-width: 50px;
        max-height: 50px;
    }

    .rank-name {
        font-weight: 600;
        color: #ffffff;
        font-size: 1.05rem;
    }

    .mmr-value {
        color: #3b82f6;
        font-weight: 500;
    }

    .info-box {
        background: #151b2e;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
        margin-bottom: 2rem;
    }

    .info-box h3 {
        color: #4a9eff;
        margin-bottom: 1rem;
    }

    .info-box p {
        color: #9095a0;
        line-height: 1.8;
        margin-bottom: 0.5rem;
    }

    .info-box ul {
        color: #9095a0;
        line-height: 1.8;
        margin-left: 1.5rem;
        margin-top: 0.5rem;
    }

    .info-box li {
        margin-bottom: 0.3rem;
    }

    @media (max-width: 1024px) {
        .rank-table th,
        .rank-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.9rem;
        }

        .rank-table th:first-child,
        .rank-table td:first-child {
            padding-left: 1rem;
        }

        .rank-image {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .gamemode-tabs {
            flex-direction: column;
        }

        .tab-button {
            width: 100%;
        }

        .rank-table {
            font-size: 0.85rem;
        }

        .rank-table th,
        .rank-table td {
            padding: 0.5rem 0.25rem;
        }

        .rank-table th:first-child,
        .rank-table td:first-child {
            padding-left: 0.5rem;
        }

        .rank-image {
            width: 35px;
            height: 35px;
        }

        .rank-name {
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>📊 Ranked Systeem</h1>
    <p>Ontdek de MMR ranges voor alle ranks in Rocket League</p>
</div>

<div class="ranked-container">
    <!-- Info Box -->
    <div class="info-box">
        <h3>ℹ️ Over MMR (Match Making Rating)</h3>
        <p>
            Je MMR bepaalt je rank in Rocket League. Wanneer je wint, gaat je MMR omhoog. Wanneer je verliest, gaat je MMR omlaag.
        </p>
        <p>
            <strong>Belangrijke punten:</strong>
        </p>
        <ul>
            <li>Elke gamemode (1v1, 2v2, 3v3) heeft zijn eigen MMR en rank</li>
            <li>1v1 (Duel) heeft lagere MMR ranges omdat het moeilijker is</li>
            <li>3v3 (Standard) heeft iets hogere MMR ranges dan 2v2</li>
            <li>Je rank wordt pas zichtbaar na 10 placement matches per gamemode</li>
        </ul>
    </div>

    <!-- Game Mode Tabs -->
    <div class="gamemode-tabs">
        <button class="tab-button active" onclick="showGamemode('duel')">
            🎮 Ranked Duel 1v1
        </button>
        <button class="tab-button" onclick="showGamemode('doubles')">
            👥 Ranked Doubles 2v2
        </button>
        <button class="tab-button" onclick="showGamemode('standard')">
            👨‍👩‍👦 Ranked Standard 3v3
        </button>
    </div>

    <!-- Gamemode Content -->
    @foreach($orderedGamemodes as $mode => $data)
        <div class="gamemode-content {{ $loop->first ? 'active' : '' }}" id="{{ $mode }}-content">
            <h2 style="text-align: center; color: #4a9eff; margin-bottom: 2rem; font-size: 2rem;">
                {{ $data['name'] }}
            </h2>

            <div class="rank-table-container">
                <table class="rank-table">
                    <thead>
                        <tr>
                            <th>Tier / Rank</th>
                            <th>Division I</th>
                            <th>Division II</th>
                            <th>Division III</th>
                            <th>Division IV</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['ranks'] as $rankData)
                            <tr>
                                <td>
                                    <div class="rank-info">
                                        <img
                                            src="{{ asset($rankData['image']) }}"
                                            alt="{{ $rankData['rank'] }}"
                                            class="rank-image"
                                        >
                                        <span class="rank-name">{{ $rankData['rank'] }}</span>
                                    </div>
                                </td>
                                <td><span class="mmr-value">{{ $rankData['divisions']['I'] }}</span></td>
                                <td><span class="mmr-value">{{ $rankData['divisions']['II'] }}</span></td>
                                <td><span class="mmr-value">{{ $rankData['divisions']['III'] }}</span></td>
                                <td><span class="mmr-value">{{ $rankData['divisions']['IV'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    function showGamemode(mode) {
        // Hide all gamemode contents
        document.querySelectorAll('.gamemode-content').forEach(content => {
            content.classList.remove('active');
        });

        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });

        // Show selected gamemode content
        document.getElementById(mode + '-content').classList.add('active');

        // Add active class to clicked button
        event.target.classList.add('active');
    }
</script>
@endsection
