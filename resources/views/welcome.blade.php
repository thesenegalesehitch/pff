@extends('layouts.app')

@section('title', 'Bienvenue sur AgriLink')

@section('content')
{{--    ICI on cree la variable agrili--}}
<div class="p-5 text-center bg-light rounded-3 shadow-lg" style="background-color: var(--agrilink-light-bg);">
    <h1 class="text-agrilink display-4 fw-bold">AgriLink </h1>
    <p class="col-lg-8 mx-auto lead">
        Votre plateforme de connexion directe entre Producteurs, Acheteurs et Propriétaires de Matériel Agricole.
        Simplifiez l'achat de produits frais et la location d'outils essentiels.
    </p>
    <div class="d-inline-flex gap-2 mb-2">
        <a href="{{ route('produits.catalogue') }}" class="btn btn-agrilink btn-lg px-4 rounded-pill">
            Voir les Produits
        </a>
        <a href="{{ route('materiels.allouer') }}" class="btn btn-outline-success btn-lg px-4 rounded-pill">
            Louer du Matériel (Producteur)
        </a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card card-agrilink h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-success">Produits Frais</h3>
                <p class="card-text">Accédez à des produits agricoles de qualité directement auprès des Producteurs
                    locaux.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-agrilink h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-success">Location d'Équipement</h3>
                <p class="card-text">Producteurs, louez le matériel dont vous avez besoin auprès de propriétaires
                    certifiés.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-agrilink h-100 shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-success">Réseau Connecté</h3>
                <p class="card-text">Gérez tous vos besoins agricoles, de l'achat à la production, sur une seule
                    plateforme.</p>
            </div>
        </div>
    </div>
</div>
@endsection
