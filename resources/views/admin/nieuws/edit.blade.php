@extends('layouts.admin')

@section('title', 'Nieuwsitem Bewerken')
@section('page-title', 'Nieuwsitem Bewerken')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Nieuwsitem Bewerken: {{ $nieuws->title }}</h3>
    </div>

    <form method="POST" action="{{ route('admin.nieuws.update', $nieuws) }}" enctype="multipart/form-data" id="editNieuwsForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Titel <span style="color: #ef4444;">*</span></label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control @error('title') error @enderror"
                value="{{ old('title', $nieuws->title) }}"
                required
            >
            @error('title')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Inhoud <span style="color: #ef4444;">*</span></label>
            <textarea
                id="content"
                name="content"
                class="form-control @error('content') error @enderror"
                rows="10"
                required
            >{{ old('content', $nieuws->content) }}</textarea>
            @error('content')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Afbeelding</label>

            @if($nieuws->image)
                <div style="margin-bottom: 1rem;">
                    <p style="color: #9095a0; margin-bottom: 0.5rem;">Huidige afbeelding:</p>
                    <img src="{{ asset('storage/' . $nieuws->image) }}" alt="{{ $nieuws->title }}" style="max-width: 300px; border-radius: 8px; border: 1px solid #2a3150;">
                </div>
            @endif

            <input
                type="file"
                id="image"
                name="image"
                class="form-control @error('image') error @enderror"
                accept="image/jpeg,image/jpg,image/png,image/gif"
            >
            <small style="color: #9095a0;">Laat leeg om de huidige afbeelding te behouden. Toegestane formaten: JPG, PNG, GIF (max 2MB)</small>
            @error('image')
                <span class="error-message">{{ $message }}</span>
            @enderror
            <div id="imagePreview" style="margin-top: 1rem; display: none;">
                <p style="color: #9095a0; margin-bottom: 0.5rem;">Nieuwe afbeelding:</p>
                <img id="previewImg" src="" alt="Preview" style="max-width: 300px; border-radius: 8px; border: 1px solid #2a3150;">
            </div>
        </div>

        <div class="form-group">
            <label for="published_at">Publicatiedatum <span style="color: #ef4444;">*</span></label>
            <input
                type="datetime-local"
                id="published_at"
                name="published_at"
                class="form-control @error('published_at') error @enderror"
                value="{{ old('published_at', $nieuws->published_at->format('Y-m-d\TH:i')) }}"
                required
            >
            <small style="color: #9095a0;">Het nieuwsitem wordt zichtbaar vanaf deze datum en tijd</small>
            @error('published_at')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">✓ Opslaan</button>
            <a href="{{ route('admin.nieuws') }}" class="btn btn-secondary">✗ Annuleren</a>

            <button
                type="button"
                onclick="if(confirm('Weet je zeker dat je dit nieuwsitem wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) { document.getElementById('deleteForm').submit(); }"
                class="btn btn-danger"
                style="margin-left: auto;"
            >
                🗑️ Verwijderen
            </button>
        </div>
    </form>

    <form id="deleteForm" method="POST" action="{{ route('admin.nieuws.destroy', $nieuws) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<!-- Nieuwsitem Info -->
<div class="card">
    <div class="card-header">
        <h3>Nieuwsitem Informatie</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="padding: 0.75rem; color: #9095a0; width: 200px;"><strong>ID</strong></td>
            <td style="padding: 0.75rem;">{{ $nieuws->id }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Status</strong></td>
            <td style="padding: 0.75rem;">
                @if($nieuws->published_at <= now())
                    <span class="badge" style="background: #10b981; color: #fff;">Gepubliceerd</span>
                @else
                    <span class="badge" style="background: #f59e0b; color: #000;">Gepland voor {{ $nieuws->published_at->format('d-m-Y H:i') }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Aangemaakt op</strong></td>
            <td style="padding: 0.75rem;">{{ $nieuws->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Laatst bijgewerkt</strong></td>
            <td style="padding: 0.75rem;">{{ $nieuws->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Publieke weergave</strong></td>
            <td style="padding: 0.75rem;">
                <a href="{{ route('nieuws.show', $nieuws) }}" target="_blank" class="btn btn-primary btn-sm">
                    👁️ Bekijk Nieuwsitem
                </a>
            </td>
        </tr>
    </table>
</div>
@endsection

@section('scripts')
<script>
    // Client-side validatie
    document.getElementById('editNieuwsForm').addEventListener('submit', function(e) {
        let valid = true;
        let errors = [];

        // Titel validatie
        const title = document.getElementById('title').value.trim();
        if (title.length === 0) {
            valid = false;
            errors.push('Titel is verplicht');
        }

        // Inhoud validatie
        const content = document.getElementById('content').value.trim();
        if (content.length === 0) {
            valid = false;
            errors.push('Inhoud is verplicht');
        }

        // Publicatiedatum validatie
        const publishedAt = document.getElementById('published_at').value;
        if (!publishedAt) {
            valid = false;
            errors.push('Publicatiedatum is verplicht');
        }

        // Afbeelding validatie (alleen als nieuwe afbeelding geüpload wordt)
        const imageInput = document.getElementById('image');
        if (imageInput.files.length > 0) {
            const file = imageInput.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

            if (file.size > maxSize) {
                valid = false;
                errors.push('Afbeelding is te groot (max 2MB)');
            }

            if (!allowedTypes.includes(file.type)) {
                valid = false;
                errors.push('Afbeelding moet JPG, PNG of GIF zijn');
            }
        }

        if (!valid) {
            e.preventDefault();
            alert('Er zijn validatiefouten:\n\n' + errors.join('\n'));
        }
    });

    // Afbeelding preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('imagePreview');
                const img = document.getElementById('previewImg');
                img.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
