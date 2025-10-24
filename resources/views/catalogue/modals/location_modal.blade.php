<div class="modal fade" id="locationModal{{ $materiel->id }}" tabindex="-1" aria-labelledby="locationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="locationModalLabel">Louer : {{ $materiel->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('materiels.louer', $materiel->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Propriétaire: **{{ $materiel->proprietaire->acheteur->nom }}**</p>
                    <p class="text-muted">Type: **{{ $materiel->type->nom }}**</p>

                    <div class="mb-3">
                        <label for="dateLocation" class="form-label">Date de Début de Location</label>
                        <input type="date" class="form-control" id="dateLocation" name="dateLocation" required
                            min="{{ now()->toDateString() }}">
                    </div>

                    <div class="mb-3">
                        <label for="dateRetour" class="form-label">Date de Fin de Location Estimée</label>
                        <input type="date" class="form-control" id="dateRetour" name="dateRetour" required>
                    </div>

                    <div class="mb-3">
                        <label for="tarif" class="form-label">Tarif Journalier Proposé (€)</label>
                        <input type="number" step="0.01" class="form-control" id="tarif" name="tarif" required
                            min="0.01">
                        <small class="form-text text-muted">Ce tarif sera confirmé par le Propriétaire.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-agrilink">Confirmer la Demande de Location</button>
                </div>
            </form>
        </div>
    </div>
</div>
