<?php

namespace App\Policies;

use App\Models\Compte;
use App\Models\Produit;
use Illuminate\Auth\Access\Response;

class ProduitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Compte $compte): bool
    {
        return $compte->profile->nom === 'Producteur';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Compte $compte, Produit $produit): bool
    {
        return $compte->profile->nom === 'Producteur' && $produit->producteur_id === $compte->acheteur->producteur->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Compte $compte): bool
    {
        return $compte->profile->nom === 'Producteur';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Compte $compte, Produit $produit): bool
    {
        return $compte->profile->nom === 'Producteur' && $produit->producteur_id === $compte->acheteur->producteur->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Compte $compte, Produit $produit): bool
    {
        return $compte->profile->nom === 'Producteur' && $produit->producteur_id === $compte->acheteur->producteur->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Compte $compte, Produit $produit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Compte $compte, Produit $produit): bool
    {
        return false;
    }
}
