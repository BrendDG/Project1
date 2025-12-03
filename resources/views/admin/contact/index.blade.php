@extends('layouts.admin')

@section('title', 'Contactberichten')
@section('page-title', 'Contactberichten')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3>Alle Contactberichten</h3>
            @if($unreadCount > 0)
                <span class="badge" style="background: #ef4444; color: #fff; margin-top: 0.5rem;">
                    {{ $unreadCount }} ongelezen {{ $unreadCount == 1 ? 'bericht' : 'berichten' }}
                </span>
            @endif
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('admin.contact.mark-all-read') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success">✓ Markeer Alles als Gelezen</button>
            </form>
        @endif
    </div>

    <!-- Zoeken en Filteren -->
    <form method="GET" action="{{ route('admin.contact.messages') }}" style="margin-bottom: 1.5rem;">
        <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Zoek op naam, email, onderwerp of bericht..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <select name="status_filter" class="form-control">
                    <option value="">Alle berichten</option>
                    <option value="unread" {{ request('status_filter') === 'unread' ? 'selected' : '' }}>Ongelezen</option>
                    <option value="read" {{ request('status_filter') === 'read' ? 'selected' : '' }}>Gelezen</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Zoeken</button>
                @if(request()->hasAny(['search', 'status_filter']))
                    <a href="{{ route('admin.contact.messages') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Berichten Tabel -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Van</th>
                    <th>Onderwerp</th>
                    <th>Ontvangen</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr style="{{ !$msg->is_read ? 'background: #1a2332; font-weight: 500;' : '' }}">
                        <td>
                            @if($msg->is_read)
                                <span class="badge" style="background: #6b7280; color: #fff;">Gelezen</span>
                            @else
                                <span class="badge" style="background: #ef4444; color: #fff;">Nieuw</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $msg->name }}</strong><br>
                            <a href="mailto:{{ $msg->email }}" style="color: #4a9eff; font-size: 0.875rem; text-decoration: none;">
                                {{ $msg->email }}
                            </a>
                        </td>
                        <td>
                            <strong>{{ Str::limit($msg->subject, 50) }}</strong><br>
                            <span style="color: #9095a0; font-size: 0.875rem;">
                                {{ Str::limit($msg->message, 80) }}
                            </span>
                        </td>
                        <td>{{ $msg->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.contact.show', $msg) }}" class="btn btn-primary btn-sm" title="Bekijken">
                                    Bekijken
                                </a>

                                <form method="POST" action="{{ route('admin.contact.toggle-read', $msg) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm" title="{{ $msg->is_read ? 'Markeer als ongelezen' : 'Markeer als gelezen' }}">
                                        {{ $msg->is_read ? '📭' : '📬' }}
                                    </button>
                                </form>

                                <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject) }}" class="btn btn-success btn-sm" title="Reageren">
                                    Reageren
                                </a>

                                <form method="POST" action="{{ route('admin.contact.destroy', $msg) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?')"
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
                            @if(request()->hasAny(['search', 'status_filter']))
                                Geen berichten gevonden met deze zoekcriteria.
                            @else
                                Geen contactberichten ontvangen.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginatie -->
    @if($messages->hasPages())
        <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
            @if($messages->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">« Vorige</span>
            @else
                <a href="{{ $messages->previousPageUrl() }}" class="btn btn-secondary btn-sm">« Vorige</a>
            @endif

            <span style="padding: 0.5rem 1rem; color: #9095a0;">
                Pagina {{ $messages->currentPage() }} van {{ $messages->lastPage() }}
            </span>

            @if($messages->hasMorePages())
                <a href="{{ $messages->nextPageUrl() }}" class="btn btn-secondary btn-sm">Volgende »</a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">Volgende »</span>
            @endif
        </div>
    @endif
</div>
@endsection
