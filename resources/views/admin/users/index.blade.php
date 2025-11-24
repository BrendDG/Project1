@extends('layouts.admin')

@section('title', 'Gebruikers Beheer')
@section('page-title', 'Gebruikers Beheer')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Alle Gebruikers</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">➕ Nieuwe Gebruiker</a>
    </div>

    <!-- Zoeken en Filteren -->
    <form method="GET" action="{{ route('admin.users') }}" style="margin-bottom: 1.5rem;">
        <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Zoek op naam, email of username..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <select name="admin_filter" class="form-control">
                    <option value="">Alle gebruikers</option>
                    <option value="admins" {{ request('admin_filter') === 'admins' ? 'selected' : '' }}>Alleen Admins</option>
                    <option value="users" {{ request('admin_filter') === 'users' ? 'selected' : '' }}>Alleen Gebruikers</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Zoeken</button>
                @if(request()->hasAny(['search', 'admin_filter']))
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Gebruikers Tabel -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Geregistreerd</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username ?? '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge badge-admin">Admin</span>
                            @else
                                <span class="badge badge-user">Gebruiker</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('profile.show', $user) }}" class="btn btn-secondary btn-sm" target="_blank">👁️</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">✏️</a>

                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" style="display: inline;">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="btn {{ $user->is_admin ? 'btn-warning' : 'btn-success' }} btn-sm"
                                            onclick="return confirm('Weet je zeker dat je de admin status van {{ $user->name }} wilt wijzigen?')"
                                        >
                                            {{ $user->is_admin ? '⬇️' : '⬆️' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Weet je zeker dat je {{ $user->name }} wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')"
                                        >
                                            🗑️
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #9095a0;">
                            @if(request()->hasAny(['search', 'admin_filter']))
                                Geen gebruikers gevonden met deze zoekcriteria.
                            @else
                                Geen gebruikers gevonden.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginatie -->
    @if($users->hasPages())
        <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.5rem;">
            {{-- Vorige pagina --}}
            @if($users->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">« Vorige</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="btn btn-secondary btn-sm">« Vorige</a>
            @endif

            {{-- Pagina nummers --}}
            <span style="padding: 0.5rem 1rem; color: #9095a0;">
                Pagina {{ $users->currentPage() }} van {{ $users->lastPage() }}
            </span>

            {{-- Volgende pagina --}}
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="btn btn-secondary btn-sm">Volgende »</a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity: 0.5; cursor: not-allowed;">Volgende »</span>
            @endif
        </div>
    @endif
</div>
@endsection
