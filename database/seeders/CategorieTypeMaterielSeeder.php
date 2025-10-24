<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\TypeMateriel;

class CategorieTypeMaterielSeeder extends Seeder
{
    public function run(): void
    {
        // Catégories de Produits
        $categories = ['Fruits et Légumes', 'Céréales', 'Viandes et Volailles', 'Produits Laitiers'];
        foreach ($categories as $nom) {
            Categorie::create(['nom' => $nom]);
        }

        // Types de Matériel
        $types = ['Tracteurs', 'Outils de Labour', 'Matériel de Récolte', 'Systèmes d\'Irrigation'];
        foreach ($types as $nom) {
            TypeMateriel::create(['nom' => $nom]);
        }
    }
}
