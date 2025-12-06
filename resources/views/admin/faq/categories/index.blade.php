@extends('layouts.admin')

@section('title', 'FAQ Categorieën')
@section('page-title', 'FAQ Categorieën Beheer')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>FAQ Categorieën</h3>
        <a href="{{ route('admin.faq.categories.create') }}" class="btn btn-success">➕ Nieuwe Categorie</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Volgorde</th>
                    <th>Aantal Items</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->order }}</td>
                        <td>
                            <span class="badge" style="background: #6366f1; color: #fff;">
                                {{ $category->faq_items_count }} items
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.faq.categories.edit', $category) }}" class="btn btn-primary btn-sm" title="Bewerken">✏️</a>

                                <form method="POST" action="{{ route('admin.faq.categories.destroy', $category) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Weet je zeker dat je deze categorie wilt verwijderen?{{ $category->faq_items_count > 0 ? '\n\nLET OP: Deze categorie bevat nog ' . $category->faq_items_count . ' items!' : '' }}')"
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
                        <td colspan="5" style="text-align: center; color: #9095a0;">Geen categorieën gevonden</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem; text-align: center;">
        <a href="{{ route('admin.faq.items') }}" class="btn btn-primary">Bekijk FAQ Items →</a>
    </div>
</div>

<div style="background: #151b2e; padding: 1.5rem; border-radius: 8px; border: 1px solid #2a3150; margin-top: 1.5rem;">
    <h4 style="color: #4a9eff; margin-bottom: 1rem;"> Over Volgorde</h4>
    <p style="color: #9095a0; margin-bottom: 0.5rem;">
        Het volgorde nummer bepaalt in welke volgorde de categorieën worden weergegeven op de FAQ pagina.
    </p>
    <p style="color: #9095a0; margin-bottom: 0;">
        Een lager nummer betekent dat de categorie hoger in de lijst staat (bijv. volgorde 1 komt voor volgorde 2).
    </p>
</div>
@endsection
