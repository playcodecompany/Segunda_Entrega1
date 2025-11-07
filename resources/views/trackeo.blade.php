@extends('layouts.app')

@section('title', 'Trackeo de Partida')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="trackeoApp"
     data-partida-id="{{ $partida->id }}"
     data-jugadores='@json($partida->jugadores->map(fn($j) => ["id" => $j->id, "nombre" => $j->name, "puntos" => $j->pivot->puntuacion]))'
     data-animales='@json($animales ?? [])'
     data-modo='{{ $partida->jugadores->count() == 2 ? "2jugadores" : "normal" }}'
     data-rondas='{{ $partida->jugadores->count() == 2 ? 4 : 2 }}'>


    <div class="juego-container">
        <div class="panel-izq">
            <div class="trackeo-reglas" style="max-height:300px; overflow-y:auto; border:1px solid #ccc; padding:10px; border-radius:5px; margin-top:10px;"> 
                 <h4>{{ __('partida.rules_title') }}</h4>
                <ul> 
                   <li><strong>{{ __('partida.rules.bosque') }}</strong></li>
                    <li><strong>{{ __('partida.rules.prado') }}</strong></li>
                    <li><strong>{{ __('partida.rules.desierto') }}</strong></li>
                    <li><strong>{{ __('partida.rules.refugio') }}</strong></li>
                    <li><strong>{{ __('partida.rules.trono') }}</strong></li>
                    <li><strong>{{ __('partida.rules.isla') }}</strong></li>
                    <li><strong>{{ __('partida.rules.rio') }}</strong></li>
                </ul> 
                <h4>{{ __('partida.rules_mode_title') }}</h4>
                <ul>
                    @foreach(__('partida.rules_mode') as $rule)
                        <li>{{ $rule }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="dado" style="text-align:center; margin-top:20px;">
                <p>{{ __('partida.dice_result') }} <span id="valorDado">-</span></p>
                <button class="btn-registrar">{{ __('partida.dice_button') }}</button>
            </div>
        </div>

        <div class="panel-centro">
            <h1 class="titulo-tablero"><span class="titulo-animal">ANIMAL</span> <span class="titulo-draft">DRAFT</span></h1>
            <div class="tablero">
                <img src="{{ asset('imagenes/tablero.png') }}" alt="Tablero" class="img-tablero">
            </div>
        </div>

        <div class="panel-der">
            <div class="ronda" style="text-align:center;">
                <h3>{{ __('partida.round') }} <span id="numRonda">1</span></h3>
                    <p>{{ __('partida.turn_of') }} <strong id="jugadorActual" class="parpadeo-jugador"></strong></p>
            </div>

            <div class="tracker">
                <h3>{{ __('partida.tracking') }}</h3>
                <form id="formTrackeo">
                    <label for="animal">Animal:</label>
                    <select id="animal" name="animal" required>
                         @foreach(__('partida.animales') as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                    </select>

                     <label for="recinto">{{ __('partida.enclosure_label') }}</label>
                    <select id="recinto" name="recinto" required>
                        @foreach(__('partida.recintos') as $key => $label)
                        <option value="{{ $label }}">{{ $label }}</option>
                    @endforeach
                    </select>

                    <button type="button" class="btn-registrar" id="btnRegistrar">
                    {{ __('partida.register_button') }}
                </button>
                </form>
                

                <button type="button" id="btnFinalizar" class="btn-turno" style="margin-top:10px;">
                {{ __('partida.finish_button') }}
            </div>
        </div>

        <div class="panel-registro" style="display:flex; gap:20px; margin-top:20px;">
            <div style="flex:2;">
                <h3>{{ __('partida.movements_title') }}</h3>
                <table id="tablaRegistro" class="table table-bordered">
                    <thead>
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

            <div style="flex:1;">
                 <h3>{{ __('partida.score_title') }}</h3>
                <table id="tablaPuntos" class="table table-bordered">
                    <thead>
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
@endsection
