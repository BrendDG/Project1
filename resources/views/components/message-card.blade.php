@props(['message', 'type' => 'received'])

<div class="message-card {{ $message->is_read ? '' : 'unread' }}">
    <div class="message-header">
        <div class="message-user">
            @if($type === 'received')
                <strong>Van: {{ $message->sender->display_name }}</strong>
            @else
                <strong>Aan: {{ $message->receiver->display_name }}</strong>
            @endif
        </div>
        <div class="message-meta">
            <span class="message-date">{{ $message->created_at->diffForHumans() }}</span>
            @if($type === 'received' && !$message->is_read)
                <span class="unread-badge">Ongelezen</span>
            @endif
        </div>
    </div>

    <div class="message-subject">
        <a href="{{ route('messages.show', $message) }}">
            {{ $message->subject }}
        </a>
    </div>

    <div class="message-preview">
        {{ Str::limit($message->message, 100) }}
    </div>

    <div class="message-actions">
        <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-primary">Bekijken</a>
        <form method="POST" action="{{ route('messages.destroy', $message) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?')">
                Verwijderen
            </button>
        </form>
    </div>
</div>

<style>
    .message-card {
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .message-card.unread {
        border-left: 4px solid #3b82f6;
        background: #151b2e;
    }

    .message-card:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .message-user strong {
        color: #4a9eff;
        font-size: 0.95rem;
    }

    .message-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .message-date {
        color: #9095a0;
        font-size: 0.85rem;
    }

    .unread-badge {
        background: #ef4444;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .message-subject {
        margin-bottom: 0.75rem;
    }

    .message-subject a {
        color: #e0e0e0;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .message-subject a:hover {
        color: #4a9eff;
    }

    .message-preview {
        color: #c0c0c0;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .message-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    @media (max-width: 768px) {
        .message-card {
            padding: 1rem;
        }

        .message-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .message-actions {
            width: 100%;
        }

        .message-actions .btn {
            flex: 1;
        }
    }
</style>
