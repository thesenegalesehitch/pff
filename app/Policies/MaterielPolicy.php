<?php

namespace App\Policies;

use App\Models\Compte;
use App\Models\Materiel;
use Illuminate\Auth\Access\Response;

class MaterielPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Compte $compte): bool
    {
        return $compte->profile->nom === 'ProprietaireMateriel';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Compte $compte, Materiel $materiel): bool
    {
        return $compte->profile->nom === 'ProprietaireMateriel' && $materiel->proprietaire_materiel_id === $compte->acheteur->proprietaireMateriel->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Compte $compte): bool
    {
        return $compte->profile->nom === 'ProprietaireMateriel';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Compte $compte, Materiel $materiel): bool
    {
        return $compte->profile->nom === 'ProprietaireMateriel' && $materiel->proprietaire_materiel_id === $compte->acheteur->proprietaireMateriel->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Compte $compte, Materiel $materiel): bool
    {
        return $compte->profile->nom === 'ProprietaireMateriel' && $materiel->proprietaire_materiel_id === $compte->acheteur->proprietaireMateriel->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Compte $compte, Materiel $materiel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Compte $compte, Materiel $materiel): bool
    {
        return false;
    }
}
