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
        <h2>{{ __('home.title', ['play' => 'PlayCode']) }}</h2>
        <p class="lead">
            {{ __('home.intro') }}<br />
            {{ __('home.description') }}<br /><br />
            {{ __('home.more_info') }}
        </p>
        <div class="mt-3">
            <a href="{{ url('/iniciosesion') }}" class="boton-inicioregistro me-2">{{ __('home.login') }}</a>
            <a href="{{ url('/registro') }}" class="boton-inicioregistro">{{ __('home.register') }}</a>
        </div>
    </div>
</section>
<!-- Sección de información de la empresa -->
<section class="seccion-empresa">
    <h3>{{ __('home.company_title') }}</h3>
    <p>{{ __('home.company_text') }}</p>
    

    <div class="row mision-vision mt-4">
        <div class="col-md-6">
            <h4>{{ __('home.mission_title') }}</h4>
            <p>{{ __('home.mission_text') }}</p>

        </div>
        <div class="col-md-6">
            <h4>{{ __('home.vision_title') }}</h4>
                 <p>{{ __('home.vision_text') }}</p>
        </div>
    </div>
</section>

<!-- Opiniones ficticias de usuarios -->
<section class="opiniones mb-5">
    <h3>{{ __('home.opinions_title') }}</h3>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p>{{ __('home.opinion_1') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p>{{ __('home.opinion_2') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p>{{ __('home.opinion_3') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

