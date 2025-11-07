@extends('layouts.app') 

@section('title',  __('home.web'))

@section('content')
<section class="row align-items-center mb-5">
    <div class="col-lg-6 mb-4 mb-lg-0">
        {{-- carrusel con imagenes del juego --}}
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
        {{-- texto de bienvenida y botones de inicio/registro --}}
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

{{-- info de la empresa --}}
<section class="seccion-empresa">
    <h3>{{ __('home.company_title') }}</h3>
    <p>{{ __('home.company_text') }}</p>

    <div class="row mision-vision mt-4">
        <div class="col-md-6">
            {{-- misión --}}
            <h4>{{ __('home.mission_title') }}</h4>
            <p>{{ __('home.mission_text') }}</p>
        </div>
        <div class="col-md-6">
            {{-- visión --}}
            <h4>{{ __('home.vision_title') }}</h4>
            <p>{{ __('home.vision_text') }}</p>
        </div>
    </div>
</section>

{{-- opiniones inventadas solo para decorar --}}
<section class="opiniones mb-5">
    <h3>{{ __('home.opinions_title') }}</h3>
    <div class="row">
        @for ($i = 1; $i <= 3; $i++)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p>{{ __('home.opinion_' . $i) }}</p>
                </div>
            </div>
        </div>
        @endfor
    </div>
</section>

{{-- parte con ubicación, valores y merch --}}
<section class="info-empresa mt-5 py-5">
    <div class="container">
        {{-- ubicación en google maps --}}
        <div class="text-center mb-5">
            <h3>{{ __('home.location_title') }}</h3>
            <p>{{ __('home.location_text') }}</p>
            <div class="ratio ratio-16x9 shadow rounded my-3">
                <iframe 
                    src="https://www.google.com/maps?q=25%20de%20Mayo%20y%20Bartolom%C3%A9%20Mitre%20Montevideo&output=embed"
                    width="100%" height="400" style="border:0;" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>

        <hr class="my-5">

        {{-- valores de la empresa --}}
        <div class="row text-center mb-5">
            <h3>{{ __('home.values_title') }}</h3>

            <div class="col-md-4 mt-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5>{{ __('home.value_1_title') }}</h5>
                        <p>{{ __('home.value_1_text') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5>{{ __('home.value_2_title') }}</h5>
                        <p>{{ __('home.value_2_text') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5>{{ __('home.value_3_title') }}</h5>
                        <p>{{ __('home.value_3_text') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        {{-- merch de la página --}}
        <section class="seccion-merch py-5 text-center">
            <h3 class="mb-4">{{ __('home.merch_title') }}</h3>
            <p class="lead mb-5">{{ __('home.merch_text') }}</p>

            <button class="btn-nav left" id="merchPrev">&#10094;</button>
            <button class="btn-nav right" id="merchNext">&#10095;</button>

            <div id="merchContainer" class="merch-container">
                @for ($i = 1; $i <= 15; $i++)
                    <div class="merch-item">
                        <div class="imagen-dual">
                            <img src="{{ asset('imagenes/merch' . $i . '_frente.jpg') }}" 
                                 class="frente" alt="Producto {{ $i }} frente">
                            @if ($i <= 4)
                                <img src="{{ asset('imagenes/merch' . $i . '_espalda.jpg') }}" 
                                     class="espalda" alt="Producto {{ $i }} espalda">
                            @endif
                        </div>
                        <h6>{{ __('home.merch_title') }} {{ $i }}</h6>
                        <p class="precio">$ {{ rand(500, 1000) }}</p>
                    </div>
                @endfor
            </div>
        </section>
    </div>
</section>

@endsection
