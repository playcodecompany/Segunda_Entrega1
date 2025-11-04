@extends('layouts.app')

@section('title', 'Bienvenida')

@section('content')
<section class="row align-items-center mb-5">
    <div class="col-lg-6 mb-4 mb-lg-0">
        <div id="juegosCarrusel" class="carousel slide shadow rounded" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
                <div class="carousel-item active">
                    <img src="{{ asset('imagenes/Animaldraft.png') }}" class="d-block w-100" alt="Imagen del juego Animaldraft" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('imagenes/tablero.png') }}" class="d-block w-100" alt="Tablero del juego" />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#juegosCarrusel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#juegosCarrusel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
    <div class="col-lg-6">
        <h2>¡Bienvenid@ a <span class="play">Play</span><span class="code">Code</span>!</h2>
        <p class="lead">
            Unite a la mesa digital para aprender, competir y divertirte.<br />
            No hace falta instalar nada: jugá directo desde el navegador, donde y cuando quieras.<br /><br />
            Cientos de <strong>jugadores</strong> ya disfrutan de <strong>Animaldraft</strong> (inspirado en Draftosaurus) y otros juegos interactivos.<br />
            <strong>Gratis, fácil y muy divertido.</strong>
        </p>
        <div class="mt-3">
            <a href="{{ url('/iniciosesion') }}" class="boton-inicioregistro me-2">Iniciar sesión</a>
            <a href="{{ url('/registro') }}" class="boton-inicioregistro">Registrarse</a>
        </div>
    </div>
</section>
<!-- Sección de información de la empresa -->
<section class="seccion-empresa">
    <h3>Nuestra Empresa</h3>
    <p>
        <strong>PlayCode</strong> es líder en soluciones digitales de entretenimiento y juegos de mesa interactivos. 
        Nuestra plataforma permite a los usuarios disfrutar de juegos innovadores desde cualquier dispositivo, fomentando la interacción y diversión.
    </p>

    <div class="row mision-vision mt-4">
        <div class="col-md-6">
            <h4>Misión</h4>
            <p>
                Nuestra misión es diseñar y desarrollar soluciones físicas e informáticas en base a tendencias innovadoras que mejoren la experiencia de juego de los clientes. 
                Nos enfocamos en ofrecer productos accesibles, fáciles de usar y visualmente agradables, optimizando la dinámica entre jugadores y fomentando el interés por las aplicaciones tecnológicas en entretenimiento.
            </p>
        </div>
        <div class="col-md-6">
            <h4>Visión</h4>
            <p>
                Aspiramos a que nuestra empresa se convierta en una referencia digital de juegos de mesa, reconocida por su funcionalidad, precisión y calidad técnica. 
                Buscamos expandir nuestros productos a torneos, modalidades multijugador online y sistemas de ranking, convirtiéndonos en un modelo escalable y adaptable.
            </p>
        </div>
    </div>
</section>

<!-- Opiniones ficticias de usuarios -->
<section class="opiniones mb-5">
    <h3 class="text-center mb-4">Lo que dicen nuestros usuarios</h3>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">"Me encanta PlayCode, puedo jugar con mis amigos desde cualquier lugar." – <strong>Ana P.</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">"La plataforma es muy intuitiva y el juego es muy entretenido. ¡Recomendado!" – <strong>Lucas M.</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">"Me sorprendió la calidad y el diseño del juego. Definitivamente seguiré usando PlayCode." – <strong>Sofía R.</strong></p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

