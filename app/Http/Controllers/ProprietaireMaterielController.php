<?php


namespace App\Http\Controllers;

use App\Models\LouerMateriel;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProprietaireMaterielController extends Controller
{
    public function dashboard()
    {
        $proprietaire = Auth::user()->acheteur->proprietaireMateriel;

        // Statistiques pour le dashboard
        $totalMateriels = $proprietaire->materiels()->count();
        $materielsDisponibles = $proprietaire->materiels()->whereDoesntHave('locationsEnCours')->count();
        $demandesEnAttente = LouerMateriel::whereHas('materiel', function($query) use ($proprietaire) {
            $query->where('proprietaire_materiel_id', $proprietaire->id);
        })->where('status', 'en attente')->count();
        $totalRevenus = LouerMateriel::whereHas('materiel', function($query) use ($proprietaire) {
            $query->where('proprietaire_materiel_id', $proprietaire->id);
        })->where('status', 'acceptée')->sum('tarif');

        // Matériels récents
        $materielsRecents = $proprietaire->materiels()->with('type')->latest()->take(5)->get();

        return view('proprietaire.dashboard', compact(
            'totalMateriels',
            'materielsDisponibles',
            'demandesEnAttente',
            'totalRevenus',
            'materielsRecents'
        ));
    }

    /**
     * Affiche les demandes de location reçues pour le matériel du propriétaire.
     * Correspond à la fonction gestionLocations().
     */

    public function gestionLocations()
    {
        // On s'assure que l'utilisateur est un ProprietaireMateriel (via le middleware)
        $proprietaire = Auth::user()->acheteur->proprietaireMateriel;

        // On récupère toutes les locations pour le matériel appartenant à ce propriétaire
        $demandes = LouerMateriel::whereHas('materiel', function ($query) use ($proprietaire) {
            $query->where('proprietaire_materiel_id', $proprietaire->id);
        })
        ->with('materiel', 'producteur.acheteur')
        ->orderBy('dateLocation', 'asc')
        ->get();

        return view('proprietaire.locations.index', compact('demandes'));
    }

    /**
     * Logique pour accepter ou refuser une demande de location (à développer plus tard)
     */
    public function repondreDemande(Request $request, LouerMateriel $location)
    {
        // Ici, la logique pour changer le statut de la location (accepte/refusé)
        // et potentiellement envoyer une notification.

        // Sécurité: Vérifier que la demande concerne bien son matériel.
        // ...

        if ($request->action === 'accepter') {
            $location->status = 'acceptée';
            $location->save();
            return back()->with('success', 'Demande de location acceptée.');
        } else {
            $location->delete(); // On pourrait la marquer 'refusée' au lieu de la supprimer
            return back()->with('warning', 'Demande de location refusée/annulée.');
        }
    }
}