<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['nom', 'prix', 'photo', 'status', 'description', 'categorie_id', 'producteur_id'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function producteur()
    {
        return $this->belongsTo(Producteur::class);
    }

    public function achats()
    {
        return $this->hasMany(AcheterProduit::class);
    }
}