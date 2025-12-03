@extends('layouts.app')

@section('title', $nieuws->title . ' - Rocket League Community')

@section('styles')
<style>
    .nieuws-detail {
        max-width: 900px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #3b82f6;
        text-decoration: none;
        margin-bottom: 2rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2563eb;
    }

    .nieuws-header {
        margin-bottom: 2rem;
    }

    .nieuws-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .nieuws-date {
        color: #3b82f6;
        font-weight: 500;
    }

    .nieuws-header h1 {
        font-size: 2.5rem;
        color: #ffffff;
        line-height: 1.2;
    }

    .nieuws-image-container {
        width: 100%;
        margin: 2rem 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #2a3150;
    }

    .nieuws-image-large {
        width: 100%;
        height: auto;
        display: block;
    }

    .nieuws-body {
        background: #0f1220;
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
        line-height: 1.8;
        color: #e0e0e0;
    }

    .nieuws-body p {
        margin-bottom: 1rem;
    }

    .nieuws-body h2 {
        color: #ffffff;
        font-size: 1.8rem;
        margin: 2rem 0 1rem;
    }

    .nieuws-body h3 {
        color: #ffffff;
        font-size: 1.4rem;
        margin: 1.5rem 0 0.75rem;
    }

    .nieuws-body ul,
    .nieuws-body ol {
        margin-left: 2rem;
        margin-bottom: 1rem;
    }

    .nieuws-body li {
        margin-bottom: 0.5rem;
    }

    .nieuws-footer {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #2a3150;
        text-align: center;
    }

    /* Comments Section */
    .comments-section {
        margin-top: 3rem;
        background: #0f1220;
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
    }

    .comments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #2a3150;
    }

    .comments-header h2 {
        color: #fff;
        font-size: 1.5rem;
        margin: 0;
    }

    .comments-count {
        color: #9095a0;
        font-size: 0.9rem;
    }

    .comment-form {
        margin-bottom: 2rem;
    }

    .comment-form textarea {
        width: 100%;
        padding: 1rem;
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 6px;
        color: #e0e0e0;
        font-size: 0.95rem;
        font-family: inherit;
        resize: vertical;
        min-height: 100px;
    }

    .comment-form textarea:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .comment-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: #3b82f6;
        color: #fff;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .comment {
        background: #1a1f35;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .comment-author {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .comment-author-info {
        display: flex;
        flex-direction: column;
    }

    .comment-author-name {
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .comment-date {
        color: #9095a0;
        font-size: 0.85rem;
    }

    .comment-content {
        color: #e0e0e0;
        line-height: 1.6;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .comment-actions {
        display: flex;
        gap: 0.5rem;
    }

    .empty-comments {
        text-align: center;
        padding: 3rem 1rem;
        color: #9095a0;
    }

    .empty-comments-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .login-prompt {
        text-align: center;
        padding: 2rem;
        background: #1a1f35;
        border-radius: 8px;
        border: 1px solid #2a3150;
    }

    .login-prompt p {
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .login-prompt a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 600;
    }

    .login-prompt a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .nieuws-header h1 {
            font-size: 1.8rem;
        }

        .nieuws-body {
            padding: 1.5rem;
        }

        .comments-section {
            padding: 1.5rem;
        }

        .comment {
            padding: 1rem;
        }

        .comment-header {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="nieuws-detail">
    <a href="{{ route('nieuws.index') }}" class="back-link">
        ← Terug naar nieuws overzicht
    </a>

    <article>
        <header class="nieuws-header">
            <div class="nieuws-meta">
                <span class="nieuws-date">
                    {{ $nieuws->published_at->format('d F Y') }}
                </span>
                <span>•</span>
                <span>{{ $nieuws->published_at->diffForHumans() }}</span>
            </div>
            <h1>{{ $nieuws->title }}</h1>
        </header>

        @if($nieuws->image)
            <div class="nieuws-image-container">
                <img src="{{ asset('storage/' . $nieuws->image) }}" alt="{{ $nieuws->title }}" class="nieuws-image-large">
            </div>
        @endif

        <div class="nieuws-body">
            {!! nl2br(e($nieuws->content)) !!}
        </div>

        <footer class="nieuws-footer">
            <a href="{{ route('nieuws.index') }}" class="btn btn-secondary">
                Terug naar overzicht
            </a>
        </footer>
    </article>

    <!-- Comments Section -->
    <section class="comments-section">
        <div class="comments-header">
            <h2>Reacties</h2>
            <span class="comments-count">{{ $nieuws->comments->count() }} {{ $nieuws->comments->count() === 1 ? 'reactie' : 'reacties' }}</span>
        </div>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        @auth
            <!-- Comment Form -->
            <form method="POST" action="{{ route('nieuws.comments.store', $nieuws->id) }}" class="comment-form" id="commentForm">
                @csrf
                <textarea
                    name="content"
                    placeholder="Schrijf een reactie..."
                    required
                    minlength="3"
                    maxlength="1000"
                >{{ old('content') }}</textarea>
                @error('content')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
                <div class="comment-form-actions">
                    <button type="submit" class="btn btn-primary">Plaats Reactie</button>
                </div>
            </form>
        @else
            <!-- Login Prompt -->
            <div class="login-prompt">
                <p>Je moet ingelogd zijn om een reactie te plaatsen.</p>
                <a href="{{ route('login') }}">Log in</a> of <a href="{{ route('register') }}">Registreer</a>
            </div>
        @endauth

        <!-- Comments List -->
        @if($nieuws->comments->count() > 0)
            <div class="comments-list">
                @foreach($nieuws->comments as $comment)
                    <div class="comment">
                        <div class="comment-header">
                            <div class="comment-author">
                                <div class="comment-avatar">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="comment-author-info">
                                    <span class="comment-author-name">{{ $comment->user->username ?? $comment->user->name }}</span>
                                    <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            @auth
                                @if(Auth::id() === $comment->user_id || Auth::user()->is_admin)
                                    <div class="comment-actions">
                                        <form method="POST" action="{{ route('nieuws.comments.destroy', [$nieuws->id, $comment->id]) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Weet je zeker dat je deze reactie wilt verwijderen?')">
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        <div class="comment-content">{{ $comment->content }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-comments">
                <div class="empty-comments-icon">💬</div>
                <p>Nog geen reacties. Wees de eerste om te reageren!</p>
            </div>
        @endif
    </section>
</div>

@endsection

@section('scripts')
<script>
    // Client-side validation for comment form
    document.getElementById('commentForm')?.addEventListener('submit', function(e) {
        const content = document.querySelector('textarea[name="content"]').value.trim();

        if (content.length < 3) {
            e.preventDefault();
            alert('Je reactie moet minimaal 3 karakters bevatten.');
            return false;
        }

        if (content.length > 1000) {
            e.preventDefault();
            alert('Je reactie mag maximaal 1000 karakters bevatten.');
            return false;
        }
    });
</script>
@endsection
