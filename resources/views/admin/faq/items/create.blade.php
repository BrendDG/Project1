@extends('layouts.admin')

@section('title', 'Nieuw FAQ Item')
@section('page-title', 'Nieuw FAQ Item Aanmaken')

@section('content')
@if($categories->isEmpty())
<div style="background: #ef4444; color: #fff; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
    <h4 style="margin-bottom: 0.5rem;">⚠️ Geen categorieën beschikbaar</h4>
    <p style="margin-bottom: 1rem;">Je moet eerst minstens één FAQ categorie aanmaken voordat je FAQ items kunt toevoegen.</p>
    <a href="{{ route('admin.faq.categories.create') }}" class="btn" style="background: #fff; color: #ef4444;">
        ➕ Maak Categorie Aan
    </a>
</div>
@else
<div class="card">
    <div class="card-header">
        <h3>Nieuw FAQ Item</h3>
    </div>

    <form method="POST" action="{{ route('admin.faq.items.store') }}" id="createFaqForm">
        @csrf

        <div class="form-group">
            <label for="faq_category_id">Categorie <span style="color: #ef4444;">*</span></label>
            <select
                id="faq_category_id"
                name="faq_category_id"
                class="form-control @error('faq_category_id') error @enderror"
                required
            >
                <option value="">Selecteer een categorie</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('faq_category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('faq_category_id')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="question">Vraag <span style="color: #ef4444;">*</span></label>
            <input
                type="text"
                id="question"
                name="question"
                class="form-control @error('question') error @enderror"
                value="{{ old('question') }}"
                maxlength="500"
                required
            >
            <small style="color: #9095a0;">Maximaal 500 karakters</small>
            @error('question')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="answer">Antwoord <span style="color: #ef4444;">*</span></label>
            <textarea
                id="answer"
                name="answer"
                class="form-control @error('answer') error @enderror"
                rows="6"
                required
            >{{ old('answer') }}</textarea>
            @error('answer')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="order">Volgorde <span style="color: #ef4444;">*</span></label>
            <input
                type="number"
                id="order"
                name="order"
                class="form-control @error('order') error @enderror"
                value="{{ old('order', 0) }}"
                min="0"
                required
            >
            <small style="color: #9095a0;">Een lager nummer betekent dat het item hoger in de lijst staat binnen de categorie</small>
            @error('order')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ FAQ Item Aanmaken</button>
            <a href="{{ route('admin.faq.items') }}" class="btn btn-secondary">✗ Annuleren</a>
        </div>
    </form>
</div>
@endif
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('createFaqForm')?.addEventListener('submit', function(e) {
        let valid = true;
        let errors = [];

        // Categorie validatie
        const category = document.getElementById('faq_category_id').value;
        if (!category) {
            valid = false;
            errors.push('Selecteer een categorie');
        }

        // Vraag validatie
        const question = document.getElementById('question').value.trim();
        if (question.length === 0) {
            valid = false;
            errors.push('Vraag is verplicht');
        } else if (question.length > 500) {
            valid = false;
            errors.push('Vraag mag niet langer dan 500 karakters zijn');
        }

        // Antwoord validatie
        const answer = document.getElementById('answer').value.trim();
        if (answer.length === 0) {
            valid = false;
            errors.push('Antwoord is verplicht');
        }

        // Volgorde validatie
        const order = document.getElementById('order').value;
        if (order === '' || parseInt(order) < 0) {
            valid = false;
            errors.push('Volgorde moet een positief getal zijn');
        }

        if (!valid) {
            e.preventDefault();
            alert('Er zijn validatiefouten:\n\n' + errors.join('\n'));
        }
    });
</script>
@endsection
