@extends('layouts.app')

@section('title', 'Panel')

@section('content')
<h2>¡Bienvenido, {{ $nombre }}!</h2>
<p>Desde aquí podés ver tus partidas y estadísticas.</p>

<div class="row mt-4">
    <!-- Partidas -->
    <div class="col-md-6 mb-3">
        <div class="tablero p-3 shadow rounded">
            <h4>Mis Partidas</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Juego</th>
                        <th>Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partidas as $p)
                    <tr>
                        <td>{{ $p['fecha'] }}</td>
                        <td>{{ $p['juego'] }}</td>
                        <td>{{ $p['puntaje'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="col-md-6 mb-3">
        <div class="tablero p-3 shadow rounded">
            <h4>Estadísticas</h4>
            <ul class="list-group">
                <li class="list-group-item">Total de partidas: {{ $estadisticas['total_partidas'] }}</li>
                <li class="list-group-item">Puntaje máximo: {{ $estadisticas['puntaje_maximo'] }}</li>
                <li class="list-group-item">Puntaje promedio: {{ $estadisticas['puntaje_promedio'] }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cambiarIdioma(lang) {
    // Lógica para cambiar idioma si se implementa
}
</script>
@endpush
