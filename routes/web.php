<?php

use App\Http\Controllers\ProprietaireMaterielController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProduitController;
//Djibril tu fais cette partie crée les controllers et les routes sont déja faits par moi
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\AcheteurController;
use App\Http\Controllers\ProducteurController;


// Accueil et home et / va correspond a la partie welcome /apres discusssion ,
// on va essayer de changer cette partie
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes d'Authentification (Personnalisée sur Compte)
Route::controller(AuthController::class)->group(function () {
    // S'inscrire (Formulaire)
    Route::get('register', 'showRegistrationForm')->name('register');
    // S'inscrire (Action) -> appelle la méthode s'inscrire() implicitement
    Route::post('register', 'register');

    // Se connecter (Formulaire)
    Route::get('login', 'showLoginForm')->name('login');
    // Se connecter (Action) -> appelle la méthode connecter() implicitement
    Route::post('login', 'login');

    // Déconnexion
    Route::post('logout', 'logout')->name('logout')->middleware('auth');

    // Route pour répondre aux demandes (POST)
Route::post('/proprietaire/locations/{location}/repondre', [ProprietaireMaterielController::class, 'repondreDemande'])
    ->name('proprietaire.locations.repondre')
    ->middleware('check.proprietaire');
});

//ici on a  toutes Protégées (nécessitent d'être connecté)
Route::middleware('auth')->group(function () {

    // Actions Acheteur & Catalogue Produits (voir_produits & acheter_produit)
    Route::get('/produits/catalogue', [ProduitController::class, 'catalogue'])->name('produits.catalogue');
    Route::post('/produits/{produit}/acheter', [ProduitController::class, 'acheter'])->name('produits.acheter');

    // Actions Location & Catalogue Matériels (allouer_materiels & louer_materiels)
    Route::get('/materiels/catalogue', [MaterielController::class, 'allouer'])->name('materiels.allouer');
    // Nécessite un Producteur pour louer
    Route::post('/materiels/{materiel}/louer', [MaterielController::class, 'louer'])->name('materiels.louer')->middleware('check.producteur');

    // Routes Producteur (Gérer Produits)
    Route::resource('producteur/produits', ProduitController::class)->except(['show'])->middleware('check.producteur')->names([
        'index' => 'producteur.produits.index',
        'create' => 'producteur.produits.create',
        'store' => 'producteur.produits.store',
        'edit' => 'producteur.produits.edit',
        'update' => 'producteur.produits.update',
        'destroy' => 'producteur.produits.destroy',
    ]);

    // Routes ProprietaireMateriel (Gérer Matériels)
    Route::resource('proprietaire/materiels', MaterielController::class)->except(['show', 'allouer', 'louer'])->middleware('check.proprietaire')->names([
        'index' => 'proprietaire.materiels.index',
        'create' => 'proprietaire.materiels.create',
        'store' => 'proprietaire.materiels.store',
        'edit' => 'proprietaire.materiels.edit',
        'update' => 'proprietaire.materiels.update',
        'destroy' => 'proprietaire.materiels.destroy',
    ]);

    // Routes ProprietaireMateriel (Gérer Locations)
    Route::get('proprietaire/locations', [ProprietaireMaterielController::class, 'gestionLocations'])->name('proprietaire.locations.index')->middleware('check.proprietaire');
    Route::post('proprietaire/locations/{location}/repondre', [ProprietaireMaterielController::class, 'repondreDemande'])->name('proprietaire.locations.repondre')->middleware('check.proprietaire');

    // Historiques (pour Acheteur et Producteur)
    Route::get('/historique/achats', [AcheteurController::class, 'historiqueAchats'])->name('historique.achats');
    Route::get('/historique/locations', [ProducteurController::class, 'historiqueLocations'])->name('historique.locations')->middleware('check.producteur');

    // Dashboards par rôle
    Route::get('/dashboard/producteur', [ProducteurController::class, 'dashboard'])->name('producteur.dashboard')->middleware('check.producteur');
    Route::get('/dashboard/proprietaire', [ProprietaireMaterielController::class, 'dashboard'])->name('proprietaire.dashboard')->middleware('check.proprietaire');
});
