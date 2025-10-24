<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProprietaireRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->profile->nom === 'ProprietaireMateriel') {
            return $next($request);
        }
        return redirect('/home')->with('error', 'Accès refusé. Seuls les Propriétaires de matériel peuvent effectuer cette action.');
    }
}
