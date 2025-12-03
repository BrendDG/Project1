@extends('layouts.admin')

@section('title', 'FAQ Item Bewerken')
@section('page-title', 'FAQ Item Bewerken')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>FAQ Item Bewerken</h3>
    </div>

    <form method="POST" action="{{ route('admin.faq.items.update', $item) }}" id="editFaqForm">
        @csrf
        @method('PUT')

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
                    <option value="{{ $cat->id }}" {{ old('faq_category_id', $item->faq_category_id) == $cat->id ? 'selected' : '' }}>
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
                value="{{ old('question', $item->question) }}"
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
            >{{ old('answer', $item->answer) }}</textarea>
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
                value="{{ old('order', $item->order) }}"
                min="0"
                required
            >
            <small style="color: #9095a0;">Een lager nummer betekent dat het item hoger in de lijst staat binnen de categorie</small>
            @error('order')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ Opslaan</button>
            <a href="{{ route('admin.faq.items') }}" class="btn btn-secondary">✗ Annuleren</a>

            <button
                type="button"
                onclick="if(confirm('Weet je zeker dat je dit FAQ item wilt verwijderen?')) { document.getElementById('deleteForm').submit(); }"
                class="btn btn-danger"
                style="margin-left: auto;"
            >
                🗑️ Verwijderen
            </button>
        </div>
    </form>

    <form id="deleteForm" method="POST" action="{{ route('admin.faq.items.destroy', $item) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<!-- FAQ Item Info -->
<div class="card">
    <div class="card-header">
        <h3>FAQ Item Informatie</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="padding: 0.75rem; color: #9095a0; width: 200px;"><strong>ID</strong></td>
            <td style="padding: 0.75rem;">{{ $item->id }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Categorie</strong></td>
            <td style="padding: 0.75rem;">
                <span class="badge" style="background: #6366f1; color: #fff;">
                    {{ $item->category->name }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Aangemaakt op</strong></td>
            <td style="padding: 0.75rem;">{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Laatst bijgewerkt</strong></td>
            <td style="padding: 0.75rem;">{{ $item->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Publieke weergave</strong></td>
            <td style="padding: 0.75rem;">
                <a href="{{ route('faq.index') }}" target="_blank" class="btn btn-primary btn-sm">
                    👁️ Bekijk FAQ Pagina
                </a>
            </td>
        </tr>
    </table>
</div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('editFaqForm').addEventListener('submit', function(e) {
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
