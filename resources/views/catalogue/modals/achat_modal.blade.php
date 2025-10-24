<!-- Modal d'achat -->
<div class="modal fade" id="achatModal{{ $produit->id }}" tabindex="-1" aria-labelledby="achatModalLabel{{ $produit->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="achatModalLabel{{ $produit->id }}">Acheter {{ $produit->nom }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('produits.acheter', $produit) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantite{{ $produit->id }}" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="quantite{{ $produit->id }}" name="quantite" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="typePayement{{ $produit->id }}" class="form-label">Mode de paiement</label>
                        <select class="form-select" id="typePayement{{ $produit->id }}" name="typePayement" required>
                            <option value="Carte">Carte bancaire</option>
                            <option value="Virement">Virement bancaire</option>
                            <option value="Cash">Espèces</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <strong>Prix unitaire:</strong> {{ number_format($produit->prix, 2) }} €<br>
                        <strong>Total estimé:</strong> <span id="total{{ $produit->id }}">{{ number_format($produit->prix, 2) }}</span> €
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Confirmer l'achat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('quantite{{ $produit->id }}').addEventListener('input', function() {
    const quantite = this.value;
    const prix = {{ $produit->prix }};
    const total = quantite * prix;
    document.getElementById('total{{ $produit->id }}').textContent = total.toFixed(2);
});
</script>