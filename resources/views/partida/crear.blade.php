@extends('layouts.app')

@section('title',  __('partida.title_create'))

@section('content')

<div class="crear-partida">
    <h1>{{ __('partida.heading_create') }}</h1>

    <form action="{{ route('partidas.guardar') }}" method="POST" class="form-crear">
        @csrf

        <label for="nombre_partida">{{ __('partida.name_label') }}</label>
        <input type="text" id="nombre_partida" name="nombre_partida" maxlength="100" required>

        <label for="num_jugadores">{{ __('partida.players_label') }}</label>
        <input type="number" id="num_jugadores" name="num_jugadores" min="2" max="5" value="2" required>

        <div id="campos-jugadores"></div>

        <button type="submit" class="btn-crear">{{ __('partida.create_button') }}</button>
    </form>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/crear-partida.js') }}"></script>
@endpush
