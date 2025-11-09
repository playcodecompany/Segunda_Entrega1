@extends('layouts.app')

@section('title', __('perfil.title'))

@section('content')
<div class="perfil-header">
    <img src="{{ auth()->user()->avatar 
                ? asset('storage/' . auth()->user()->avatar) 
                : asset('imagenes/sinfoto.jpg') }}" 
         alt="{{ auth()->user()->name }}'s Avatar" 
         class="perfil-avatar">
</div>

<div class="perfil-body">
    <h2>{{ __('perfil.avatar_of', ['name' => auth()->user()->name]) }}</h2>
    <p><strong>ID:</strong> {{ auth()->user()->id }}</p>
    <p>{{ auth()->user()->email }}</p>


    <div class="perfil-estadisticas"> 
        <div class="estadistica"> 
            <h3>{{ $partidas_jugadas }}</h3> 
            <p>{{ __('perfil.games_played') }}</p>
        </div> 
        <div class="estadistica"> 
            <h3>{{ $partidas_ganadas }}</h3> 
            <p>{{ __('perfil.games_won') }}</p> 
        </div> 
    </div>

    <div class="tabla-partidas">
        <h3>{{ __('perfil.my_games') }}</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{ __('perfil.game_name') }}</th>
                    <th>{{ __('perfil.points_earned') }}</th>
                    <th>{{ __('perfil.winner') }}</th>
                    <th>{{ __('perfil.date') }}</th>
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
        <button type="submit" class="btn-logout">{{ __('perfil.logout_button') }}</button>
    </form>
</div>
@endsection
