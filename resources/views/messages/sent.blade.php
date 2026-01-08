@extends('layouts.app')

@section('title', 'Verzonden - Berichten')

@section('styles')
<style>
    .messages-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .messages-header h1 {
        color: #4a9eff;
        font-size: 2rem;
    }

    .messages-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid #2a3150;
        padding-bottom: 0.5rem;
    }

    .messages-tabs a {
        color: #c0c0c0;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 5px 5px 0 0;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .messages-tabs a:hover {
        color: #4a9eff;
        background: #151b2e;
    }

    .messages-tabs a.active {
        color: #4a9eff;
        background: #151b2e;
        border-bottom: 2px solid #4a9eff;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 8px;
    }

    .empty-state h2 {
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #6b7280;
        margin-bottom: 2rem;
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
        border: 1px solid #2a3150;
        color: #c0c0c0;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: #151b2e;
        border-color: #3b82f6;
        color: #4a9eff;
    }

    .pagination .active span {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .pagination .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .messages-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .messages-tabs {
            width: 100%;
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('content')
<div class="messages-container">
    <div class="messages-header">
        <h1>Verzonden berichten</h1>
        <a href="{{ route('messages.create') }}" class="btn btn-primary">Nieuw bericht</a>
    </div>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <div class="messages-tabs">
        <a href="{{ route('messages.index') }}">Ontvangen</a>
        <a href="{{ route('messages.sent') }}" class="active">Verzonden</a>
    </div>

    @if($messages->count() > 0)
        <div class="messages-list">
            @foreach($messages as $message)
                <x-message-card :message="$message" type="sent" />
            @endforeach
        </div>

        <div class="pagination">
            {{ $messages->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2>Geen verzonden berichten</h2>
            <p>Je hebt nog geen berichten verzonden.</p>
            <a href="{{ route('messages.create') }}" class="btn btn-primary">Stuur je eerste bericht</a>
        </div>
    @endif
</div>
@endsection
