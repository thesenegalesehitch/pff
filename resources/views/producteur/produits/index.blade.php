@extends('layouts.app')

@section('title', 'Mes Produits')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 bg-success text-white p-4" style="min-height: 80vh;">
            <h4 class="mb-4">Menu Producteur</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('producteur.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white active" href="{{ route('producteur.produits.index') }}">
                        <i class="fas fa-box"></i> Mes Produits
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('historique.locations') }}">
                        <i class="fas fa-history"></i> Historique Locations
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('historique.achats') }}">
                        <i class="fas fa-shopping-cart"></i> Mes Achats
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-success">Mes Produits</h2>
                <a href="{{ route('producteur.produits.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter un Produit
                </a>
            </div>

            @if($produits->count() > 0)
                <div class="row">
                    @foreach($produits as $produit)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($produit->photo)
                                    <img src="{{ asset('storage/' . $produit->photo) }}" class="card-img-top" alt="{{ $produit->nom }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produit->nom }}</h5>
                                    <p class="card-text">{{ Str::limit($produit->description, 100) }}</p>
                                    <p class="text-success fw-bold fs-5">{{ number_format($produit->prix, 2) }} €</p>
                                    <p class="text-muted small">Catégorie: {{ $produit->categorie->nom }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ $produit->status === 'disponible' ? 'success' : 'danger' }}">
                                            {{ $produit->status }}
                                        </span>
                                        <div>
                                            <a href="{{ route('producteur.produits.edit', $produit) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('producteur.produits.destroy', $produit) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucun produit trouvé</h4>
                    <p class="text-muted">Commencez par ajouter votre premier produit.</p>
                    <a href="{{ route('producteur.produits.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Ajouter un Produit
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
