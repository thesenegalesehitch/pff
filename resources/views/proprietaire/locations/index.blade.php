@extends('layouts.app')

@section('title', 'Gestion des Demandes de Location')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-agrilink fw-bold">⚙️ Demandes de Location Reçues</h1>
        <p class="lead text-muted">Répondez aux demandes de location concernant votre matériel.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($demandes->isEmpty())
            <div class="alert alert-info" role="alert">
                Aucune demande de location en cours pour votre matériel.
            </div>
        @else
            <div class="table-responsive bg-white p-3 rounded shadow-sm">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-success">
                    <tr>
                        <th>Matériel</th>
                        <th>Demandeur (Producteur)</th>
                        <th>Période</th>
                        <th>Tarif Proposé (€)</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($demandes as $demande)
                        <tr>
                            <td class="fw-bold">{{ $demande->materiel->nom }}</td>
                            <td>{{ $demande->producteur->acheteur->nom ?? 'Inconnu' }}</td>
                            <td>
                                Du {{ \Carbon\Carbon::parse($demande->dateLocation)->format('d/m/Y') }}<br>
                                Au {{ \Carbon\Carbon::parse($demande->dateRetour)->format('d/m/Y') }}
                            </td>
                            <td class="text-dark-green fw-bold">{{ number_format($demande->tarif, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ strtolower($demande->status) == 'en attente' ? 'warning' : 'success' }}">{{ ucfirst($demande->status) }}</span>
                            </td>
                            <td>
                                @if(strtolower($demande->status) == 'en attente')
                                    <form action="{{ route('proprietaire.locations.repondre', $demande->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="accepter">
                                        <button type="submit" class="btn btn-sm btn-success me-2">Accepter</button>
                                    </form>
                                    <form action="{{ route('proprietaire.locations.repondre', $demande->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="refuser">
                                        <button type="submit" class="btn btn-sm btn-danger">Refuser</button>
                                    </form>
                                @else
                                    <span class="text-muted small">Finalisé</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
