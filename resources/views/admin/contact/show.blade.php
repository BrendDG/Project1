@extends('layouts.admin')

@section('title', 'Contactbericht')
@section('page-title', 'Contactbericht Details')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Contactbericht van {{ $message->name }}</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.contact.messages') }}" class="btn btn-secondary">← Terug naar Overzicht</a>
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn btn-success">
                ↩️ Reageer via Email
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div style="padding: 1.5rem; border-bottom: 1px solid #2a3150;">
        @if($message->is_read)
            <span class="badge" style="background: #6b7280; color: #fff;">✓ Gelezen</span>
        @else
            <span class="badge" style="background: #10b981; color: #fff;">✓ Nieuw - Nu Gelezen</span>
        @endif
        <span style="color: #9095a0; margin-left: 1rem;">
            Ontvangen op {{ $message->created_at->format('d-m-Y \o\m H:i') }}
        </span>
    </div>

    <!-- Afzender Informatie -->
    <div style="background: #151b2e; padding: 1.5rem; margin: 1.5rem; border-radius: 8px; border: 1px solid #2a3150;">
        <h4 style="color: #4a9eff; margin-bottom: 1rem;">Afzender Gegevens</h4>

        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div style="color: #9095a0; font-weight: 500;">Naam:</div>
            <div style="color: #e0e0e0; font-weight: 600;">{{ $message->name }}</div>
        </div>

        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div style="color: #9095a0; font-weight: 500;">Email:</div>
            <div>
                <a href="mailto:{{ $message->email }}" style="color: #4a9eff; text-decoration: none; font-weight: 600;">
                    {{ $message->email }}
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem;">
            <div style="color: #9095a0; font-weight: 500;">Onderwerp:</div>
            <div style="color: #e0e0e0; font-weight: 600;">{{ $message->subject }}</div>
        </div>
    </div>

    <!-- Bericht Inhoud -->
    <div style="padding: 1.5rem;">
        <h4 style="color: #4a9eff; margin-bottom: 1rem;">Bericht</h4>
        <div style="background: #0f1220; padding: 1.5rem; border-radius: 8px; border: 1px solid #2a3150; line-height: 1.8; white-space: pre-wrap; word-wrap: break-word;">{{ $message->message }}</div>
    </div>

    <!-- Acties -->
    <div style="padding: 1.5rem; border-top: 1px solid #2a3150; display: flex; gap: 1rem;">
        <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}&body={{ urlencode("\n\n---\nIn antwoord op je bericht:\n\n" . $message->message) }}" class="btn btn-success">
            📧 Reageer via Email
        </a>

        <form method="POST" action="{{ route('admin.contact.toggle-read', $message) }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">
                {{ $message->is_read ? '📭 Markeer als Ongelezen' : '📬 Markeer als Gelezen' }}
            </button>
        </form>

        <form method="POST" action="{{ route('admin.contact.destroy', $message) }}" style="display: inline; margin-left: auto;">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="btn btn-danger"
                onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?')"
            >
                🗑️ Verwijderen
            </button>
        </form>
    </div>
</div>

<!-- Bericht Metadata -->
<div class="card">
    <div class="card-header">
        <h3>Bericht Informatie</h3>
    </div>

    <table style="width: 100%;">
        <tr>
            <td style="padding: 0.75rem; color: #9095a0; width: 200px;"><strong>Bericht ID</strong></td>
            <td style="padding: 0.75rem;">{{ $message->id }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Status</strong></td>
            <td style="padding: 0.75rem;">
                @if($message->is_read)
                    <span class="badge" style="background: #6b7280; color: #fff;">Gelezen</span>
                @else
                    <span class="badge" style="background: #ef4444; color: #fff;">Ongelezen</span>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Ontvangen op</strong></td>
            <td style="padding: 0.75rem;">{{ $message->created_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Laatst bijgewerkt</strong></td>
            <td style="padding: 0.75rem;">{{ $message->updated_at->format('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem; color: #9095a0;"><strong>Berichtlengte</strong></td>
            <td style="padding: 0.75rem;">{{ strlen($message->message) }} karakters</td>
        </tr>
    </table>
</div>
@endsection
