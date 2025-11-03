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

    .mmr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .mmr-card {
        background: #1a1f35;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
        text-align: center;
        transition: all 0.3s ease;
    }

    .mmr-card:hover {
        border-color: #4a9eff;
        transform: translateY(-3px);
    }

    .mmr-mode {
        color: #9095a0;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .rank-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 1rem;
    }

    .mmr-rank {
        color: #4a9eff;
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .mmr-division {
        color: #9095a0;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .mmr-value {
        color: #c0c0c0;
        font-size: 0.95rem;
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

            @if ($user->mmr_1v1 || $user->mmr_2v2 || $user->mmr_3v3 || $user->mmr_hoops || $user->mmr_rumble || $user->mmr_dropshot || $user->mmr_snowday || $user->mmr_tournament)
                <div class="profile-section">
                    <h2>Ranked Stats</h2>
                    <div class="mmr-grid">
                        @if ($user->mmr_1v1)
                            <div class="mmr-card">
                                <div class="mmr-mode">1v1 Duel</div>
                                <img src="{{ $user->getRankImage($user->mmr_1v1) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_1v1) }}</div>
                                @if ($user->getDivisionText($user->mmr_1v1))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_1v1) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_1v1 }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_2v2)
                            <div class="mmr-card">
                                <div class="mmr-mode">2v2 Doubles</div>
                                <img src="{{ $user->getRankImage($user->mmr_2v2) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_2v2) }}</div>
                                @if ($user->getDivisionText($user->mmr_2v2))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_2v2) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_2v2 }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_3v3)
                            <div class="mmr-card">
                                <div class="mmr-mode">3v3 Standard</div>
                                <img src="{{ $user->getRankImage($user->mmr_3v3) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_3v3) }}</div>
                                @if ($user->getDivisionText($user->mmr_3v3))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_3v3) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_3v3 }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_hoops)
                            <div class="mmr-card">
                                <div class="mmr-mode">Hoops</div>
                                <img src="{{ $user->getRankImage($user->mmr_hoops) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_hoops) }}</div>
                                @if ($user->getDivisionText($user->mmr_hoops))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_hoops) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_hoops }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_rumble)
                            <div class="mmr-card">
                                <div class="mmr-mode">Rumble</div>
                                <img src="{{ $user->getRankImage($user->mmr_rumble) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_rumble) }}</div>
                                @if ($user->getDivisionText($user->mmr_rumble))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_rumble) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_rumble }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_dropshot)
                            <div class="mmr-card">
                                <div class="mmr-mode">Dropshot</div>
                                <img src="{{ $user->getRankImage($user->mmr_dropshot) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_dropshot) }}</div>
                                @if ($user->getDivisionText($user->mmr_dropshot))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_dropshot) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_dropshot }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_snowday)
                            <div class="mmr-card">
                                <div class="mmr-mode">Snow Day</div>
                                <img src="{{ $user->getRankImage($user->mmr_snowday) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_snowday) }}</div>
                                @if ($user->getDivisionText($user->mmr_snowday))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_snowday) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_snowday }} MMR</div>
                            </div>
                        @endif

                        @if ($user->mmr_tournament)
                            <div class="mmr-card">
                                <div class="mmr-mode">Tournament</div>
                                <img src="{{ $user->getRankImage($user->mmr_tournament) }}" alt="Rank Icon" class="rank-icon">
                                <div class="mmr-rank">{{ $user->getRankFromMMR($user->mmr_tournament) }}</div>
                                @if ($user->getDivisionText($user->mmr_tournament))
                                    <div class="mmr-division">{{ $user->getDivisionText($user->mmr_tournament) }}</div>
                                @endif
                                <div class="mmr-value">{{ $user->mmr_tournament }} MMR</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
