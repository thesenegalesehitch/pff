<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Profile;
use App\Models\Compte;
use App\Models\Acheteur;
use App\Models\Producteur;
use App\Models\ProprietaireMateriel;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = Profile::pluck('id', 'nom');

        // --- 1. Acheteur Simple ---
        $compteAcheteur = Compte::create([
            'login' => 'acheteur@agrilink.com',
            'motPasse' => Hash::make('password'),
            'profile_id' => $profiles['Acheteur'],
        ]);
        Acheteur::create([
            'nom' => 'Diallo',
            'prenom' => 'Ibrahima',
            'email' => 'acheteur@agrilink.com',
            'compte_id' => $compteAcheteur->id,
            'adresse' => 'Dakar, Sénégal',
        ]);

        // --- 2. Producteur ---
        $compteProducteur = Compte::create([
            'login' => 'producteur@agrilink.com',
            'motPasse' => Hash::make('password'),
            'profile_id' => $profiles['Producteur'],
        ]);
        $acheteurProducteur = Acheteur::create([
            'nom' => 'Sow',
            'prenom' => 'Djibril',
            'email' => 'producteur@agrilink.com',
            'compte_id' => $compteProducteur->id,
            'adresse' => 'Thies, Sénégal',
        ]);
        Producteur::create(['id' => $acheteurProducteur->id]);

        // --- 3. Propriétaire Matériel ---
        $compteProprietaire = Compte::create([
            'login' => 'proprietaire@agrilink.com',
            'motPasse' => Hash::make('password'),
            'profile_id' => $profiles['ProprietaireMateriel'],
        ]);
        $acheteurProprietaire = Acheteur::create([
            'nom' => 'Soumaré',
            'prenom' => 'Fatoumata Kamaté',
            'email' => 'proprietaire@agrilink.com',
            'compte_id' => $compteProprietaire->id,
            'adresse' => 'Diourbel, Sénégal',
        ]);
        ProprietaireMateriel::create(['id' => $acheteurProprietaire->id]);
    }
}
