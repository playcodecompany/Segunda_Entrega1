@extends('layouts.app')

@section('title', 'Trackeo de Partida - PlayCode')

@section('content')
<h2>Partida: {{ $codigoPartida }}</h2>



<!-- Tablero visual + formulario de trackeo -->
<div class="row mt-4">
    <!-- Animales Disponibles -->
    <div class="col-md-6 mb-3">
        <div class="tablero p-3 shadow rounded">
            <h4>Animales Disponibles</h4>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <span class="badge bg-success">Serpiente</span>
                <span class="badge bg-warning text-dark">Camello</span>
                <span class="badge bg-info text-dark">Conejo</span>
                <span class="badge bg-secondary">Tortuga</span>
                <span class="badge bg-danger">Caracol</span>
                <span class="badge bg-primary text-white">Ratón</span>
            </div>
        </div>
    </div>

    <!-- Formulario de trackeo -->
    <div class="col-md-6 mb-3">
        <div class="tablero p-3 shadow rounded">
            <h4>Trackeo de Partida</h4>
            <form class="formulario-registro">
                <label class="etiqueta" for="animal">Seleccionar animal:</label>
                <select id="animal" class="campo-texto mb-2">
                    <option>Serpiente</option>
                    <option>Camello</option>
                    <option>Conejo</option>
                    <option>Tortuga</option>
                    <option>Caracol</option>
                    <option>Ratón</option>
                </select>

                <label class="etiqueta" for="recinto">Seleccionar recinto:</label>
                <select id="recinto" class="campo-texto mb-2">
                    <option>La pradera espejo</option>
                    <option>Trio salvaje</option>
                    <option>El desieto del amor</option>
                    <option>Territorio de la diversidad</option>
                    <option>Trono Animal</option>
                    <option>Lágrima del Desierto</option>
                </select>

                <button type="button" class="btn-playcode mt-2">Registrar acción</button>
            </form>
        </div>
    </div>
</div>
@endsection
