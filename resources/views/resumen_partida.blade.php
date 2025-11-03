@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h1 class="mb-3">Resumen de la Partida: {{ $partida->nombre }}</h1>
    <p>
    Fecha inicio: {{ \Carbon\Carbon::parse($partida->fecha_inicio)->format('d/m/Y H:i') }} |
    Fecha fin: {{ $partida->fecha_fin ? \Carbon\Carbon::parse($partida->fecha_fin)->format('d/m/Y H:i') : 'En curso' }}
</p>


<h2 class="mt-4">🏆 Ranking de Jugadores</h2>
<table class="table table-striped table-bordered mt-2">
    <thead class="thead-dark">
        <tr>
            <th>Posición</th>
            <th>Jugador</th>
            <th>Puntos</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jugadoresRanking as $index => $jugador)
        <tr @if($index == 0) class="table-success" @endif>
            <td>{{ $index + 1 }}</td>
            <td>{{ $jugador->nombre }}</td>
            <td>{{ $jugador->pivot->puntuacion }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2 class="mt-4">📋 Movimientos</h2>
@if($partida->movimientos->count() > 0)
<table class="table table-sm table-bordered mt-2">
    <thead class="thead-light">
        <tr>
            <th>Ronda</th>
            <th>Jugador</th>
            <th>Animal</th>
            <th>Recinto</th>
            <th>Puntos Obtenidos</th>
            <th>Fecha/Hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach($partida->movimientos as $mov)
        <tr>
            <td>{{ $mov->ronda }}</td>
            <td>{{ $mov->jugador->nombre }}</td>
            <td>{{ $mov->animal }}</td>
            <td>{{ $mov->recinto }}</td>
            <td>{{ $mov->puntos }}</td>
            <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No hay movimientos registrados aún.</p>
@endif
</div>
@endsection