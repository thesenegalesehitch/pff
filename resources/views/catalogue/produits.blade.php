@extends('layouts.app')

@section('title', 'Catalogue des Produits Agricoles')

@section('content')
<h1 class="mb-4 text-success fw-bold">Marché AgriLink 🥕</h1>
<p class="lead">Découvrez les meilleurs produits frais et locaux de nos Producteurs.</p>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($produits as $produit)
    <div class="col">
        <div class="card h-100 shadow-sm border-success">
            <img src="{{ $produit->photo ? asset('storage/' . $produit->photo) : 'https://via.placeholder.com/400x200?text=Produit+Agri' }}"
                class="card-img-top" alt="{{ $produit->nom }}" style="height: 200px; object-fit: cover;">

            <div class="card-body">
                <h5 class="card-title text-agrilink fw-bold">{{ $produit->nom }}</h5>
                <p class="card-text text-muted small mb-1">
                    Catégorie: {{ $produit->categorie->nom }}
                </p>
                <p class="card-text text-muted small">
                    Producteur: {{ $produit->producteur->acheteur->nom }}
                </p>
                <p class="card-text">{{ Str::limit($produit->description, 50) }}</p>
            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <p class="fw-bold mb-0 text-dark-green">{{ number_format($produit->prix, 2) }} €</p>

                @auth
                <button type="button" class="btn btn-agrilink btn-sm" data-bs-toggle="modal"
                    data-bs-target="#achatModal{{ $produit->id }}">
                    Acheter
                </button>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Connectez-vous pour acheter</a>
                @endauth
            </div>
        </div>
    </div>

    @include('catalogue.modals.achat_modal', ['produit' => $produit])

    @empty
    <div class="col-12">
        <p class="alert alert-info">Aucun produit disponible pour le moment.</p>
    </div>
    @endforelse
</div>

@endsection
