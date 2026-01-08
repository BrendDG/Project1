@extends('layouts.app')

@section('title', 'Nieuw bericht')

@section('styles')
<style>
    .create-message-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .create-message-header {
        margin-bottom: 2rem;
    }

    .create-message-header h1 {
        color: #4a9eff;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .create-message-header p {
        color: #9095a0;
    }

    .form-card {
        background: #0f1220;
        border: 1px solid #2a3150;
        border-radius: 8px;
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #e0e0e0;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-group label.required::after {
        content: " *";
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
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    select.form-control {
        cursor: pointer;
    }

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #2a3150;
    }

    .char-count {
        text-align: right;
        color: #9095a0;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .char-count.warning {
        color: #f59e0b;
    }

    .char-count.danger {
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="create-message-container">
    <div class="create-message-header">
        <h1>Nieuw bericht</h1>
        <p>Stuur een privébericht naar een andere gebruiker</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('messages.store') }}" id="messageForm">
            @csrf

            <div class="form-group">
                <label for="receiver_id" class="required">Ontvanger</label>
                <select name="receiver_id" id="receiver_id" class="form-control" required>
                    <option value="">Selecteer een ontvanger...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ (old('receiver_id', $recipient?->id) == $user->id) ? 'selected' : '' }}>
                            {{ $user->display_name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('receiver_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject" class="required">Onderwerp</label>
                <input
                    type="text"
                    name="subject"
                    id="subject"
                    class="form-control"
                    value="{{ old('subject') }}"
                    placeholder="Voer een onderwerp in..."
                    minlength="3"
                    maxlength="255"
                    required>
                @error('subject')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="char-count">
                    <span id="subjectCount">0</span> / 255 karakters
                </div>
            </div>

            <div class="form-group">
                <label for="message" class="required">Bericht</label>
                <textarea
                    name="message"
                    id="message"
                    class="form-control"
                    placeholder="Schrijf je bericht hier..."
                    minlength="10"
                    maxlength="5000"
                    required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="char-count">
                    <span id="messageCount">0</span> / 5000 karakters
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('messages.index') }}" class="btn btn-secondary">Annuleren</a>
                <button type="submit" class="btn btn-primary">Verzenden</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Client-side validation en character counting
    document.addEventListener('DOMContentLoaded', function() {
        const subjectInput = document.getElementById('subject');
        const messageInput = document.getElementById('message');
        const subjectCount = document.getElementById('subjectCount');
        const messageCount = document.getElementById('messageCount');
        const form = document.getElementById('messageForm');

        // Update character counts
        function updateCharCount(input, countElement, maxLength) {
            const length = input.value.length;
            countElement.textContent = length;

            const parent = countElement.parentElement;
            parent.classList.remove('warning', 'danger');

            if (length > maxLength * 0.9) {
                parent.classList.add('danger');
            } else if (length > maxLength * 0.75) {
                parent.classList.add('warning');
            }
        }

        subjectInput.addEventListener('input', function() {
            updateCharCount(this, subjectCount, 255);
        });

        messageInput.addEventListener('input', function() {
            updateCharCount(this, messageCount, 5000);
        });

        // Initialize counts
        updateCharCount(subjectInput, subjectCount, 255);
        updateCharCount(messageInput, messageCount, 5000);

        // Form validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Validate receiver
            const receiverId = document.getElementById('receiver_id').value;
            if (!receiverId) {
                isValid = false;
                errorMessage += 'Selecteer een ontvanger.\n';
            }

            // Validate subject
            const subject = subjectInput.value.trim();
            if (subject.length < 3) {
                isValid = false;
                errorMessage += 'Onderwerp moet minimaal 3 karakters bevatten.\n';
            } else if (subject.length > 255) {
                isValid = false;
                errorMessage += 'Onderwerp mag maximaal 255 karakters bevatten.\n';
            }

            // Validate message
            const message = messageInput.value.trim();
            if (message.length < 10) {
                isValid = false;
                errorMessage += 'Bericht moet minimaal 10 karakters bevatten.\n';
            } else if (message.length > 5000) {
                isValid = false;
                errorMessage += 'Bericht mag maximaal 5000 karakters bevatten.\n';
            }

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>
@endsection
