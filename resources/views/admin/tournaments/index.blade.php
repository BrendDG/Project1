@extends('layouts.app')

@section('title', 'Toernooien Beheer - Admin')

@section('styles')
<style>
    .admin-container {
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .admin-header h1 {
        color: #fff;
        font-size: 32px;
    }

    .btn {
        display: inline-block;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 14px;
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
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    .btn-warning {
        background: #f59e0b;
        color: #fff;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-secondary {
        background: #6b7280;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #4b5563;
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

    .tournament-name {
        color: #fff;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
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

    .actions {
        display: flex;
        gap: 8px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 30px;
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
        .admin-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            min-width: 800px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Toernooien Beheer</h1>
        <a href="{{ route('admin.tournaments.create') }}" class="btn btn-primary">+ Nieuw Toernooi</a>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Game Mode</th>
                    <th>Deelnemers</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tournaments as $tournament)
                    <tr>
                        <td>
                            <div class="tournament-name">{{ $tournament->name }}</div>
                        </td>
                        <td>{{ $tournament->tournament_date->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($tournament->start_time)->format('H:i') }}</td>
                        <td>{{ strtoupper($tournament->game_mode) }}</td>
                        <td>{{ $tournament->participants->count() }}/{{ $tournament->max_participants }}</td>
                        <td>
                            <span class="status-badge {{ $tournament->getStatusBadgeClass() }}">
                                {{ $tournament->getStatusLabel() }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-secondary btn-sm" target="_blank">Bekijk</a>
                                <a href="{{ route('admin.tournaments.participants', $tournament) }}" class="btn btn-secondary btn-sm">Deelnemers</a>
                                <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="btn btn-warning btn-sm">Bewerk</a>
                                <form method="POST" action="{{ route('admin.tournaments.destroy', $tournament) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je dit toernooi wilt verwijderen?')">Verwijder</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #9095a0;">
                            Geen toernooien gevonden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $tournaments->links('pagination::simple-default') }}
    </div>
</div>
@endsection
