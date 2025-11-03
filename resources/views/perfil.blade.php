@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="perfil-header">
    <img src="{{ auth()->user()->avatar 
                ? asset('storage/' . auth()->user()->avatar) 
                : 'https://i.pravatar.cc/200?u=' . auth()->user()->id }}" 
         alt="Avatar de {{ auth()->user()->name }}" 
         class="perfil-avatar">
</div>

<div class="perfil-body">
    <h2>{{ auth()->user()->name }}</h2>
    <p>{{ auth()->user()->email }}</p>
<div class="perfil-estadisticas"> 
    <div class="estadistica"> 
        <h3>{{ $partidas_jugadas }}</h3> 
        <p>Partidas jugadas</p> </div> 
        <div class="estadistica"> 
            <h3>{{ $partidas_ganadas }}</h3> 
            <p>Partidas ganadas</p> 
        </div> <div class="estadistica"> 
            <h3>{{ $puntos_totales }}</h3> 
            <p>Puntos totales</p> 
        </div> 
    </div>

    <!-- Tabla de Partidas -->
    <div class="tabla-partidas">
        <h3>Mis Partidas</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre de la partida</th>
                    <th>Puntos obtenidos</th>
                    <th>Ganador</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach(auth()->user()->partidas as $partida)
                    <tr>
                        <td>{{ $partida->nombre }}</td>
                        <td>{{ $partida->pivot->puntuacion ?? 0 }}</td>
                        <td>{{ $partida->ganador ? $partida->ganador->name : '-' }}</td>
                        <td>{{ $partida->fecha_fin ? $partida->fecha_fin->format('d/m/Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top:20px;">
        @csrf
        <button type="submit" class="btn-logout">Cerrar Sesión</button>
    </form>
</div>
@endsection
