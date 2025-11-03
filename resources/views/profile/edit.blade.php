@extends('layouts.app')

@section('title', 'Profiel bewerken')

@section('styles')
<style>
    .profile-edit-container {
        max-width: 700px;
        margin: 0 auto;
    }

    .edit-card {
        background: #0f1220;
        padding: 2.5rem;
        border-radius: 12px;
        border: 1px solid #2a3150;
    }

    .edit-card h1 {
        color: #ffffff;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .edit-card .subtitle {
        color: #9095a0;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #c0c0c0;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="date"],
    .form-group input[type="number"],
    .form-group textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 6px;
        color: #e0e0e0;
        font-size: 1rem;
        transition: border-color 0.3s ease;
        font-family: inherit;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4a9eff;
    }

    .form-group small {
        color: #9095a0;
        font-size: 0.875rem;
        display: block;
        margin-top: 0.25rem;
    }

    .photo-preview {
        margin-top: 1rem;
        text-align: center;
    }

    .photo-preview img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a9eff;
    }

    .error {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        flex: 1;
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background: #3b82f6;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: transparent;
        color: #c0c0c0;
        border: 1px solid #2a3150;
    }

    .btn-secondary:hover {
        background: #1a1f35;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
    <div class="profile-edit-container">
        <div class="edit-card">
            <h1>Profiel bewerken</h1>
            <p class="subtitle">Pas je profielinformatie aan</p>

            @if ($errors->any())
                <div class="error" style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(239, 68, 68, 0.1); border-radius: 6px;">
                    <ul style="list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update', $user) }}" enctype="multipart/form-data" id="profileEditForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Naam *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}">
                    <small>Dit is de naam die op je profiel wordt weergegeven</small>
                </div>

                <div class="form-group">
                    <label for="email">E-mailadres *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="birthday">Verjaardag</label>
                    <input type="date" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday?->format('Y-m-d')) }}">
                </div>

                <div class="form-group">
                    <label for="about_me">Over mij</label>
                    <textarea id="about_me" name="about_me" maxlength="1000">{{ old('about_me', $user->about_me) }}</textarea>
                    <small id="charCount">{{ strlen(old('about_me', $user->about_me ?? '')) }}/1000 tekens</small>
                </div>

                <h3 style="color: #4a9eff; margin-top: 2rem; margin-bottom: 1rem; font-size: 1.25rem;">Ranked MMR</h3>
                <p style="color: #9095a0; margin-bottom: 1.5rem; font-size: 0.95rem;">Vul je MMR in voor elke gamemode (divisie wordt automatisch berekend)</p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div class="form-group">
                        <label for="mmr_1v1">1v1 Duel</label>
                        <input type="number" id="mmr_1v1" name="mmr_1v1" value="{{ old('mmr_1v1', $user->mmr_1v1) }}" min="0" max="3000" placeholder="bijv. 1200">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_2v2">2v2 Doubles</label>
                        <input type="number" id="mmr_2v2" name="mmr_2v2" value="{{ old('mmr_2v2', $user->mmr_2v2) }}" min="0" max="3000" placeholder="bijv. 1200">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_3v3">3v3 Standard</label>
                        <input type="number" id="mmr_3v3" name="mmr_3v3" value="{{ old('mmr_3v3', $user->mmr_3v3) }}" min="0" max="3000" placeholder="bijv. 1200">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_hoops">Hoops</label>
                        <input type="number" id="mmr_hoops" name="mmr_hoops" value="{{ old('mmr_hoops', $user->mmr_hoops) }}" min="0" max="3000" placeholder="bijv. 1000">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_rumble">Rumble</label>
                        <input type="number" id="mmr_rumble" name="mmr_rumble" value="{{ old('mmr_rumble', $user->mmr_rumble) }}" min="0" max="3000" placeholder="bijv. 1000">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_dropshot">Dropshot</label>
                        <input type="number" id="mmr_dropshot" name="mmr_dropshot" value="{{ old('mmr_dropshot', $user->mmr_dropshot) }}" min="0" max="3000" placeholder="bijv. 1000">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_snowday">Snow Day</label>
                        <input type="number" id="mmr_snowday" name="mmr_snowday" value="{{ old('mmr_snowday', $user->mmr_snowday) }}" min="0" max="3000" placeholder="bijv. 1000">
                        <small>MMR tussen 0-3000</small>
                    </div>

                    <div class="form-group">
                        <label for="mmr_tournament">Tournament</label>
                        <input type="number" id="mmr_tournament" name="mmr_tournament" value="{{ old('mmr_tournament', $user->mmr_tournament) }}" min="0" max="3000" placeholder="bijv. 1000">
                        <small>MMR tussen 0-3000</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="profile_photo">Profielfoto</label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/jpg,image/gif">
                    <small>Max 2MB. Ondersteunde formaten: JPG, PNG, GIF</small>

                    <div class="photo-preview">
                        <img src="{{ $user->profile_photo_url }}" alt="Huidige profielfoto" id="photoPreview">
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ route('profile.show', $user) }}" class="btn btn-secondary">Annuleren</a>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Character counter voor about_me
    const aboutMeTextarea = document.getElementById('about_me');
    const charCount = document.getElementById('charCount');

    aboutMeTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length + '/1000 tekens';
    });

    // Photo preview
    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Valideer bestandstype
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Alleen JPG, PNG en GIF bestanden zijn toegestaan.');
                this.value = '';
                return;
            }

            // Valideer bestandsgrootte (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Bestand is te groot. Maximum grootte is 2MB.');
                this.value = '';
                return;
            }

            // Toon preview
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Client-side validatie
    document.getElementById('profileEditForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const birthday = document.getElementById('birthday').value;
        let isValid = true;
        let errors = [];

        // Naam validatie
        if (name.length < 2) {
            isValid = false;
            errors.push('Naam moet minimaal 2 tekens bevatten.');
        }

        // Email validatie
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            isValid = false;
            errors.push('Voer een geldig e-mailadres in.');
        }

        // Verjaardag validatie (moet in het verleden zijn)
        if (birthday) {
            const birthdayDate = new Date(birthday);
            const today = new Date();
            if (birthdayDate >= today) {
                isValid = false;
                errors.push('Verjaardag moet in het verleden liggen.');
            }
        }

        // MMR validatie
        const mmrFields = ['mmr_1v1', 'mmr_2v2', 'mmr_3v3', 'mmr_hoops', 'mmr_rumble', 'mmr_dropshot', 'mmr_snowday'];
        mmrFields.forEach(field => {
            const value = document.getElementById(field).value;
            if (value !== '' && (value < 0 || value > 3000 || !Number.isInteger(Number(value)))) {
                isValid = false;
                errors.push(`${field.replace('mmr_', '').toUpperCase()} MMR moet een geheel getal tussen 0 en 3000 zijn.`);
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>
@endsection
