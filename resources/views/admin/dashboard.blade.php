@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Stats Cards - Gebruikers -->
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

    <!-- Stats Cards - Nieuws -->
    <div class="card" style="text-align: center;">
        <h3 style="color: #6366f1; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalNieuws }}</h3>
        <p style="color: #9095a0;">Totaal Nieuwsitems</p>
    </div>

    <div class="card" style="text-align: center;">
        <h3 style="color: #10b981; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $publishedNieuws }}</h3>
        <p style="color: #9095a0;">Gepubliceerd</p>
    </div>

    <!-- Stats Cards - FAQ -->
    <div class="card" style="text-align: center;">
        <h3 style="color: #8b5cf6; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalFaqCategories }}</h3>
        <p style="color: #9095a0;">FAQ Categorieën</p>
    </div>

    <div class="card" style="text-align: center;">
        <h3 style="color: #ec4899; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalFaqItems }}</h3>
        <p style="color: #9095a0;">FAQ Items</p>
    </div>

    <!-- Stats Cards - Contact -->
    <div class="card" style="text-align: center;">
        <h3 style="color: #3b82f6; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalContactMessages }}</h3>
        <p style="color: #9095a0;">Totaal Berichten</p>
    </div>

    <div class="card" style="text-align: center;">
        <h3 style="color: {{ $unreadContactMessages > 0 ? '#ef4444' : '#10b981' }}; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $unreadContactMessages }}</h3>
        <p style="color: #9095a0;">Ongelezen</p>
    </div>

    <!-- Stats Cards - Tournaments -->
    <div class="card" style="text-align: center;">
        <h3 style="color: #fbbf24; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $totalTournaments }}</h3>
        <p style="color: #9095a0;">Totaal Toernooien</p>
    </div>

    <div class="card" style="text-align: center;">
        <h3 style="color: #10b981; font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $upcomingTournaments }}</h3>
        <p style="color: #9095a0;">Binnenkort</p>
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

<!-- Recent Nieuws -->
<div class="card">
    <div class="card-header">
        <h3>Recente Nieuwsitems</h3>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Status</th>
                    <th>Publicatiedatum</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentNieuws as $item)
                    <tr>
                        <td>{{ Str::limit($item->title, 60) }}</td>
                        <td>
                            @if($item->published_at <= now())
                                <span class="badge" style="background: #10b981; color: #fff;">Gepubliceerd</span>
                            @else
                                <span class="badge" style="background: #f59e0b; color: #000;">Gepland</span>
                            @endif
                        </td>
                        <td>{{ $item->published_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.nieuws.edit', $item) }}" class="btn btn-primary btn-sm">Bewerken</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #9095a0;">Geen nieuwsitems gevonden</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem; text-align: center;">
        <a href="{{ route('admin.nieuws') }}" class="btn btn-primary">Bekijk Alle Nieuwsitems</a>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h3>Snelle Acties</h3>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            Nieuwe Gebruiker
        </a>
        <a href="{{ route('admin.nieuws.create') }}" class="btn btn-success">
            Nieuw Nieuwsitem
        </a>
        <a href="{{ route('admin.faq.items.create') }}" class="btn btn-success">
            Nieuw FAQ Item
        </a>
        <a href="{{ route('admin.users') }}" class="btn btn-primary">
            Alle Gebruikers
        </a>
        <a href="{{ route('admin.nieuws') }}" class="btn btn-primary">
            Alle Nieuwsitems
        </a>
        <a href="{{ route('admin.faq.items') }}" class="btn btn-primary">
            FAQ Items
        </a>
        <a href="{{ route('admin.contact.messages') }}" class="btn btn-primary">
            Contact Berichten
            @if($unreadContactMessages > 0)
                <span style="background: #ef4444; color: #fff; padding: 0.15rem 0.5rem; border-radius: 10px; font-size: 0.75rem; margin-left: 0.25rem;">
                    {{ $unreadContactMessages }}
                </span>
            @endif
        </a>
        <a href="{{ route('home') }}" class="btn btn-secondary">
            Terug naar Site
        </a>
    </div>
</div>
@endsection
