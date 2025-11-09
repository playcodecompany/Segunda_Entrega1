@extends('layouts.app')

@section('title', __('ranking.title'))

@section('content')
<div class="container my-4 resumen-podio-container">
    <h1 class="text-center mb-4">{{ __('ranking.position') }}</h1>

    @php
        $jugadoresOrdenados = $partida->jugadores->sortByDesc(fn($j) => $j->pivot->puntuacion)->values();
    @endphp

    <div class="podio-principal d-flex flex-wrap justify-content-center gap-4">
        @for($i = 0; $i < 3; $i++)
            @php
                $jugador = $jugadoresOrdenados[$i] ?? null;
            @endphp
            <div class="puesto puesto-{{ $i+1 }} text-center p-3 rounded shadow-sm flex-grow-1" style="min-width: 200px;">
                <div class="numero fs-3 fw-bold">{{ $i+1 }}°</div>
                <div class="nombre fs-5">{{ $jugador->name ?? __('ranking.player') }}</div>
                <div class="puntos">{{ $jugador?->pivot->puntuacion ?? 0 }} {{ __('ranking.points') }}</div>
            </div>
        @endfor
    </div>

    <h2 class="text-center mt-5 mb-3">{{ __('ranking.matches_played') }}</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <tbody>
                <tr>
                    <th>{{ __('ranking.matches_won') }}</th>
                    <td>{{ $partida->ganador?->name ?? __('ranking.empty') }}</td>
                </tr>
                <tr>
                    <th>{{ __('ranking.date') }}</th>
                    <td>{{ $partida->fecha_inicio?->format('d/m/Y H:i') ?? __('ranking.no_record') }}</td>
                </tr>
                <tr>
                    <th>{{ __('ranking.players') }}</th>
                    <td>{{ $partida->jugadores->count() }}</td>
                </tr>
                <tr>
                    <th>{{ __('ranking.max_score') }}</th>
                    <td>{{ $jugadoresOrdenados->first()?->pivot->puntuacion ?? 0 }} {{ __('ranking.points') }}</td>
                </tr>
                <tr>
                    <th>{{ __('ranking.duration') }}</th>
                    <td>{{ $partida->duracion ?? '—' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">{{ __('ranking.back') }}</a>
    </div>
</div>
@endsection
