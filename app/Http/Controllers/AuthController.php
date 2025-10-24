<?php
namespace App\Http\Controllers;


use App\Models\Acheteur;
use App\Models\Compte;
use App\Models\Profile;
use App\Models\Producteur;
use App\Models\ProprietaireMateriel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ... (showRegistrationForm, showLoginForm, logout)
    public function showRegistrationForm()
    {
        // Dans une application réelle, on ne propose pas de choisir le profile à l'inscription.
        // On attribue 'Acheteur' par défaut. Mais nous gardons 'Profile::all()' pour l'instant.
        $profiles = Profile::all();
        return view('auth.register', compact('profiles'));
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/home');
    }


    // Inscription
    public function register(Request $request)
    {
        $request->validate([
            // CORRECTION 1A: Vérifie l'unicité sur la colonne 'login' de la table 'comptes'
            'login' => 'required|unique:comptes,login',
            // OK: motPasse et motPasse_confirmation (via 'confirmed')
            'motPasse' => 'required|min:8|confirmed',

            // Validation Acheteur (Aucun changement nécessaire)
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'numero' => 'required|string|max:15', // J'ai retiré min:9 car la validation doit être faite côté client si vous voulez imposer un format strict
            'adresse' => 'required|string|max:255',
            'profile_id' => 'required|exists:profiles,id',
        ]);

        // 1. Création du Compte (pour la connexion)
        $compte = Compte::create([
            // CORRECTION 1B: Utilise la colonne 'login' pour l'identifiant
            'login' => $request->login,
            // CORRECTION 1C: Utilise la colonne 'motPasse' pour le mot de passe
            'motPasse' => Hash::make($request->motPasse),
            'profile_id' => $request->profile_id,
        ]);

        // 2. Création de l'Acheteur (profil de base) - OK
        $acheteur = Acheteur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'numero' => $request->numero,
            'adresse' => $request->adresse,
            'compte_id' => $compte->id,
        ]);

        // 3. Rôle par Héritage (Producteur ou ProprietaireMateriel) - OK
        $profile = Profile::find($request->profile_id);

        if ($profile->nom === 'Producteur') {
            Producteur::create(['id' => $acheteur->id]);
        } elseif ($profile->nom === 'ProprietaireMateriel') {
            ProprietaireMateriel::create(['id' => $acheteur->id]);
        }

        // Connexion et Redirection
        Auth::login($compte);
        return redirect('/home')->with('success', 'Inscription réussie !');
    }


    // Connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'motPasse' => 'required',
        ]);

        // CORRECTION 2: Tentative de connexion utilisant les colonnes exactes de la BD.
        // La clé doit rester 'password' (convention Laravel), mais la valeur $credentials['motPasse']
        // est vérifiée dans la colonne 'motPasse' grâce à getAuthPassword() du modèle Compte.
        if (Auth::guard('web')->attempt(['login' => $credentials['login'], 'password' => $credentials['motPasse']])) {

            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'login' => 'Les identifiants fournis ne correspondent pas !',
        ])->onlyInput('login');
    }
}
