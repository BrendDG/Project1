@extends('layouts.admin')

@section('title', 'Nieuws Beheer')
@section('page-title', 'Nieuws Beheer')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Alle Nieuwsitems</h3>
        <a href="{{ route('admin.nieuws.create') }}" class="btn btn-success">Nieuw Nieuwsitem</a>
    </div>

    <!-- Zoeken en Filteren -->
    <form method="GET" action="{{ route('admin.nieuws') }}" style="margin-bottom: 1.5rem;">
        <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Zoek op titel of inhoud..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <select name="status_filter" class="form-control">
                    <option value="">Alle items</option>
                    <option value="published" {{ request('status_filter') === 'published' ? 'selected' : '' }}>Gepubliceerd</option>
                    <option value="scheduled" {{ request('status_filter') === 'scheduled' ? 'selected' : '' }}>Gepland</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Zoeken</button>
                @if(request()->hasAny(['search', 'status_filter']))
                    <a href="{{ route('admin.nieuws') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Nieuws Tabel -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titel</th>
                    <th>Afbeelding</th>
                    <th>Publicatiedatum</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nieuwsItems as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ Str::limit($item->title, 50) }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span style="color: #9095a0;">Geen afbeelding</span>
                            @endif
                        </td>
                        <td>{{ $item->published_at->format('d-m-Y H:i') }}</td>
                        <td>
                            @if($item->published_at <= now())
                                <span class="badge" style="background: #10b981; color: #fff;">Gepubliceerd</span>
                            @else
                                <span class="badge" style="background: #f59e0b; color: #000;">Gepland</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('nieuws.show', $item) }}" class="btn btn-secondary btn-sm" target="_blank" title="Bekijken">Bekijken</a>
                                <a href="{{ route('admin.nieuws.edit', $item) }}" class="btn btn-primary btn-sm" title="Bewerken">Bewerken</a>

                                <form method="POST" action="{{ route('admin.nieuws.destroy', $item) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Weet je zeker dat je dit nieuwsitem wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')"
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
                        <td colspan="6" style="text-align: center; color: #9095a0;">
                            @if(request()->hasAny(['search', 'status_filter']))
                                Geen nieuwsitems gevonden met deze zoekcriteria.
                            @else
                                Geen nieuwsitems gevonden.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginatie -->
    @if($nieuwsItems->hasPages())
        <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
            @if($nieuwsItems->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">« Vorige</span>
            @else
                <a href="{{ $nieuwsItems->previousPageUrl() }}" class="btn btn-secondary btn-sm">« Vorige</a>
            @endif

            <span style="padding: 0.5rem 1rem; color: #9095a0;">
                Pagina {{ $nieuwsItems->currentPage() }} van {{ $nieuwsItems->lastPage() }}
            </span>

            @if($nieuwsItems->hasMorePages())
                <a href="{{ $nieuwsItems->nextPageUrl() }}" class="btn btn-secondary btn-sm">Volgende »</a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">Volgende »</span>
            @endif
        </div>
    @endif
</div>
@endsection
