@extends('layouts.app')

@section('title', 'Contact - Rocket League Community')

@section('styles')
<style>
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-header h1 {
        font-size: 3rem;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        font-size: 1.2rem;
        color: #a0aec0;
    }

    .contact-container {
        max-width: 700px;
        margin: 0 auto;
    }

    .contact-form {
        background: #0f1220;
        padding: 2.5rem;
        border-radius: 8px;
        border: 1px solid #2a3150;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #ffffff;
        font-weight: 500;
    }

    .form-group label .required {
        color: #ef4444;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        background: #1a1f35;
        border: 1px solid #2a3150;
        border-radius: 5px;
        color: #e0e0e0;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .form-control.error {
        border-color: #ef4444;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
        font-family: inherit;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        background: #3b82f6;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background: #2563eb;
    }

    .submit-btn:disabled {
        background: #4b5563;
        cursor: not-allowed;
    }

    .alert {
        padding: 1rem;
        border-radius: 5px;
        margin-bottom: 1.5rem;
        border: 1px solid;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border-color: #22c55e;
        color: #22c55e;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #ef4444;
    }

    .contact-info {
        margin-top: 3rem;
        text-align: center;
        color: #9095a0;
    }

    .contact-info h3 {
        color: #ffffff;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .contact-form {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1>💬 Contact</h1>
    <p>Heb je een vraag of opmerking? Laat het ons weten!</p>
</div>

<div class="contact-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Er zijn fouten opgetreden:</strong>
            <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="contact-form" id="contactForm" novalidate>
        @csrf

        <div class="form-group">
            <label for="name">
                Naam <span class="required">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
                maxlength="255"
            >
            <span class="error-message" id="name-error"></span>
        </div>

        <div class="form-group">
            <label for="email">
                Email <span class="required">*</span>
            </label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                maxlength="255"
            >
            <span class="error-message" id="email-error"></span>
        </div>

        <div class="form-group">
            <label for="subject">
                Onderwerp <span class="required">*</span>
            </label>
            <input
                type="text"
                id="subject"
                name="subject"
                class="form-control"
                value="{{ old('subject') }}"
                required
                maxlength="255"
            >
            <span class="error-message" id="subject-error"></span>
        </div>

        <div class="form-group">
            <label for="message">
                Bericht <span class="required">*</span>
            </label>
            <textarea
                id="message"
                name="message"
                class="form-control"
                required
                minlength="10"
                maxlength="5000"
            >{{ old('message') }}</textarea>
            <span class="error-message" id="message-error"></span>
            <small style="color: #9095a0; display: block; margin-top: 0.25rem;">
                Minimaal 10 karakters
            </small>
        </div>

        <button type="submit" class="submit-btn">Verstuur Bericht</button>
    </form>

    <div class="contact-info">
        <h3>Andere manieren om contact op te nemen</h3>
        <p>
            Je kunt ons ook vinden op onze social media kanalen<br>
            of join onze Discord community voor directe hulp!
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Client-side form validatie
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Reset errors
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('error');
        });
        document.querySelectorAll('.error-message').forEach(msg => {
            msg.classList.remove('show');
            msg.textContent = '';
        });

        // Validate name
        const name = document.getElementById('name');
        if (name.value.trim() === '') {
            showError('name', 'Naam is verplicht');
            isValid = false;
        }

        // Validate email
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value.trim() === '') {
            showError('email', 'Email is verplicht');
            isValid = false;
        } else if (!emailRegex.test(email.value)) {
            showError('email', 'Voer een geldig email adres in');
            isValid = false;
        }

        // Validate subject
        const subject = document.getElementById('subject');
        if (subject.value.trim() === '') {
            showError('subject', 'Onderwerp is verplicht');
            isValid = false;
        }

        // Validate message
        const message = document.getElementById('message');
        if (message.value.trim() === '') {
            showError('message', 'Bericht is verplicht');
            isValid = false;
        } else if (message.value.trim().length < 10) {
            showError('message', 'Bericht moet minimaal 10 karakters bevatten');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorMsg = document.getElementById(fieldId + '-error');

        field.classList.add('error');
        errorMsg.textContent = message;
        errorMsg.classList.add('show');
    }

    // Real-time validatie feedback
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('error');
                const errorMsg = document.getElementById(this.id + '-error');
                if (errorMsg) {
                    errorMsg.classList.remove('show');
                }
            }
        });
    });
</script>
@endsection
