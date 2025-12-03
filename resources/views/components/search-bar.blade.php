@props(['search' => '', 'placeholder' => 'Zoeken...', 'action' => ''])

<form method="GET" action="{{ $action }}" class="search-form" onsubmit="return validateSearch()">
    <div class="search-container">
        <input
            type="text"
            name="search"
            id="searchInput"
            value="{{ old('search', $search) }}"
            placeholder="{{ $placeholder }}"
            class="search-input"
            maxlength="255"
        >
        <button type="submit" class="search-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            Zoeken
        </button>
        @if($search)
            <a href="{{ $action }}" class="clear-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Wissen
            </a>
        @endif
    </div>
    <span id="searchError" class="error-message"></span>
</form>

<style>
    .search-form {
        width: 100%;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .search-container {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .search-input {
        flex: 1;
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        border: 2px solid #2a3150;
        border-radius: 8px;
        background: #0f1220;
        color: #e0e0e0;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #4a9eff;
        background: #151b2e;
    }

    .search-input::placeholder {
        color: #6b7280;
    }

    .search-button {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .search-button:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    .search-button svg {
        width: 18px;
        height: 18px;
    }

    .clear-search {
        padding: 0.875rem;
        background: #dc2626;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .clear-search:hover {
        background: #b91c1c;
        transform: translateY(-2px);
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
        min-height: 1.25rem;
    }

    @media (max-width: 640px) {
        .search-container {
            flex-wrap: wrap;
        }

        .search-input {
            width: 100%;
        }

        .search-button,
        .clear-search {
            flex: 1;
        }
    }
</style>

<script>
    function validateSearch() {
        const searchInput = document.getElementById('searchInput');
        const errorElement = document.getElementById('searchError');
        const value = searchInput.value.trim();

        // Clear previous error
        errorElement.textContent = '';
        searchInput.style.borderColor = '#2a3150';

        // Check if empty
        if (value.length === 0) {
            errorElement.textContent = 'Voer een zoekterm in';
            searchInput.style.borderColor = '#ef4444';
            searchInput.focus();
            return false;
        }

        // Check minimum length
        if (value.length < 2) {
            errorElement.textContent = 'Zoekterm moet minimaal 2 karakters bevatten';
            searchInput.style.borderColor = '#ef4444';
            searchInput.focus();
            return false;
        }

        // Check maximum length
        if (value.length > 255) {
            errorElement.textContent = 'Zoekterm mag maximaal 255 karakters bevatten';
            searchInput.style.borderColor = '#ef4444';
            searchInput.focus();
            return false;
        }

        return true;
    }

    // Real-time validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const errorElement = document.getElementById('searchError');

        searchInput.addEventListener('input', function() {
            const value = this.value.trim();

            if (value.length > 0 && value.length < 2) {
                errorElement.textContent = 'Minimaal 2 karakters vereist';
                this.style.borderColor = '#f59e0b';
            } else if (value.length > 255) {
                errorElement.textContent = 'Maximaal 255 karakters toegestaan';
                this.style.borderColor = '#ef4444';
            } else {
                errorElement.textContent = '';
                this.style.borderColor = '#2a3150';
            }
        });
    });
</script>
