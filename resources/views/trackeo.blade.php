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
                <h4>Reglas de los Recintos</h4> 
                <ul> 
                    <li><strong>El Bosque Uniforme:</strong> Solo animales de la misma especie. Se colocan de izquierda a derecha. Puntos: 2, 4, 8, 12, 18, 24.</li> 
                    <li><strong>El Prado Variado:</strong> Solo animales distintos. Se colocan de izquierda a derecha. Puntos: 1, 3, 6, 10, 15, 21.</li> 
                    <li><strong>El Desierto del Amor:</strong> Cada pareja de animales iguales suma 5 puntos. Animales sin pareja no suman.</li> 
                    <li><strong>El Refugio Trío:</strong> Hasta 3 animales. Exactamente 3 animales colocados suman 7 puntos.</li> 
                    <li><strong>El Trono del Animal:</strong> Solo 1 animal. Al final gana 7 puntos el jugador que tenga más de esa especie en su tablero. En empate, ambos ganan 7.</li> 
                    <li><strong>La Isla Única:</strong> Solo 1 animal. Al final suma 7 puntos si es el único de su especie en tu parque.</li> 
                    <li><strong>El Río:</strong> Cada animal colocado suma 1 punto.</li> 
                </ul> 
                <h4>Modo de 2 jugadores</h4>
                <ul>
                    <li>Se juega en 4 rondas en lugar de 2.</li>
                    <li>2 animales de cada especie se devuelven a la caja antes de comenzar.</li>
                    <li>Al principio de cada ronda, cada jugador toma 6 animales al azar.</li>
                    <li>Solo se pueden colocar 3 por ronda.</li>
                    <li>Después de colocar, devuelven 1 animal a la caja.</li>
                    <li>Intercambian los restantes.</li>
                    <li>Al final de la ronda 4, cada uno tendrá 12 animales.</li>
                </ul>
            </div>

            <div class="dado" style="text-align:center; margin-top:20px;">
                <div id="visorDado" style="font-size:2em; margin-bottom:10px;">-</div>
                <p>Resultado: <span id="valorDado">-</span></p>
                <button class="btn-registrar" id="btnTirarDado">Tirar Dado</button>
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
                <h3>Ronda <span id="numRonda">1</span></h3>
                <p>Turno de: <strong id="jugadorActual" class="parpadeo-jugador"></strong></p>
            </div>

            <div class="tracker">
                <h3>Trackeo</h3>
                <form id="formTrackeo">
                    <label for="animal">Animal:</label>
                    <select id="animal" name="animal" required>
                        <option value="Tortuga">Tortuga</option>
                        <option value="Camello">Camello</option>
                        <option value="Caracol">Caracol</option>
                        <option value="Serpiente">Serpiente</option>
                        <option value="Conejo">Conejo</option>
                        <option value="Ratón">Ratón</option>
                    </select>

                    <label for="recinto">Recinto:</label>
                    <select id="recinto" name="recinto" required>
                        <option value="El Bosque Uniforme">El Bosque Uniforme</option>
                        <option value="El Prado Variado">El Prado Variado</option>
                        <option value="La Isla Única">La Isla Única</option>
                        <option value="El Desierto del Amor">El Desierto del Amor</option>
                        <option value="El Refugio Trío">El Refugio Trío</option>
                        <option value="El Trono del Animal">El Trono del Animal</option>
                        <option value="El Río">El Río</option>
                    </select>

                    <button type="button" class="btn-registrar" id="btnRegistrar">Registrar Movimiento</button>
                </form>
                

        <button type="button" id="btnFinalizar" class="btn-turno" style="margin-top:10px;">Finalizar Partida</button>

            </div>
        </div>

        <div class="panel-registro" style="display:flex; gap:20px; margin-top:20px;">
            <div style="flex:2;">
                <h3>Registro de Movimientos</h3>
                <table id="tablaRegistro" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jugador</th>
                            <th>Animal</th>
                            <th>Recinto</th>
                            <th>Ronda</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div style="flex:1;">
                <h3>Puntuación</h3>
                <table id="tablaPuntos" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jugador</th>
                            <th>Puntos</th>
                            <th>Fichas</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
