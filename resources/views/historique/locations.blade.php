@extends('layouts.app')

@section('title', 'Mon Historique de Locations (Producteur)')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-agrilink fw-bold">🚜 Historique de Mes Locations</h1>
        <p class="lead text-muted">Matériel agricole que vous avez loué via AgriLink.</p>

        @if($locations->isEmpty())
            <div class="alert alert-info" role="alert">
                Vous n'avez pas encore loué de matériel. Consultez le <a href="{{ route('materiels.allouer') }}" class="alert-link">catalogue de matériel</a> disponible.
            </div>
        @else
            <div class="table-responsive bg-white p-3 rounded shadow-sm">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-success">
                    <tr>
                        <th>Matériel</th>
                        <th>Propriétaire</th>
                        <th>Début Location</th>
                        <th>Retour Prévu</th>
                        <th>Tarif Proposé (€)</th>
                        <th>Statut</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($locations as $location)
                        <tr>
                            <td class="fw-bold">{{ $location->materiel->nom }}</td>
                            <td>{{ $location->materiel->proprietaire->acheteur->nom ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($location->dateLocation)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($location->dateRetour)->format('d/m/Y') }}</td>
                            <td class="text-dark-green fw-bold">{{ number_format($location->tarif, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = [
                                        'en attente' => 'warning',
                                        'acceptée' => 'success',
                                        'refusée' => 'danger',
                                    ][strtolower($location->status)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($location->status) }}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
