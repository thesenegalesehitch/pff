<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProprietaireMateriel extends Model
{
    protected $table = 'proprietaires_materiel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $guarded = [];

    public function acheteur()
    {
        return $this->belongsTo(Acheteur::class, 'id');
    }

    public function materiels()
    {
        return $this->hasMany(Materiel::class);
    }

    public function gerer_materiels()
    {
        return $this->materiels();
    }
// ici on a que seulement les materiesl disponibles
    public function allouer_materiels()
    {
        return $this->materiels()->whereDoesntHave('locationsEnCours')->get();
    }

    public function voir_materiels()
    {
        return $this->materiels;
    }
}
