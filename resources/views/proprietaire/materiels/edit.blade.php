@extends('layouts.app')

@section('title', 'Modifier le Matériel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 bg-primary text-white p-4" style="min-height: 80vh;">
            <h4 class="mb-4">Menu Propriétaire</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('proprietaire.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white active" href="{{ route('proprietaire.materiels.index') }}">
                        <i class="fas fa-tools"></i> Mes Matériels
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('proprietaire.locations.index') }}">
                        <i class="fas fa-calendar-check"></i> Demandes de Location
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 p-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white fw-bold">Modifier le Matériel</div>
                        <div class="card-body">
                            <form action="{{ route('proprietaire.materiels.update', $materiel) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom du Matériel</label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                                        value="{{ old('nom', $materiel->nom) }}" required>
                                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="prixLocation" class="form-label">Prix de Location (€/jour)</label>
                                        <input type="number" step="0.01" class="form-control @error('prixLocation') is-invalid @enderror"
                                            id="prixLocation" name="prixLocation" value="{{ old('prixLocation', $materiel->prixLocation) }}" required min="0.01">
                                        @error('prixLocation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="type_materiel_id" class="form-label">Type de Matériel</label>
                                        <select class="form-select @error('type_materiel_id') is-invalid @enderror" id="type_materiel_id"
                                            name="type_materiel_id" required>
                                            <option value="">Sélectionner un type</option>
                                            @foreach($typesMateriel as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('type_materiel_id', $materiel->type_materiel_id) == $type->id ? 'selected' : '' }}>{{ $type->nom }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('type_materiel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description', $materiel->description) }}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="disponible" {{ old('status', $materiel->status) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="en maintenance" {{ old('status', $materiel->status) === 'en maintenance' ? 'selected' : '' }}>En maintenance</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo du Matériel (laisser vide pour garder l'actuelle)</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    @if($materiel->photo)
                                        <small class="form-text text-muted">Photo actuelle:</small>
                                        <img src="{{ asset('storage/' . $materiel->photo) }}" alt="Photo actuelle" class="img-thumbnail mt-2" style="max-width: 200px;">
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('proprietaire.materiels.index') }}" class="btn btn-secondary">Annuler</a>
                                    <button type="submit" class="btn btn-primary">Mettre à jour le Matériel</button>
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