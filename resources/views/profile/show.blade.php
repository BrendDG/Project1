@extends('layouts.app')

@section('title', $user->display_name . ' - Profiel')

@section('styles')
<style>
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .profile-header {
        background: #0f1220;
        padding: 2.5rem;
        border-radius: 12px;
        border: 1px solid #2a3150;
        margin-bottom: 2rem;
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a9eff;
    }

    .profile-info {
        flex: 1;
    }

    .profile-info h1 {
        font-size: 2rem;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .profile-info .email {
        color: #9095a0;
        margin-bottom: 1rem;
    }

    .profile-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
    }

    .stat {
        text-align: center;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4a9eff;
    }

    .stat-label {
        color: #9095a0;
        font-size: 0.875rem;
    }

    .profile-content {
        background: #0f1220;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #2a3150;
    }

    .profile-section {
        margin-bottom: 2rem;
    }

    .profile-section:last-child {
        margin-bottom: 0;
    }

    .profile-section h2 {
        color: #4a9eff;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #2a3150;
        padding-bottom: 0.5rem;
    }

    .profile-section p {
        color: #c0c0c0;
        line-height: 1.6;
    }

    .empty-state {
        color: #9095a0;
        font-style: italic;
    }

    .edit-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #3b82f6;
        color: #ffffff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: background 0.3s ease;
        margin-top: 1rem;
    }

    .edit-button:hover {
        background: #2563eb;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-stats {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
    <div class="profile-container">
        @if (session('success'))
            <div class="success" style="background: #10b981; color: #ffffff; padding: 1rem; border-radius: 6px; margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-header">
            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->display_name }}" class="profile-photo">

            <div class="profile-info">
                <h1>{{ $user->display_name }}</h1>
                @if (auth()->check() && auth()->id() === $user->id)
                    <p class="email">{{ $user->email }}</p>
                @endif

                <div class="profile-stats">
                    <div class="stat">
                        <div class="stat-value">{{ $user->created_at->format('d M Y') }}</div>
                        <div class="stat-label">Lid sinds</div>
                    </div>
                </div>

                @if (auth()->check() && auth()->id() === $user->id)
                    <a href="{{ route('profile.edit', $user) }}" class="edit-button">Profiel bewerken</a>
                @endif
            </div>
        </div>

        <div class="profile-content">
            @if ($user->birthday)
                <div class="profile-section">
                    <h2>Verjaardag</h2>
                    <p>{{ $user->birthday->format('d F Y') }}</p>
                </div>
            @endif

            <div class="profile-section">
                <h2>Over mij</h2>
                @if ($user->about_me)
                    <p>{{ $user->about_me }}</p>
                @else
                    <p class="empty-state">Deze gebruiker heeft nog geen "over mij" tekst toegevoegd.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
