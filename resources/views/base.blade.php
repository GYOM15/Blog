<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <!-- Pour pouvoir changer dynamiquement la valeur du titre -->
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        @layer demo{
            button{
                all: unset;
            }
        }
    </style>
</head>
<body>

    @php
    // récupération du nom de notre route
        $routeName = request()->route()->getName()
    @endphp

    <nav class="navbar navbar-expand-lg navbar-light bg-primary mb-4">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Blog</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
              <li class="nav-item">
                <!-- Cela permet de lui dire de mettre le lien en mode active seulement si nous sommes sur cette page-->
                <a @class(['nav-link', 'active' => str_starts_with($routeName, 'blog.') ]) aria-current="page" href="{{route('blog.index')}}">Blog</a>
              </li>
              <li class=" nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
            </ul>

            <div class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                  {{Auth::user()->name}}
                  <form class="nav-item" action="{{route('auth.logout')}} " method="POST">
                    @method('delete')
                    @csrf
                    <button class="nav-link">Se déconnecter</button>
                  </form>
                @endauth 
                @guest
                  <div class="nav-item">
                    <a class="nav-link" href=" {{route('auth.login')}} ">Se connecter</a>
                  </div>    
                @endguest
            </div>
          </div>
        </div>
      </nav>
    <div class="container">
        @if(session('success'))
            <div class= "alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
