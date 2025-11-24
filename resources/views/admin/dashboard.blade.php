@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Stats Cards -->
    <div class="card" style="text-align: center;">
        <h3 style="color: #4a9eff; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalUsers }}</h3>
        <p style="color: #9095a0;">Totaal Gebruikers</p>
    </div>

    <div class="card" style="text-align: center;">
        <h3 style="color: #f59e0b; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalAdmins }}</h3>
        <p style="color: #9095a0;">Admins</p>
    </div>

    <div class="card" style="text-align: center;">
        <h3 style="color: #10b981; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalUsers - $totalAdmins }}</h3>
        <p style="color: #9095a0;">Normale Gebruikers</p>
    </div>
</div>

<!-- Recent Users -->
<div class="card">
    <div class="card-header">
        <h3>Recente Gebruikers</h3>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Geregistreerd op</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge badge-admin">Admin</span>
                            @else
                                <span class="badge badge-user">Gebruiker</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">Bewerken</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #9095a0;">Geen gebruikers gevonden</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem; text-align: center;">
        <a href="{{ route('admin.users') }}" class="btn btn-primary">Bekijk Alle Gebruikers</a>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h3>Snelle Acties</h3>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            ➕ Nieuwe Gebruiker
        </a>
        <a href="{{ route('admin.users') }}" class="btn btn-primary">
            👥 Alle Gebruikers
        </a>
        <a href="{{ route('home') }}" class="btn btn-secondary">
            🏠 Terug naar Site
        </a>
    </div>
</div>
@endsection
