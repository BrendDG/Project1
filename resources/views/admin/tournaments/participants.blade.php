@extends('layouts.app')

@section('title', 'Deelnemers - ' . $tournament->name)

@section('styles')
<style>
    .admin-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        color: #fff;
        font-size: 32px;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #9095a0;
        font-size: 16px;
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
    }

    .stat-value {
        color: #fff;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stat-label {
        color: #9095a0;
        font-size: 14px;
        text-transform: uppercase;
    }

    .table-container {
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 12px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #0f1220;
    }

    th {
        padding: 16px;
        text-align: left;
        color: #9095a0;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 1px solid #2a3150;
    }

    td {
        padding: 16px;
        color: #e0e0e0;
        border-bottom: 1px solid #2a3150;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background: #0f1220;
    }

    .participant-info {
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
        font-size: 16px;
    }

    .participant-details {
        flex: 1;
    }

    .participant-name {
        color: #fff;
        font-weight: 600;
        font-size: 15px;
    }

    .participant-username {
        color: #9095a0;
        font-size: 13px;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-success {
        background: #10b981;
        color: #fff;
    }

    .badge-secondary {
        background: #6b7280;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
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

    @media (max-width: 768px) {
        .table-container {
            overflow-x: auto;
        }

        table {
            min-width: 600px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <a href="{{ route('admin.tournaments.index') }}" class="back-link">
        ← Terug naar toernooien
    </a>

    <div class="page-header">
        <h1>Deelnemers: {{ $tournament->name }}</h1>
        <p>{{ $tournament->tournament_date->format('d M Y') }} - {{ \Carbon\Carbon::parse($tournament->start_time)->format('H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $tournament->participants->count() }}</div>
            <div class="stat-label">Geregistreerd</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $tournament->max_participants }}</div>
            <div class="stat-label">Max Deelnemers</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $tournament->getAvailableSpots() }}</div>
            <div class="stat-label">Plekken Over</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $tournament->participants->where('pivot.checked_in', true)->count() }}</div>
            <div class="stat-label">Ingecheckt</div>
        </div>
    </div>

    @if($tournament->participants->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Deelnemer</th>
                        <th>Email</th>
                        <th>Geregistreerd Op</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tournament->participants as $index => $participant)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="participant-info">
                                    <div class="participant-avatar">
                                        {{ strtoupper(substr($participant->name, 0, 1)) }}
                                    </div>
                                    <div class="participant-details">
                                        <div class="participant-name">{{ $participant->name }}</div>
                                        @if($participant->username)
                                            <div class="participant-username">@{{ $participant->username }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($participant->pivot->registered_at)->format('d M Y H:i') }}</td>
                            <td>
                                @if($participant->pivot->checked_in)
                                    <span class="badge badge-success">Ingecheckt</span>
                                @else
                                    <span class="badge badge-secondary">Geregistreerd</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="table-container">
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <h3>Geen deelnemers</h3>
                <p>Er zijn nog geen deelnemers geregistreerd voor dit toernooi.</p>
            </div>
        </div>
    @endif
</div>
@endsection
