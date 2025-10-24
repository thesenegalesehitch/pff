@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white fw-bold fs-5">{{ __('Inscription sur AgriLink') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- ------------------------------------------------ --}}
                            {{-- BLOC 1 : INFORMATIONS DE BASE (ACHETEUR) --}}
                            {{-- ------------------------------------------------ --}}
                            <h5 class="mt-3 mb-3 text-secondary">Informations Personnelles</h5>

                            <div class="row">
                                {{-- Nom --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">{{ __('Nom') }}</label>
                                    <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                                    @error('nom')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Prénom --}}
                                <div class="col-md-6 mb-3">
                                    <label for="prenom" class="form-label">{{ __('Prénom') }}</label>
                                    <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom">
                                    @error('prenom')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Adresse --}}
                            <div class="row mb-3">
                                <label for="adresse" class="form-label">{{ __('Adresse Complète') }}</label>
                                <input id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{ old('adresse') }}" required autocomplete="adresse">
                                @error('adresse')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Numéro de Téléphone --}}
                            <div class="row mb-3">
                                <label for="numero" class="form-label">{{ __('Numéro de Téléphone') }}</label>
                                <input id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="numero">
                                @error('numero')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Email (Utilisé par Acheteur) --}}
                            <div class="row mb-3">
                                <label for="email" class="form-label">{{ __('Adresse E-mail') }} (Acheteur)</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- ------------------------------------------------ --}}
                            {{-- BLOC 2 : INFORMATIONS DE CONNEXION (COMPTE) --}}
                            {{-- ------------------------------------------------ --}}
                            <h5 class="mt-4 mb-3 text-secondary">Informations de Connexion</h5>

                            {{-- Login (Utilisé par Compte) --}}
                            <div class="row mb-3">
                                <label for="login" class="form-label">{{ __('Identifiant de Connexion') }}</label>
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="username">
                                @error('login')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Mot de Passe --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="motPasse" class="form-label">{{ __('Mot de Passe') }}</label>
                                    <input id="motPasse" type="password" class="form-control @error('motPasse') is-invalid @enderror" name="motPasse" required autocomplete="new-password">
                                    @error('motPasse')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                {{-- Confirmation Mot de Passe --}}
                                <div class="col-md-6 mb-3">
                                    <label for="motPasse-confirm" class="form-label">{{ __('Confirmer Mot de Passe') }}</label>
                                    <input id="motPasse-confirm" type="password" class="form-control" name="motPasse_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            {{-- ------------------------------------------------ --}}
                            {{-- BLOC 3 : SÉLECTION DU RÔLE --}}
                            {{-- ------------------------------------------------ --}}
                            <h5 class="mt-4 mb-3 text-secondary">Rôle sur AgriLink</h5>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="profile_id" class="form-label">{{ __('Je m\'inscris en tant que :') }}</label>
                                    <select id="profile_id" name="profile_id" class="form-select @error('profile_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Sélectionner votre rôle</option>
                                        {{-- La variable $profiles vient du AuthController::showRegistrationForm() --}}
                                        @foreach($profiles as $profile)
                                            <option value="{{ $profile->id }}" {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                                                {{ $profile->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profile_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Bouton d'Inscription --}}
                            <div class="row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-lg btn-agrilink w-50">
                                        {{ __('S\'inscrire') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
