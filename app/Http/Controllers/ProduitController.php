<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\AcheterProduit;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;


class ProduitController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }


    public function index()
    {
        $producteur = $this->getCurrentProducteur();
        if (!$producteur) {
            return redirect('/home')->with('error', 'Accès refusé. Vous devez être Producteur.');
        }

        $produits = $producteur->produits;
        return view('producteur.produits.index', compact('produits'));
    }


public function create()
    {
        $this->authorizeProducteur(); // Vérifie le rôle
        $categories = \App\Models\Categorie::all();
        return view('producteur.produits.create', compact('categories'));
    }

    public function store(StoreProduitRequest $request)
    {
        $producteur = $this->authorizeProducteur(); // Vérifie le rôle

        $validatedData = $request->validated();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Stockage de l'image dans storage/app/public/produits
            $photoPath = $request->file('photo')->store('produits', 'public');
        }

        $producteur->produits()->create([
            'nom' => $validatedData['nom'],
            'prix' => $validatedData['prix'],
            'description' => $validatedData['description'],
            'categorie_id' => $validatedData['categorie_id'],
            'status' => 'disponible',
            'photo' => $photoPath,
        ]);

        return redirect()->route('producteur.produits.index')->with('success', 'Produit ajouté avec succès !');
    }

    public function edit(\App\Models\Produit $produit)
    {
        $this->authorize('update', $produit);
        $categories = \App\Models\Categorie::all();
        return view('producteur.produits.edit', compact('produit', 'categories'));
    }

    public function update(UpdateProduitRequest $request, \App\Models\Produit $produit)
    {
        $this->authorize('update', $produit);

        $validatedData = $request->validated();

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($produit->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($produit->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('produits', 'public');
        }

        $produit->update($validatedData);

        return redirect()->route('producteur.produits.index')->with('success', 'Produit mis à jour !');
    }

    public function destroy(\App\Models\Produit $produit)
    {
        $this->authorize('delete', $produit);

        // Supprimer la photo si elle existe
        if ($produit->photo) {
              \Illuminate\Support\Facades\Storage::disk('public')->delete($produit->photo);
        }

        $produit->delete();
        return redirect()->route('producteur.produits.index')->with('success', 'Produit supprimé !');
    }

    // Méthode pour l'autorisation (privée)
    private function authorizeProducteur()
    {
        $producteur = $this->getCurrentProducteur();
        if (!$producteur) {
            abort(403, 'Accès refusé. Vous devez être Producteur.');
        }
        return $producteur;
    }

    //une fonction pour la recherche de produits mais on doit l'intégrer dans index de producteur
    public function search(Request $request)
    {
        $producteur = $this->getCurrentProducteur();
        if (!$producteur) {
            return redirect()->route('home')->with('error', 'Action non autorisée.');
        }
        $search = $request->input('search');
        $produits = $producteur->produits()->where('nom', 'like', "%$search%")->paginate(10);
        return view('producteur.produits.index', compact('produits'));
    }

    public function catalogue()
    {
        //ici methode afficher le catalogue des produits disponibles pour les acheteurs
        $produits = Produit::where('status', 'disponible')->with('producteur.acheteur', 'categorie')->get();
        return view('catalogue.produits', compact('produits'));
    }

    public function acheter(Request $request, Produit $produit)
    {
        $acheteur = $this->getCurrentAcheteur();

        $request->validate([
            'quantite' => 'required|integer|min:1',
            'typePayement' => 'required|in:Carte,Virement,Cash',
        ]);

        $montantTotal = $produit->prix * $request->quantite;

        AcheterProduit::create([
            'date' => now()->toDateString(),
            'heure' => now()->toTimeString(),
            'typePayement' => $request->typePayement,
            'quantite' => $request->quantite,
            'montantTotal' => $montantTotal,
            'acheteur_id' => $acheteur->id,
            'produit_id' => $produit->id,
        ]);

        return redirect()->route('produits.catalogue')->with('success', 'Achat réussi ! Montant: ' . $montantTotal . ' ' . $produit->nom);
    }

    private function getCurrentProducteur()
    {
        if (Auth::user()->profile->nom !== 'Producteur') return null;
        return Auth::user()->acheteur->producteur;
    }
    private function getCurrentAcheteur()
    {
        return Auth::user()->acheteur;
    }
}
