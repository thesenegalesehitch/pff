@extends('layouts.app')

@section('title', 'Mes Matériels')

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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">Mes Matériels</h2>
                <a href="{{ route('proprietaire.materiels.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un Matériel
                </a>
            </div>

            @if($materiels->count() > 0)
                <div class="row">
                    @foreach($materiels as $materiel)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($materiel->photo)
                                    <img src="{{ asset('storage/' . $materiel->photo) }}" class="card-img-top" alt="{{ $materiel->nom }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-tools fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $materiel->nom }}</h5>
                                    <p class="card-text">{{ Str::limit($materiel->description, 100) }}</p>
                                    <p class="text-primary fw-bold fs-5">{{ number_format($materiel->prixLocation, 2) }} €/jour</p>
                                    <p class="text-muted small">Type: {{ $materiel->type->nom }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ $materiel->status === 'disponible' ? 'success' : 'warning' }}">
                                            {{ $materiel->status }}
                                        </span>
                                        <div>
                                            <a href="{{ route('proprietaire.materiels.edit', $materiel) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('proprietaire.materiels.destroy', $materiel) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ?')">
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
                    <i class="fas fa-tools fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucun matériel trouvé</h4>
                    <p class="text-muted">Commencez par ajouter votre premier matériel.</p>
                    <a href="{{ route('proprietaire.materiels.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un Matériel
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
