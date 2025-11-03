@extends('layouts.auth')

@section('title', 'Wachtwoord resetten - Rocket League Tracker')

@section('content')
    <h1>Wachtwoord resetten</h1>
    <p class="subtitle">Voer je nieuwe wachtwoord in</p>

    @if ($errors->any())
        <div class="error" style="margin-bottom: 1.5rem;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

        <div class="form-group">
            <label for="email">E-mailadres</label>
            <input type="email" id="email" value="{{ $email ?? old('email') }}" disabled>
        </div>

        <div class="form-group">
            <label for="password">Nieuw wachtwoord</label>
            <input type="password" id="password" name="password" required autofocus>
            <small style="color: #9095a0; font-size: 0.875rem;">Minimaal 8 tekens</small>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Bevestig nieuw wachtwoord</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Wachtwoord resetten</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Terug naar login</a>
    </div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        let isValid = true;
        let errors = [];

        if (password.length < 8) {
            isValid = false;
            errors.push('Wachtwoord moet minimaal 8 tekens bevatten.');
        }

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
