<?php
namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\TypeMateriel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMaterielRequest;
use App\Http\Requests\UpdateMaterielRequest;

class MaterielController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index()
    {
        $proprietaire = $this->getCurrentProprietaire();
        if (!$proprietaire) {
            return redirect('/home')->with('error', 'Accès refusé. Vous devez être Propriétaire de Matériel.');
        }

        $materiels = $proprietaire->materiels()->with('type')->get();
        return view('proprietaire.materiels.index', compact('materiels'));
    }

    public function create()
    {
        $proprietaire = $this->getCurrentProprietaire();
        if (!$proprietaire) {
            return redirect('/home')->with('error', 'Accès refusé. Vous devez être Propriétaire de Matériel.');
        }

        $typesMateriel = TypeMateriel::all();
        return view('proprietaire.materiels.create', compact('typesMateriel'));
    }

    public function store(StoreMaterielRequest $request)
    {
        $proprietaire = $this->getCurrentProprietaire();
        if (!$proprietaire) {
            return redirect('/home')->with('error', 'Accès refusé.');
        }

        $validatedData = $request->validated();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('materiels', 'public');
        }

        $proprietaire->materiels()->create([
            'nom' => $validatedData['nom'],
            'description' => $validatedData['description'],
            'prixLocation' => $validatedData['prixLocation'],
            'type_materiel_id' => $validatedData['type_materiel_id'],
            'status' => 'disponible',
            'photo' => $photoPath,
            'proprietaire_materiel_id' => $proprietaire->id,
        ]);

        return redirect()->route('proprietaire.materiels.index')->with('success', 'Matériel ajouté avec succès !');
    }

    public function edit(Materiel $materiel)
    {
        $this->authorize('update', $materiel);
        $typesMateriel = TypeMateriel::all();
        return view('proprietaire.materiels.edit', compact('materiel', 'typesMateriel'));
    }

    public function update(UpdateMaterielRequest $request, Materiel $materiel)
    {
        $this->authorize('update', $materiel);

        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            if ($materiel->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($materiel->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('materiels', 'public');
        }

        $materiel->update($validatedData);

        return redirect()->route('proprietaire.materiels.index')->with('success', 'Matériel mis à jour !');
    }

    public function destroy(Materiel $materiel)
    {
        $this->authorize('delete', $materiel);

        if ($materiel->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($materiel->photo);
        }

        $materiel->delete();
        return redirect()->route('proprietaire.materiels.index')->with('success', 'Matériel supprimé !');
    }


    public function allouer()
    {
        $materiels = Materiel::whereDoesntHave('locationsEnCours')->with('proprietaire.acheteur', 'type')->get();
        return view('catalogue.materiel', compact('materiels'));
    }


    public function louer(Request $request, Materiel $materiel)
    {
        $producteur = $this->getCurrentProducteur();
        if (!$producteur) {
            return back()->with('error', 'Seul un Producteur peut louer du matériel.');
        }

        $request->validate([
            'tarif' => 'required|numeric|min:0.01',
            'dateLocation' => 'required|date|after_or_equal:today',
            'dateRetour' => 'required|date|after:dateLocation',
        ]);

        \App\Models\LouerMateriel::create([
            'tarif' => $request->tarif,
            'dateLocation' => $request->dateLocation,
            'dateRetour' => $request->dateRetour,
            'producteur_id' => $producteur->id,
            'materiel_id' => $materiel->id,
            'status' => 'en attente',
        ]);

        return redirect()->route('materiels.allouer')->with('success', 'Matériel loué avec succès !');
    }

    private function getCurrentProprietaire()
    {
        if (Auth::user()->profile->nom !== 'ProprietaireMateriel') return null;
        return Auth::user()->acheteur->proprietaireMateriel;
    }
    private function getCurrentProducteur()
    {
        if (Auth::user()->profile->nom !== 'Producteur') return null;
        return Auth::user()->acheteur->producteur;
    }



}
