<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producteur extends Model
{
protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';
    // Pour autoriser le mass assignment sans fillable
    protected $guarded = [];

    public function acheteur()
    {
        return $this->belongsTo(Acheteur::class, 'id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function locations()
    {
        return $this->hasMany(LouerMateriel::class);
    }

    public function vendre_produits()
    {
        return $this->produits;
    }

    public function louer_materiels()
    {
        return $this->locations()->with('materiel')->get();
    }

    public function voir_historique_materiels()
    {
        return $this->locations()->whereNotNull('dateRetour')->get();
    }

    public function gerer_produits()
    {
        return $this->produits();
    }
}
