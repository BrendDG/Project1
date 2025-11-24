@extends('layouts.admin')

@section('title', 'FAQ Categorie Bewerken')
@section('page-title', 'FAQ Categorie Bewerken')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Categorie Bewerken: {{ $category->name }}</h3>
    </div>

    <form method="POST" action="{{ route('admin.faq.categories.update', $category) }}" id="editCategoryForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Naam <span style="color: #ef4444;">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') error @enderror"
                value="{{ old('name', $category->name) }}"
                required
            >
            @error('name')
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
                value="{{ old('order', $category->order) }}"
                min="0"
                required
            >
            <small style="color: #9095a0;">Een lager nummer betekent dat de categorie hoger in de lijst staat</small>
            @error('order')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ Opslaan</button>
            <a href="{{ route('admin.faq.categories') }}" class="btn btn-secondary">✗ Annuleren</a>

            <button
                type="button"
                onclick="if(confirm('Weet je zeker dat je deze categorie wilt verwijderen?{{ $category->faqItems()->count() > 0 ? '\n\nLET OP: Deze categorie bevat nog ' . $category->faqItems()->count() . ' items!' : '' }}')) { document.getElementById('deleteForm').submit(); }"
                class="btn btn-danger"
                style="margin-left: auto;"
            >
                🗑️ Verwijderen
            </button>
        </div>
    </form>

    <form id="deleteForm" method="POST" action="{{ route('admin.faq.categories.destroy', $category) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<!-- Categorie Info -->
<div class="card">
    <div class="card-header">
        <h3>Categorie Informatie</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="padding: 0.75rem; color: #9095a0; width: 200px;"><strong>ID</strong></td>
            <td style="padding: 0.75rem;">{{ $category->id }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Aantal FAQ Items</strong></td>
            <td style="padding: 0.75rem;">
                <span class="badge" style="background: #6366f1; color: #fff;">
                    {{ $category->faqItems()->count() }} items
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Aangemaakt op</strong></td>
            <td style="padding: 0.75rem;">{{ $category->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Laatst bijgewerkt</strong></td>
            <td style="padding: 0.75rem;">{{ $category->updated_at->format('d-m-Y H:i:s') }}</td>
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
    document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
        let valid = true;
        let errors = [];

        // Naam validatie
        const name = document.getElementById('name').value.trim();
        if (name.length === 0) {
            valid = false;
            errors.push('Naam is verplicht');
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
