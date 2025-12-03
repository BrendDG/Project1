@extends('layouts.admin')

@section('title', 'FAQ Items')
@section('page-title', 'FAQ Items Beheer')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>FAQ Items</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.faq.categories') }}" class="btn btn-secondary"> Categorieën</a>
            <a href="{{ route('admin.faq.items.create') }}" class="btn btn-success"> Nieuw FAQ Item</a>
        </div>
    </div>

    <!-- Zoeken en Filteren -->
    <form method="GET" action="{{ route('admin.faq.items') }}" style="margin-bottom: 1.5rem;">
        <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Zoek op vraag of antwoord..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <select name="category_filter" class="form-control">
                    <option value="">Alle categorieën</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_filter') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Zoeken</button>
                @if(request()->hasAny(['search', 'category_filter']))
                    <a href="{{ route('admin.faq.items') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <!-- FAQ Items Tabel -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vraag</th>
                    <th>Categorie</th>
                    <th>Volgorde</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><strong>{{ Str::limit($item->question, 80) }}</strong></td>
                        <td>
                            <span class="badge" style="background: #6366f1; color: #fff;">
                                {{ $item->category->name }}
                            </span>
                        </td>
                        <td>{{ $item->order }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.faq.items.edit', $item) }}" class="btn btn-primary btn-sm" title="Bewerken">Bewerken</a>

                                <form method="POST" action="{{ route('admin.faq.items.destroy', $item) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Weet je zeker dat je dit FAQ item wilt verwijderen?')"
                                        title="Verwijderen"
                                    >
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #9095a0;">
                            @if(request()->hasAny(['search', 'category_filter']))
                                Geen FAQ items gevonden met deze zoekcriteria.
                            @else
                                Geen FAQ items gevonden.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginatie -->
    @if($items->hasPages())
        <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
            @if($items->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">« Vorige</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="btn btn-secondary btn-sm">« Vorige</a>
            @endif

            <span style="padding: 0.5rem 1rem; color: #9095a0;">
                Pagina {{ $items->currentPage() }} van {{ $items->lastPage() }}
            </span>

            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="btn btn-secondary btn-sm">Volgende »</a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">Volgende »</span>
            @endif
        </div>
    @endif
</div>

@if($categories->isEmpty())
<div style="background: #f59e0b; color: #000; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem;">
    <h4 style="margin-bottom: 0.5rem;"> Geen categorieën gevonden</h4>
    <p style="margin-bottom: 1rem;">Je moet eerst minstens één FAQ categorie aanmaken voordat je FAQ items kunt toevoegen.</p>
    <a href="{{ route('admin.faq.categories.create') }}" class="btn" style="background: #000; color: #fff;">
         Maak Eerste Categorie Aan
    </a>
</div>
@endif
@endsection
