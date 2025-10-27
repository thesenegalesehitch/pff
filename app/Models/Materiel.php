<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    protected $fillable = ['nom', 'description', 'photo', 'prixLocation', 'type_materiel_id', 'proprietaire_materiel_id', 'status'];

    public function type()
    {
        return $this->belongsTo(TypeMateriel::class, 'type_materiel_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(ProprietaireMateriel::class);
    }

    public function locations()
    {
        return $this->hasMany(LouerMateriel::class);
    }

    public function locationsEnCours()
    {
        return $this->locations()->whereNull('dateRetour');
    }
}