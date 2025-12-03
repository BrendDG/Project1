@extends('layouts.app')

@section('title', 'Nieuw Toernooi - Admin')

@section('styles')
<style>
    .admin-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .form-card {
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 12px;
        padding: 40px;
    }

    .form-card h1 {
        color: #fff;
        font-size: 32px;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        color: #e0e0e0;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 6px;
        color: #e0e0e0;
        font-size: 14px;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group small {
        display: block;
        color: #9095a0;
        font-size: 12px;
        margin-top: 5px;
    }

    .error-message {
        color: #ef4444;
        font-size: 13px;
        margin-top: 5px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
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
    }

    .btn-secondary {
        background: #6b7280;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-card {
            padding: 25px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="form-card">
        <h1>Nieuw Toernooi Aanmaken</h1>

        <form method="POST" action="{{ route('admin.tournaments.store') }}" enctype="multipart/form-data" id="tournamentForm">
            @csrf

            <div class="form-group">
                <label for="name">Toernooi Naam *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Beschrijving *</label>
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tournament_date">Datum *</label>
                    <input type="date" id="tournament_date" name="tournament_date" value="{{ old('tournament_date') }}" required>
                    @error('tournament_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="game_mode">Game Mode *</label>
                    <select id="game_mode" name="game_mode" required>
                        <option value="">Selecteer game mode</option>
                        <option value="1v1" {{ old('game_mode') == '1v1' ? 'selected' : '' }}>1v1 Duel</option>
                        <option value="2v2" {{ old('game_mode') == '2v2' ? 'selected' : '' }}>2v2 Doubles</option>
                        <option value="3v3" {{ old('game_mode') == '3v3' ? 'selected' : '' }}>3v3 Standard</option>
                        <option value="hoops" {{ old('game_mode') == 'hoops' ? 'selected' : '' }}>Hoops</option>
                        <option value="rumble" {{ old('game_mode') == 'rumble' ? 'selected' : '' }}>Rumble</option>
                        <option value="dropshot" {{ old('game_mode') == 'dropshot' ? 'selected' : '' }}>Dropshot</option>
                        <option value="snowday" {{ old('game_mode') == 'snowday' ? 'selected' : '' }}>Snow Day</option>
                    </select>
                    @error('game_mode')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_time">Start Tijd *</label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                    @error('start_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_time">Eind Tijd *</label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                    @error('end_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="max_participants">Max Deelnemers *</label>
                    <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants', 32) }}" min="4" max="128" required>
                    <small>Tussen 4 en 128 deelnemers</small>
                    @error('max_participants')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prize_pool">Prijzenpot</label>
                    <input type="text" id="prize_pool" name="prize_pool" value="{{ old('prize_pool') }}" placeholder="bijv. €100">
                    @error('prize_pool')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image">Toernooi Afbeelding</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Max 2MB - JPEG, PNG, JPG, GIF</small>
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Toernooi Aanmaken</button>
                <a href="{{ route('admin.tournaments.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Client-side validation
    document.getElementById('tournamentForm').addEventListener('submit', function(e) {
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;
        const tournamentDate = document.getElementById('tournament_date').value;
        const today = new Date().toISOString().split('T')[0];

        // Validate date is not in the past
        if (tournamentDate < today) {
            e.preventDefault();
            alert('De toernooi datum moet vandaag of in de toekomst zijn.');
            return false;
        }

        // Validate end time is after start time
        if (endTime <= startTime) {
            e.preventDefault();
            alert('De eindtijd moet na de starttijd zijn.');
            return false;
        }

        // Validate max participants
        const maxParticipants = parseInt(document.getElementById('max_participants').value);
        if (maxParticipants < 4 || maxParticipants > 128) {
            e.preventDefault();
            alert('Het maximum aantal deelnemers moet tussen 4 en 128 zijn.');
            return false;
        }
    });
</script>
@endsection
