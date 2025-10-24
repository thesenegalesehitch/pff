<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Produit;
use App\Models\AcheterProduit;
use App\Models\LouerMateriel;

class ProducteurController extends Controller
{
    public function dashboard()
    {
        $producteur = Auth::user()->acheteur->producteur;

        // Statistiques pour le dashboard
        $totalProduits = $producteur->produits()->count();
        $produitsDisponibles = $producteur->produits()->where('status', 'disponible')->count();
        $totalVentes = AcheterProduit::whereHas('produit', function($query) use ($producteur) {
            $query->where('producteur_id', $producteur->id);
        })->sum('montantTotal');
        $locationsActives = LouerMateriel::where('producteur_id', $producteur->id)->count();

        // Produits récents
        $produitsRecents = $producteur->produits()->latest()->take(5)->get();

        return view('producteur.dashboard', compact(
            'totalProduits',
            'produitsDisponibles',
            'totalVentes',
            'locationsActives',
            'produitsRecents'
        ));
    }

    // voir_historique_materiels()
    public function historiqueLocations()
    {
        $producteur = Auth::user()->acheteur->producteur;
        // Utilisez la méthode louer_materiels() du modèle Producteur ou la relation
        $locations = $producteur->locations()->with('materiel')->orderBy('dateLocation', 'desc')->get();

        // Retourne la vue historique.locations.blade.php (à créer)
        return view('historique.locations', compact('locations'));
    }
}
