@extends('layouts.app')

@section('title', 'Tableau de Bord Propriétaire')

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
                    <a class="nav-link text-white" href="{{ route('proprietaire.materiels.index') }}">
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
            <h2 class="mb-4 text-primary">Bienvenue, {{ Auth::user()->acheteur->prenom }} !</h2>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ $totalMateriels }}</h5>
                            <p class="card-text">Total Matériels</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ $materielsDisponibles }}</h5>
                            <p class="card-text">Matériels Disponibles</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ $demandesEnAttente }}</h5>
                            <p class="card-text">Demandes en Attente</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">{{ number_format($totalRevenus, 2) }} €</h5>
                            <p class="card-text">Total Revenus</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Materials -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Matériels Récents</h5>
                </div>
                <div class="card-body">
                    @if($materielsRecents->count() > 0)
                        <div class="row">
                            @foreach($materielsRecents as $materiel)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        @if($materiel->photo)
                                            <img src="{{ asset('storage/' . $materiel->photo) }}" class="card-img-top" alt="{{ $materiel->nom }}" style="height: 150px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <i class="fas fa-tools fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $materiel->nom }}</h6>
                                            <p class="card-text">{{ Str::limit($materiel->description, 50) }}</p>
                                            <p class="text-primary fw-bold">{{ number_format($materiel->prixLocation, 2) }} €/jour</p>
                                            <span class="badge bg-{{ $materiel->status === 'disponible' ? 'success' : 'warning' }}">
                                                {{ $materiel->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Aucun matériel récent.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection