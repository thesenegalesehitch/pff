@extends('layouts.app')

@section('title', 'Mon Historique d\'Achats')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-agrilink fw-bold">🛒 Mon Historique d'Achats</h1>
        <p class="lead text-muted">Retrouvez ici tous les produits que vous avez achetés sur AgriLink.</p>

        @if($achats->isEmpty())
            <div class="alert alert-info" role="alert">
                Vous n'avez pas encore effectué d'achats. Découvrez notre <a href="{{ route('produits.catalogue') }}" class="alert-link">catalogue de produits frais</a> !
            </div>
        @else
            <div class="table-responsive bg-white p-3 rounded shadow-sm">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-success">
                    <tr>
                        <th>Date & Heure</th>
                        <th>Produit</th>
                        <th>Producteur</th>
                        <th>Quantité</th>
                        <th>Montant Total (€)</th>
                        <th>Paiement</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($achats as $achat)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($achat->date)->format('d/m/Y') }} à {{ $achat->heure }}</td>
                            <td class="fw-bold">{{ $achat->produit->nom }}</td>
                            <td>{{ $achat->produit->producteur->acheteur->nom ?? 'N/A' }}</td>
                            <td>{{ $achat->quantite }}</td>
                            <td class="text-dark-green fw-bold">{{ number_format($achat->montantTotal, 2) }} €</td>
                            <td><span class="badge bg-secondary">{{ $achat->typePayement }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
