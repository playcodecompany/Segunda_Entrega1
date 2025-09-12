@extends('layouts.app')

@section('title', 'Jugar - PlayCode')

@section('content')
<h2>¡Hola, {{ $nombre }}! Prepárate para jugar.</h2>

<div class="row mt-4">
    <!-- Crear partida -->
    <div class="col-md-6 mb-3">
        <div class="tablero p-3 shadow rounded">
            <h4>Crear partida</h4>
            <form method="POST" action="{{ route('crear_partida') }}">
                @csrf
                <button type="submit" class="btn-playcode">Crear partida</button>
            </form>
            @if(session('codigoPartida'))
                <div class="alert alert-success mt-3">
                    Código de partida creado: <strong>{{ session('codigoPartida') }}</strong>
                </div>
            @endif
        </div>
    </div>

    <!-- Unirse a partida -->
    <div class="col-md-6 mb-3">
        <div class="tablero p-3 shadow rounded">
            <h4>Unirse a una partida</h4>
            <form method="POST" action="{{ route('unirse_partida') }}">
                @csrf
                <input type="text" name="codigo_partida" class="campo-texto mb-2" placeholder="Ingrese código de partida" required>
                <button type="submit" class="btn-playcode">Unirse</button>
            </form>
            @if(session('mensajeUnirse'))
                <div class="alert alert-info mt-3">{{ session('mensajeUnirse') }}</div>
            @endif
        </div>
    </div>
</div>

@endsection
