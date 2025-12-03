@extends('layouts.admin')

@section('title', 'Nieuwe FAQ Categorie')
@section('page-title', 'Nieuwe FAQ Categorie Aanmaken')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Nieuwe FAQ Categorie</h3>
    </div>

    <form method="POST" action="{{ route('admin.faq.categories.store') }}" id="createCategoryForm">
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
            <small style="color: #9095a0;">Een lager nummer betekent dat de categorie hoger in de lijst staat</small>
            @error('order')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ Categorie Aanmaken</button>
            <a href="{{ route('admin.faq.categories') }}" class="btn btn-secondary">✗ Annuleren</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('createCategoryForm').addEventListener('submit', function(e) {
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
