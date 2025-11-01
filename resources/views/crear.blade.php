@extends('layouts.app')

@section('title', 'Crear Partida')

@section('content')

<div class="crear-partida">
    <h1>CREAR PARTIDA</h1>

```
<form action="{{ route('partidas.guardar') }}" method="POST" class="form-crear">
    @csrf

    <label for="nombre_jugador">Nombre del jugador (Creador):</label>
    <input type="text" id="nombre_jugador" name="nombre_jugador" value="{{ auth()->user()->nombre ?? '' }}" readonly>

    <label for="num_jugadores">Cantidad de jugadores (2-5):</label>
    <input type="number" id="num_jugadores" name="num_jugadores" min="2" max="5" value="3" required onchange="generarCamposJugadores()">

    <div id="campos-jugadores">
        <!-- Campos dinámicos para seleccionar jugadores se generarán aquí -->
    </div>

    <button type="submit" class="btn-crear">CREAR</button>
</form>
```

</div>

<script>
const jugadoresDB = @json($jugadores); // Array de jugadores desde el controlador

function generarCamposJugadores() {
    const numJugadores = document.getElementById('num_jugadores').value;
    const contenedor = document.getElementById('campos-jugadores');
    contenedor.innerHTML = '';

    for (let i = 2; i <= numJugadores; i++) {
        const div = document.createElement('div');
        let options = '';
        jugadoresDB.forEach(j => {
            options += `<option value="${j.id}">${j.nombre}</option>`;
        });
        div.innerHTML = `
            <label for="jugador_${i}">Jugador ${i}:</label>
            <select id="jugador_${i}" name="jugadores[]">
                ${options}
            </select>
        `;
        contenedor.appendChild(div);
    }
}

// Generar campos iniciales
generarCamposJugadores();
</script>

@endsection
