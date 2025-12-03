@extends('layouts.admin')

@section('title', 'Nieuwe Gebruiker')
@section('page-title', 'Nieuwe Gebruiker Aanmaken')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Nieuwe Gebruiker</h3>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" id="createUserForm">
        @csrf

        <div class="form-group">
            <label for="name">Naam <span style="color: #ef4444;">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') error @enderror"
                value="{{ old('name') }}"
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
                value="{{ old('username') }}"
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
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord <span style="color: #ef4444;">*</span></label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') error @enderror"
                required
            >
            <small style="color: #9095a0;">Minimaal 8 karakters</small>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Bevestig Wachtwoord <span style="color: #ef4444;">*</span></label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <div class="form-group">
            <div class="form-check">
                <input
                    type="checkbox"
                    id="is_admin"
                    name="is_admin"
                    value="1"
                    {{ old('is_admin') ? 'checked' : '' }}
                >
                <label for="is_admin" style="margin-bottom: 0;">
                    <strong>Admin Rechten</strong> - Deze gebruiker kan andere gebruikers beheren
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ Gebruiker Aanmaken</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">✗ Annuleren</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('createUserForm').addEventListener('submit', function(e) {
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

        // Wachtwoord validatie
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        if (password.length < 8) {
            valid = false;
            errors.push('Wachtwoord moet minimaal 8 karakters bevatten');
        }

        if (password !== passwordConfirmation) {
            valid = false;
            errors.push('Wachtwoorden komen niet overeen');
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
</script>
@endsection
