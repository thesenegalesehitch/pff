@extends('layouts.app')

@section('title', 'Modifier le Produit')

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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-agrilink shadow">
                        <div class="card-header bg-success text-white fw-bold">Modifier le Produit</div>
                        <div class="card-body">
                            <form action="{{ route('producteur.produits.update', $produit) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom du Produit</label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                                        value="{{ old('nom', $produit->nom) }}" required>
                                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="prix" class="form-label">Prix (€)</label>
                                        <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror"
                                            id="prix" name="prix" value="{{ old('prix', $produit->prix) }}" required min="0.01">
                                        @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="categorie_id" class="form-label">Catégorie</label>
                                        <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id"
                                            name="categorie_id" required>
                                            <option value="">Sélectionner une catégorie</option>
                                            @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}"
                                                {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('categorie_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description', $produit->description) }}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="disponible" {{ old('status', $produit->status) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="en rupture" {{ old('status', $produit->status) === 'en rupture' ? 'selected' : '' }}>En rupture</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo du Produit (laisser vide pour garder l'actuelle)</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    @if($produit->photo)
                                        <small class="form-text text-muted">Photo actuelle:</small>
                                        <img src="{{ asset('storage/' . $produit->photo) }}" alt="Photo actuelle" class="img-thumbnail mt-2" style="max-width: 200px;">
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('producteur.produits.index') }}" class="btn btn-secondary">Annuler</a>
                                    <button type="submit" class="btn btn-success">Mettre à jour le Produit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection