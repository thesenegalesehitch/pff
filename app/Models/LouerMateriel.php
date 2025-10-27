<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LouerMateriel extends Pivot
{
    protected $table = 'louer_materiels';
    protected $fillable = ['tarif', 'dateLocation', 'dateRetour', 'producteur_id', 'materiel_id', 'status'];

    // Relations vers les entités
    public function producteur()
    {
        return $this->belongsTo(Producteur::class);
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }
}
