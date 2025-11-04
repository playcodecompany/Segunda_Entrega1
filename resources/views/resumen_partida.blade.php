@extends('layouts.app')

@section('title', 'Resumen de Partida')

@section('content')
<div class="resumen-podio-container">
    <h1>¡Resultados de la Partida!</h1>

    @php
        $jugadoresOrdenados = $partida->jugadores->sortByDesc(fn($j) => $j->pivot->puntuacion)->values();
    @endphp

    <div class="podio-principal">
        @for($i = 0; $i < 3; $i++)
            @php
                $jugador = $jugadoresOrdenados[$i] ?? null;
            @endphp
            <div class="puesto puesto-{{ $i+1 }}">
                <div class="numero">{{ $i+1 }}°</div>
                <div class="nombre">{{ $jugador->name ?? 'Vacío' }}</div>
                <div class="puntos">{{ $jugador?->pivot->puntuacion ?? 0 }} pts</div>
            </div>
        @endfor
    </div>

    <h2>Resumen de la Partida</h2>
    <table>
        <tr><th>Ganador</th><td>{{ $partida->ganador?->name ?? 'Vacío' }}</td></tr>
        <tr><th>Fecha</th><td>{{ $partida->fecha_inicio?->format('d/m/Y H:i') ?? 'Sin registro' }}</td></tr>
        <tr><th>Jugadores</th><td>{{ $partida->jugadores->count() }}</td></tr>
        <tr><th>Puntaje Máximo</th><td>{{ $jugadoresOrdenados->first()?->pivot->puntuacion ?? 0 }} pts</td></tr>
        <tr><th>Duración</th><td>{{ $partida->duracion ?? '—' }} minutos</td></tr>
    </table>
</div>
    <a href="{{ route('home') }}" class="btn btn-secondary">Volver</a>
@endsection
