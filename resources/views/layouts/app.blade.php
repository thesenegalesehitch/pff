<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'AgriLink ')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
        :root {
            --agrilink-primary: #198754;
            /* Vert Bootstrap Success */
            --agrilink-dark-green: #0a4f32;
            --agrilink-light-bg: #e9f5e9;
            /* Arrière-plan très clair */
            --agrilink-brown: #795548;
            /* Couleur Terre */
        }

        body {
            background-color: var(--agrilink-light-bg);
        }

        .navbar-agrilink {
            background-color: var(--agrilink-primary);
        }

        .navbar-agrilink .nav-link,
        .navbar-agrilink .navbar-brand {
            color: white !important;
        }

        .btn-agrilink {
            background-color: var(--agrilink-primary);
            border-color: var(--agrilink-dark-green);
            color: white;
        }

        .btn-agrilink:hover {
            background-color: var(--agrilink-dark-green);
            border-color: var(--agrilink-primary);
        }

        .card-agrilink {
            border-left: 5px solid var(--agrilink-primary);
        }
        </style>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-agrilink shadow-sm ">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                        AgriLink
                    </a>
                    <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('produits.catalogue') }}">Produits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Matériels</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ms-auto">
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-outline-light ms-2"
                                    href="{{ route('register') }}">S'inscrire</a>
                            </li>
                            @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->acheteur->prenom }} ({{ Auth::user()->profile->nom }})
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Mon Profil</a></li>
                                    @if(Auth::user()->profile->nom === 'Producteur')
                                    <li><a class="dropdown-item" href="{{ route('producteur.dashboard') }}">Tableau de Bord</a></li>
                                    <li><a class="dropdown-item" href="{{ route('producteur.produits.index') }}">Gérer Produits</a></li>
                                    @endif
                                    @if(Auth::user()->profile->nom === 'ProprietaireMateriel')
                                    <li><a class="dropdown-item" href="{{ route('proprietaire.dashboard') }}">Tableau de Bord</a></li>
                                    <li><a class="dropdown-item" href="{{ route('proprietaire.materiels.index') }}">Gérer Matériels</a></li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Déconnexion</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-4">
            <div class="container">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
