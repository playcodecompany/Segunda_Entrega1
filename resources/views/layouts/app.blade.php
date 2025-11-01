<!DOCTYPE html>


<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'PlayCode')</title>


<!-- Bootstrap y fuentes -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Montserrat&display=swap" rel="stylesheet" />

<!-- Tu CSS local -->
    @vite(['resources/css/estilo.css', 'resources/js/app.js'])


</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <img src="{{ asset('imagenes/logo.jpg') }}" alt="Logo de PlayCode" style="max-height: 50px;" />
                    <h1 class="m-0"><span class="play">Play</span><span class="code">Code</span></h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" 
                    aria-controls="menuNav" aria-expanded="false" aria-label="Mostrar/Ocultar menú">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="menuNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('crear.partida') }}">Jugar</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin') }}">Panel</a></li>
                        <li class="nav-item">
                            <select class="form-select form-select-sm ms-3" onchange="cambiarIdioma(this.value)">
                                <option value="es" selected>Español</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

>>>>>>> a50c4ea (Actualizaciones del proyecto)

<main class="container my-5">
    @yield('content')
</main>

<footer>
    <p>&copy; 2025 PlayCode. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

    // Solo español por ahora
    function cambiarIdioma(lang) {
        window.location.href = "{{ route('home') }}";
    }
</script>


</body>
</html>
