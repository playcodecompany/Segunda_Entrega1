@extends('layouts.app')

@section('title', __('ranking.title'))

@section('content')
<div class="resumen-podio-container">
    <h1>{{ __('ranking.position') }}</h1>

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
                <div class="nombre">{{ $jugador->name ?? __('ranking.player') }}</div>
                <div class="puntos">{{ $jugador?->pivot->puntuacion ?? 0 }} {{ __('ranking.points') }}</div>
            </div>
        @endfor
    </div>

    <h2>{{ __('ranking.matches_played') }}</h2>
    <table>
        <tr><th>{{ __('ranking.matches_won') }}</th><td>{{ $partida->ganador?->name ?? __('ranking.empty') }}</td></tr>
        <tr><th>{{ __('ranking.date') }}</th><td>{{ $partida->fecha_inicio?->format('d/m/Y H:i') ?? __('ranking.no_record') }}</td></tr>
        <tr><th>{{ __('ranking.players') }}</th><td>{{ $partida->jugadores->count() }}</td></tr>
        <tr><th>{{ __('ranking.max_score') }}</th><td>{{ $jugadoresOrdenados->first()?->pivot->puntuacion ?? 0 }} {{ __('ranking.points') }}</td></tr>
        <tr><th>{{ __('ranking.duration') }}</th><td>{{ $partida->duracion ?? '—' }} </td></tr>
    </table>
</div>
    <a href="{{ route('home') }}" class="btn btn-secondary">{{ __('ranking.back') }}</a>
@endsection
