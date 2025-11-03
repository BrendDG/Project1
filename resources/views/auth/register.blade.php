@extends('layouts.auth')

@section('title', 'Registreren - Rocket League Tracker')

@section('content')
    <h1>Registreren</h1>
    <p class="subtitle">Word lid van onze community!</p>

    @if ($errors->any())
        <div class="error" style="margin-bottom: 1.5rem;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div class="form-group">
            <label for="name">Naam</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>
            <small style="color: #9095a0; font-size: 0.875rem;">Minimaal 8 tekens</small>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Bevestig wachtwoord</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Registreren</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Al een account? Log hier in</a>
    </div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
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

        // Password validatie
        if (password.length < 8) {
            isValid = false;
            errors.push('Wachtwoord moet minimaal 8 tekens bevatten.');
        }

        // Password confirmation validatie
        if (password !== passwordConfirmation) {
            isValid = false;
            errors.push('Wachtwoorden komen niet overeen.');
        }

        if (!isValid) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>
@endsection
