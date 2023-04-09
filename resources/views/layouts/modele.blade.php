<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap-theme.min.css" rel="stylesheet" integrity="sha384-QhE7VdpHJc8MYj0MjvzAaztT3q3sd8j7VXonvBdD7+mrv75bgpM4i4v4F1zmIm+" crossorigin="anonymous">
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <style>
        .navbar {
            background-color: rgb(82, 34, 106);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 0.5rem 1rem;
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }

        .nav-link:hover {
            color: #e5e5e5 !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30' width='30' height='30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-collapse {
            justify-content: flex-end;
        }

        .navbar-nav {
            align-items: center;
        }

        .navbar-toggler {
            border: none;
        }

        .btn-primary {
            background-color: rgb(82, 34, 106);
            border-color: rgb(82, 34, 106);
        }

        .btn-primary:hover {
            background-color: #6c278e;
            border-color: #6c278e;
        }

        .form-control:focus {
            border-color: #7f7fd5;
            box-shadow: 0 0 0 0.2rem rgba(127, 127, 213, 0.25);
        }

        .footer {
    background-color: #6c278e;
    color: #ffffff;
    padding: 0.5rem 1rem;
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    
}




    </style>
</head>
<body class="@yield('body-class')">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Planning</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('main') }}">Accueil</a>
                </li>
                @guest()
                <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">S'enregistrer</a>
                </li>
                @endguest
                @auth
    
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('profil') }}">Mon profil</a>
                </li>
            
                <li class="nav-item">
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">Se déconnecter</button>
                  </form>
                </li>
                @endauth
                @if(auth()->check() && auth()->user()->isAdmin())
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.users.index') }}">Portail Admin</a>
                </li>  
                    
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
<footer class="footer">
    <div class="container text-center">
        <p>&copy; 2023 Planning - Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>    
