<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AcheteurController extends Controller
{
public function historiqueAchats()
{
$acheteur = Auth::user()->acheteur;
$achats = $acheteur->achats()->with('produit')->orderBy('date', 'desc')->get();


return view('historique.achats', compact('achats'));
}
}
