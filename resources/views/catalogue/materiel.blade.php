@extends('layouts.app')

@section('title', 'Catalogue de Matériels Agricoles')

@section('content')
<h1 class="mb-4 text-agrilink fw-bold">Matériels Agricoles Disponibles 🚜</h1>
<p class="lead">Louez l'équipement nécessaire auprès de nos propriétaires de matériel.</p>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($materiels as $materiel)
    <div class="col">
        <div class="card h-100 shadow-sm border-success">
            <img src="{{ $materiel->photo ? asset('storage/' . $materiel->photo) : 'https://via.placeholder.com/400x200?text=Matériel+Agricole' }}"
                class="card-img-top" alt="{{ $materiel->nom }}" style="height: 200px; object-fit: cover;">

            <div class="card-body">
                <h5 class="card-title text-agrilink fw-bold">{{ $materiel->nom }}</h5>
                <p class="card-text text-muted small mb-1">
                    Type: {{ $materiel->type->nom }}
                </p>
                <p class="card-text text-muted small">
                    Propriétaire: {{ $materiel->proprietaire->acheteur->nom }}
                </p>
                <p class="card-text">{{ Str::limit($materiel->description, 50) }}</p>
            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <p class="fw-bold mb-0 text-dark-green">Tarif à déterminer</p>

                @if(Auth::check() && Auth::user()->profile->nom === 'Producteur')
                <button type="button" class="btn btn-agrilink btn-sm" data-bs-toggle="modal"
                    data-bs-target="#locationModal{{ $materiel->id }}">
                    Louer ce Matériel
                </button>
                @else
                <button class="btn btn-outline-success btn-sm disabled">Être Producteur pour louer</button>
                @endif
            </div>
        </div>
    </div>

    @include('catalogue.modals.location_modal', ['materiel' => $materiel])

    @empty
    <div class="col-12">
        <p class="alert alert-info">Aucun matériel disponible à la location pour le moment.</p>
    </div>
    @endforelse
</div>
@endsection
