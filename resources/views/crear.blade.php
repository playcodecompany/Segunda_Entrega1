@extends('layouts.app')

@section('title', 'Crear Partida')

@section('content')

<div class="crear-partida">
    <h1>CREAR PARTIDA</h1>

<form action="{{ route('partidas.guardar') }}" method="POST" class="form-crear">
    @csrf

    <label for="nombre_partida">Nombre de la partida:</label>
    <input type="text" id="nombre_partida" name="nombre_partida" maxlength="100" required>

    <label for="num_jugadores">Cantidad total de jugadores (2-5):</label>
    <input type="number" id="num_jugadores" name="num_jugadores" min="2" max="5" value="2" required onchange="generarCamposJugadores()">

    <div id="campos-jugadores"></div>

    <button type="submit" class="btn-crear">CREAR</button>
</form>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/crear-partida.js') }}"></script>
@endpush