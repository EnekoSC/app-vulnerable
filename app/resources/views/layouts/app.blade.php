<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Distribuciones Santa S.L.')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f5f6f8; }
        .navbar-brand { font-weight:700; letter-spacing:.5px; }
        .lab-banner { background:#7a1f1f; color:#fff; font-size:.85rem; }
        .card { border:0; box-shadow:0 1px 3px rgba(0,0,0,.08); }
        footer { color:#8a8f98; font-size:.8rem; }
    </style>
</head>
<body>
    <div class="lab-banner text-center py-1">
        entorno de laboratorio — aplicación deliberadamente vulnerable, solo uso académico en red aislada
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background:#2b3a55;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Santa&nbsp;S.L.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Panel</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Catálogo</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('facturas.index') }}">Facturas</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('avatar.show') }}">Avatar</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Perfil</a></li>
                        @if(auth()->user()->esAdmin())
                            <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admin.index') }}">Administración</a></li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                    @else
                        <li class="nav-item d-flex align-items-center text-white-50 me-2">{{ auth()->user()->email }}</li>
                        <li class="nav-item">
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-light">Salir</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="container py-4 text-center">
        Distribuciones Santa S.L. · portal de distribuidores · uso interno
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
