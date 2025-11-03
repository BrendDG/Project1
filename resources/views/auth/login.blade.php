@extends('layouts.auth')

@section('title', 'Inloggen - Rocket League Tracker')

@section('content')
    <h1>Inloggen</h1>
    <p class="subtitle">Welkom terug bij de community!</p>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error" style="margin-bottom: 1.5rem;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="form-group">
            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Onthoud mij</label>
        </div>

        <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>

    <div class="links">
        <a href="{{ route('password.request') }}">Wachtwoord vergeten?</a>
        <div class="divider">of</div>
        <a href="{{ route('register') }}">Nog geen account? Registreer hier</a>
    </div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        let isValid = true;
        let errors = [];

        // Email validatie
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            isValid = false;
            errors.push('Voer een geldig e-mailadres in.');
        }

        // Password validatie
        if (password.length < 1) {
            isValid = false;
            errors.push('Voer een wachtwoord in.');
        }

        if (!isValid) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>
@endsection
