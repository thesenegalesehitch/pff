@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white fw-bold fs-5">
                        Bienvenue sur AgriLink, {{ Auth::user()->profile->nom }} !
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h2 class="mb-4">Espace Personnel : {{ Auth::user()->profile->nom }}</h2>

                        {{-- ------------------------------------------------ --}}
                        {{-- AFFICHAGE BASÉ SUR LE RÔLE (Profil) --}}
                        {{-- ------------------------------------------------ --}}

                        @php
                            $role = Auth::user()->profile->nom;
                        @endphp

                        @if ($role === 'Producteur')
                            {{-- Contenu pour le Producteur --}}
                            <div class="alert alert-info">
                                En tant que **Producteur**, vous pouvez gérer vos produits et louer du matériel.
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('producteur.produits.index') }}" class="btn btn-lg btn-block btn-agrilink w-100 shadow-sm">
                                        <i class="fas fa-boxes me-2"></i> Gérer mes Produits
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('historique.locations') }}" class="btn btn-lg btn-block btn-secondary w-100 shadow-sm">
                                        <i class="fas fa-history me-2"></i> Mon Historique de Locations
                                    </a>
                                </div>
                            </div>

                        @elseif ($role === 'ProprietaireMateriel')
                            {{-- Contenu pour le Propriétaire de Matériel --}}
                            <div class="alert alert-warning">
                                En tant que **Propriétaire de Matériel**, vous gérez votre inventaire et les demandes de location.
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('proprietaire.materiels.index') }}" class="btn btn-lg btn-block btn-primary w-100 shadow-sm">
                                        <i class="fas fa-tools me-2"></i> Gérer mon Matériel
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('proprietaire.locations.index') }}" class="btn btn-lg btn-block btn-secondary w-100 shadow-sm">
                                        <i class="fas fa-clipboard-list me-2"></i> Gérer les Demandes (Locations)
                                    </a>
                                </div>
                            </div>

                        @elseif ($role === 'Acheteur')
                            {{-- Contenu pour l'Acheteur standard --}}
                            <div class="alert alert-success">
                                En tant qu'**Acheteur**, vous pouvez parcourir les produits frais et le matériel.
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('produits.catalogue') }}" class="btn btn-lg btn-block btn-success w-100 shadow-sm">
                                        <i class="fas fa-shopping-basket me-2"></i> Voir le Catalogue de Produits
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('materiels.allouer') }}" class="btn btn-lg btn-block btn-info w-100 shadow-sm">
                                        <i class="fas fa-tools me-2"></i> Voir le Catalogue de Matériels
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <a href="{{ route('historique.achats') }}" class="btn btn-lg btn-block btn-secondary w-100 shadow-sm">
                                        <i class="fas fa-history me-2"></i> Mon Historique d'Achats
                                    </a>
                                </div>
                            </div>

                        @endif

                        <hr>
                        <p class="text-muted small">
                            Vous êtes connecté(e) avec le rôle : **{{ Auth::user()->profile->nom }}**.
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
