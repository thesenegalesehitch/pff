<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAcheteurRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->profile->nom === 'Acheteur') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Accès refusé. Seuls les Acheteurs peuvent effectuer cette action.');
    }
}