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
        $compteAcheteur = Compte::firstOrCreate([
            'login' => 'acheteur@agrilink.com'
        ], [
            'motPasse' => Hash::make('password'),
            'profile_id' => $profiles['Acheteur'],
        ]);
        Acheteur::firstOrCreate([
            'compte_id' => $compteAcheteur->id
        ], [
            'nom' => 'Diallo',
            'prenom' => 'Ibrahima',
            'email' => 'acheteur@agrilink.com',
            'numero' => '771234567',
            'adresse' => 'Dakar, Sénégal',
        ]);

        // --- 2. Producteur ---
        $compteProducteur = Compte::firstOrCreate([
            'login' => 'producteur@agrilink.com'
        ], [
            'motPasse' => Hash::make('password'),
            'profile_id' => $profiles['Producteur'],
        ]);
        $acheteurProducteur = Acheteur::firstOrCreate([
            'compte_id' => $compteProducteur->id
        ], [
            'nom' => 'Sow',
            'prenom' => 'Djibril',
            'email' => 'producteur@agrilink.com',
            'numero' => '772345678',
            'adresse' => 'Thies, Sénégal',
        ]);
        Producteur::firstOrCreate(['id' => $acheteurProducteur->id]);

        // --- 3. Propriétaire Matériel ---
        $compteProprietaire = Compte::firstOrCreate([
            'login' => 'proprietaire@agrilink.com'
        ], [
            'motPasse' => Hash::make('password'),
            'profile_id' => $profiles['ProprietaireMateriel'],
        ]);
        $acheteurProprietaire = Acheteur::firstOrCreate([
            'compte_id' => $compteProprietaire->id
        ], [
            'nom' => 'Soumaré',
            'prenom' => 'Fatoumata Kamaté',
            'email' => 'proprietaire@agrilink.com',
            'numero' => '773456789',
            'adresse' => 'Diourbel, Sénégal',
        ]);
        ProprietaireMateriel::firstOrCreate(['id' => $acheteurProprietaire->id]);
    }
}
