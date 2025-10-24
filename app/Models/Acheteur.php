<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acheteur extends Model
{
    protected $fillable = ['nom', 'prenom', 'numero', 'adresse', 'email', 'compte_id'];

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    public function voir_historique_achats()
    {
        return $this->achats()->with('produit')->get();
    }

    public function voir_produits()
    {
        return Produit::where('status', 'disponible')->get();
    }


    public function achats()
    {
        return $this->hasMany(AcheterProduit::class);
    }

    public function producteur()
    {
        return $this->hasOne(Producteur::class, 'id');
    }

    public function proprietaireMateriel()
    {
        return $this->hasOne(ProprietaireMateriel::class, 'id');
    }
}
