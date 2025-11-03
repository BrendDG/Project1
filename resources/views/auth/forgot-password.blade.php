@extends('layouts.auth')

@section('title', 'Wachtwoord vergeten - Rocket League Tracker')

@section('content')
    <h1>Wachtwoord vergeten</h1>
    <p class="subtitle">We sturen je een reset link naar je e-mail</p>

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

    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
        @csrf

        <div class="form-group">
            <label for="email">E-mailadres</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit" class="btn btn-primary">Verstuur reset link</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Terug naar login</a>
    </div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Voer een geldig e-mailadres in.');
        }
    });
</script>
@endsection
