@extends('layouts.admin')

@section('title', 'Gebruiker Bewerken')
@section('page-title', 'Gebruiker Bewerken')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Gebruiker Bewerken: {{ $user->name }}</h3>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" id="editUserForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Naam <span style="color: #ef4444;">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') error @enderror"
                value="{{ old('name', $user->name) }}"
                required
            >
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control @error('username') error @enderror"
                value="{{ old('username', $user->username) }}"
            >
            <small style="color: #9095a0;">Optioneel - Als je geen username opgeeft, wordt de naam gebruikt</small>
            @error('username')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email <span style="color: #ef4444;">*</span></label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') error @enderror"
                value="{{ old('email', $user->email) }}"
                required
            >
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div style="background: #151b2e; padding: 1.5rem; border-radius: 5px; margin-bottom: 1.5rem;">
            <p style="color: #9095a0; margin-bottom: 1rem;">
                <strong>Wachtwoord wijzigen:</strong> Laat leeg om het huidige wachtwoord te behouden
            </p>

            <div class="form-group">
                <label for="password">Nieuw Wachtwoord</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') error @enderror"
                >
                <small style="color: #9095a0;">Minimaal 8 karakters</small>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="password_confirmation">Bevestig Nieuw Wachtwoord</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                >
            </div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input
                    type="checkbox"
                    id="is_admin"
                    name="is_admin"
                    value="1"
                    {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                    @if($user->id === auth()->id() && $user->is_admin)
                        onchange="confirmSelfDemotion(this)"
                    @endif
                >
                <label for="is_admin" style="margin-bottom: 0;">
                    <strong>Admin Rechten</strong> - Deze gebruiker kan andere gebruikers beheren
                </label>
            </div>
            @if($user->id === auth()->id())
                <small style="color: #f59e0b; display: block; margin-top: 0.5rem;">
                    ⚠️ Let op: Je bewerkt je eigen account
                </small>
            @endif
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ Opslaan</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">✗ Annuleren</a>

            @if($user->id !== auth()->id())
                <button
                    type="button"
                    onclick="if(confirm('Weet je zeker dat je {{ $user->name }} wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) { document.getElementById('deleteForm').submit(); }"
                    class="btn btn-danger"
                    style="margin-left: auto;"
                >
                    🗑️ Verwijderen
                </button>
            @endif
        </div>
    </form>

    @if($user->id !== auth()->id())
        <form id="deleteForm" method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>

<!-- Gebruiker Info -->
<div class="card">
    <div class="card-header">
        <h3>Gebruiker Informatie</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="padding: 0.75rem; color: #9095a0; width: 200px;"><strong>ID</strong></td>
            <td style="padding: 0.75rem;">{{ $user->id }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Geregistreerd op</strong></td>
            <td style="padding: 0.75rem;">{{ $user->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Laatst bijgewerkt</strong></td>
            <td style="padding: 0.75rem;">{{ $user->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Profiel</strong></td>
            <td style="padding: 0.75rem;">
                <a href="{{ route('profile.show', $user) }}" target="_blank" class="btn btn-primary btn-sm">
                    👁️ Bekijk Profiel
                </a>
            </td>
        </tr>
    </table>
</div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        let valid = true;
        let errors = [];

        // Naam validatie
        const name = document.getElementById('name').value.trim();
        if (name.length === 0) {
            valid = false;
            errors.push('Naam is verplicht');
        }

        // Email validatie
        const email = document.getElementById('email').value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            valid = false;
            errors.push('Voer een geldig e-mailadres in');
        }

        // Wachtwoord validatie (alleen als ingevuld)
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        if (password.length > 0) {
            if (password.length < 8) {
                valid = false;
                errors.push('Wachtwoord moet minimaal 8 karakters bevatten');
            }

            if (password !== passwordConfirmation) {
                valid = false;
                errors.push('Wachtwoorden komen niet overeen');
            }
        }

        if (!valid) {
            e.preventDefault();
            alert('Er zijn validatiefouten:\n\n' + errors.join('\n'));
        }
    });

    // Real-time password match indicator
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    passwordConfirmation.addEventListener('input', function() {
        if (this.value.length > 0) {
            if (this.value === password.value) {
                this.style.borderColor = '#10b981';
            } else {
                this.style.borderColor = '#ef4444';
            }
        } else {
            this.style.borderColor = '#2a3150';
        }
    });

    // Waarschuwing bij het verwijderen van admin rechten van jezelf
    function confirmSelfDemotion(checkbox) {
        if (!checkbox.checked) {
            const confirmed = confirm('Je staat op het punt om je eigen admin rechten te verwijderen. Weet je dit zeker?');
            if (!confirmed) {
                checkbox.checked = true;
            }
        }
    }
</script>
@endsection
