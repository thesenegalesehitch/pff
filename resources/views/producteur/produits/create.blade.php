@extends('layouts.app')

@section('title', 'Ajouter un Produit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-agrilink shadow">
            <div class="card-header bg-success text-white fw-bold">Nouveau Produit à Vendre</div>
            <div class="card-body">
                <form action="{{ route('producteur.produits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du Produit</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                            value="{{ old('nom') }}" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prix" class="form-label">Prix (€)</label>
                            <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror"
                                id="prix" name="prix" value="{{ old('prix') }}" required min="0.01">
                            @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categorie_id" class="form-label">Catégorie</label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id"
                                name="categorie_id" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}"
                                    {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}
                                </option>
                                @endforeach
                            </select>
                            @error('categorie_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo du Produit</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"
                            name="photo">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-agrilink w-100 mt-3">Créer le Produit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
