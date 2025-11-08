@extends('layouts.app')

@section('title', __('partida.title_track'))

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="trackeoApp"
     data-partida-id="{{ $partida->id }}"
     data-jugadores='@json($partida->jugadores->map(fn($j) => ["id" => $j->id, "nombre" => $j->name, "puntos" => $j->pivot->puntuacion]))'
     data-animales='@json($animales ?? [])'
     data-modo='{{ $partida->jugadores->count() == 2 ? "2jugadores" : "normal" }}'
     data-rondas='{{ $partida->jugadores->count() == 2 ? 4 : 2 }}'>

    <div class="container-fluid py-3">
        <div class="row g-3">
            <!-- PANEL IZQUIERDO -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="trackeo-reglas mb-3" style="max-height:300px; overflow-y:auto;">
                            <h4 class="fw-bold mb-2">{{ __('partida.rules_title') }}</h4>
                            <ul class="list-unstyled ps-3">
                                <li><strong>{{ __('partida.rules.bosque') }}</strong></li>
                                <li><strong>{{ __('partida.rules.prado') }}</strong></li>
                                <li><strong>{{ __('partida.rules.desierto') }}</strong></li>
                                <li><strong>{{ __('partida.rules.refugio') }}</strong></li>
                                <li><strong>{{ __('partida.rules.trono') }}</strong></li>
                                <li><strong>{{ __('partida.rules.isla') }}</strong></li>
                                <li><strong>{{ __('partida.rules.rio') }}</strong></li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <p class="mb-1">{{ __('partida.dice_result') }} <span id="valorDado">-</span></p>
                            <p class="fw-bold" id="visorDado">-</p>
                            <button id="btnTirarDado" class="btn btn-primary w-100">{{ __('partida.dice_button') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL CENTRAL -->
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h1 class="titulo-tablero mb-3">               
                            <span class="titulo-animal">ANIMAL</span>
                            <span class="titulo-draft">DRAFT</span>
                        </h1>
                        <div class="tablero">
                            <img src="{{ asset('imagenes/tablero.png') }}" alt="Tablero"
                                 class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL DERECHO -->
            <div class="col-12 col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h3>{{ __('partida.round') }} <span id="numRonda">1</span></h3>
                            <p>{{ __('partida.turn_of') }} <strong id="jugadorActual" class="parpadeo-jugador"></strong></p>
                        </div>

                        <div class="tracker">
                            <h4 class="fw-bold mb-2">{{ __('partida.tracking') }}</h4>
                            <form id="formTrackeo" class="d-grid gap-2">
                                <div>
                                    <label for="animal" class="form-label">Animal</label>
                                    <select id="animal" name="animal" class="form-select" required>
                                        @foreach(__('partida.animales') as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="recinto" class="form-label">{{ __('partida.enclosure_label') }}</label>
                                    <select id="recinto" name="recinto" class="form-select" required>
                                        @foreach(__('partida.recintos') as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="button" class="btn btn-success" id="btnRegistrar">
                                    {{ __('partida.register_button') }}
                                </button>
                            </form>

                            <button type="button" id="btnFinalizar" class="btn btn-danger w-100 mt-3">
                                {{ __('partida.finish_button') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLAS DE REGISTRO Y PUNTOS -->
        <div class="row g-3 mt-4">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3>{{ __('partida.movements_title') }}</h3>
                        <div class="table-responsive">
                            <table id="tablaRegistro" class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('partida.table_player') }}</th>
                                        <th>{{ __('partida.table_animal') }}</th>
                                        <th>{{ __('partida.table_enclosure') }}</th>
                                        <th>{{ __('partida.table_round') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3>{{ __('partida.score_title') }}</h3>
                        <div class="table-responsive">
                            <table id="tablaPuntos" class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('partida.table_player') }}</th>
                                        <th>{{ __('partida.table_points') }}</th>
                                        <th>{{ __('partida.table_tokens') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
