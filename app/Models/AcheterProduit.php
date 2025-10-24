<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AcheterProduit extends Pivot
{
    protected $table = 'acheter_produits';
    protected $fillable = ['date', 'heure', 'typePayement', 'quantite', 'montantTotal', 'acheteur_id', 'produit_id'];

    public function acheteur()
    {
        return $this->belongsTo(Acheteur::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
