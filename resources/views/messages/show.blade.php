@extends('layouts.app')

@section('title', 'Bericht bekijken')

@section('styles')
<style>
    .message-view-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .message-actions-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .back-button {
        color: #4a9eff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .back-button:hover {
        color: #2563eb;
    }

    .message-card-full {
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 8px;
        overflow: hidden;
    }

    .message-header-full {
        background: #151b2e;
        padding: 2rem;
        border-bottom: 1px solid #2a3150;
    }

    .message-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .message-participants {
        flex: 1;
    }

    .message-participant {
        margin-bottom: 0.75rem;
    }

    .message-participant label {
        color: #9095a0;
        font-size: 0.875rem;
        margin-right: 0.5rem;
    }

    .message-participant strong {
        color: #4a9eff;
        font-size: 1rem;
    }

    .message-timestamp {
        text-align: right;
        color: #9095a0;
        font-size: 0.875rem;
    }

    .message-subject-full {
        font-size: 1.75rem;
        color: #e0e0e0;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .message-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: #1a1f35;
        border-radius: 12px;
        font-size: 0.875rem;
    }

    .message-status.read {
        color: #10b981;
    }

    .message-status.unread {
        color: #f59e0b;
    }

    .message-body-full {
        padding: 2rem;
    }

    .message-content {
        color: #e0e0e0;
        line-height: 1.8;
        font-size: 1.05rem;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .message-actions-bottom {
        padding: 1.5rem 2rem;
        background: #151b2e;
        border-top: 1px solid #2a3150;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .reply-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid #2a3150;
    }

    .reply-section h2 {
        color: #4a9eff;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .message-header-full,
        .message-body-full,
        .message-actions-bottom {
            padding: 1.5rem;
        }

        .message-subject-full {
            font-size: 1.5rem;
        }

        .message-meta-row {
            flex-direction: column;
        }

        .message-timestamp {
            text-align: left;
        }

        .message-actions-bottom {
            flex-direction: column;
        }

        .message-actions-bottom .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="message-view-container">
    <div class="message-actions-top">
        <a href="{{ route('messages.index') }}" class="back-button">
            &larr; Terug naar inbox
        </a>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            @if($message->receiver_id === auth()->id())
                <a href="{{ route('messages.create', ['to' => $message->sender_id]) }}" class="btn btn-primary">
                    Beantwoorden
                </a>
            @endif
            <form method="POST" action="{{ route('messages.destroy', $message) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?')">
                    Verwijderen
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <div class="message-card-full">
        <div class="message-header-full">
            <div class="message-meta-row">
                <div class="message-participants">
                    <div class="message-participant">
                        <label>Van:</label>
                        <strong>
                            <a href="{{ route('profile.show', $message->sender) }}" style="color: #4a9eff; text-decoration: none;">
                                {{ $message->sender->display_name }}
                            </a>
                        </strong>
                    </div>
                    <div class="message-participant">
                        <label>Aan:</label>
                        <strong>
                            <a href="{{ route('profile.show', $message->receiver) }}" style="color: #4a9eff; text-decoration: none;">
                                {{ $message->receiver->display_name }}
                            </a>
                        </strong>
                    </div>
                </div>

                <div class="message-timestamp">
                    <div>{{ $message->created_at->format('d M Y') }}</div>
                    <div>{{ $message->created_at->format('H:i') }}</div>
                    <div style="margin-top: 0.5rem;">
                        @if($message->is_read)
                            <span class="message-status read">
                                ✓ Gelezen op {{ $message->read_at->format('d M Y H:i') }}
                            </span>
                        @else
                            <span class="message-status unread">
                                ○ Ongelezen
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <h1 class="message-subject-full">{{ $message->subject }}</h1>
        </div>

        <div class="message-body-full">
            <div class="message-content">{{ $message->message }}</div>
        </div>

        <div class="message-actions-bottom">
            @if($message->receiver_id === auth()->id())
                <a href="{{ route('messages.create', ['to' => $message->sender_id]) }}" class="btn btn-primary">
                    Beantwoorden
                </a>
            @endif
            <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                Terug naar inbox
            </a>
        </div>
    </div>
</div>
@endsection
