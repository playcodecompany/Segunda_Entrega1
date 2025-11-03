@extends('layouts.app')

@section('title', 'Crear Partida')

@section('content')

<div class="crear-partida">
    <h1>CREAR PARTIDA</h1>

<form action="{{ route('partidas.guardar') }}" method="POST" class="form-crear">
    @csrf

    <label for="nombre_partida">Nombre de la partida:</label>
    <input type="text" id="nombre_partida" name="nombre_partida" maxlength="100" required>

    <label for="num_jugadores">Cantidad total de jugadores (2-5):</label>
    <input type="number" id="num_jugadores" name="num_jugadores" min="2" max="5" value="2" required onchange="generarCamposJugadores()">

    <div id="campos-jugadores"></div>

    <button type="submit" class="btn-crear">CREAR</button>
</form>
```

</div>

<script>
function generarCamposJugadores() {
    const numJugadores = parseInt(document.getElementById('num_jugadores').value);
    const contenedor = document.getElementById('campos-jugadores');
    contenedor.innerHTML = '';

    // El creador es jugador 1, por eso i=2
    for (let i = 2; i <= numJugadores; i++) {
        const div = document.createElement('div');
        div.innerHTML = `
            <label for="jugador_${i}">ID Jugador ${i}:</label>
            <input type="number" id="jugador_${i}" name="jugadores[]" min="1" required>
        `;
        contenedor.appendChild(div);
    }
}

// Inicializar campos al cargar
generarCamposJugadores();
</script>

@endsection
