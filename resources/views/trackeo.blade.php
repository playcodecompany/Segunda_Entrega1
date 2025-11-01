@extends('layouts.app')

@section('title', 'Trackeo de Partida')

@section('content')

<div class="juego-container">
    <!-- Panel izquierdo: animales y dado -->
    <div class="panel-izq">
        <div class="lista-animales-container">
            <h2>Animales</h2>
            <ul class="lista-animales">
                @foreach ($animales as $animal)
                    <li>{{ $animal }}</li>
                @endforeach
            </ul>
        </div>

```
    <div class="dado">
        <div id="visorDado"></div>
        <p>Resultado: <span id="valorDado">-</span></p>
        <button class="btn-registrar" onclick="tirarDado()">Tirar Dado</button>
    </div>
</div>

<!-- Panel central: tablero -->
<div class="panel-centro">
    <h1 class="titulo-tablero">
        <span class="titulo-animal">ANIMAL</span> <span class="titulo-draft">DRAFT</span>
    </h1>
    <div class="tablero">
        <img src="{{ asset('imagenes/tablero.jpeg') }}" alt="Tablero" class="img-tablero">
    </div>
</div>

<!-- Panel derecho: tracker y botones -->
<div class="panel-der">
    <div class="ronda" style="text-align:center;">
        <h3>Ronda <span id="numRonda">1</span></h3>
        <p>Turno de: <strong id="jugadorActual" class="parpadeo-jugador"></strong></p>
    </div>

    <div class="tracker">
        <h3>Jugadores y Puntuación</h3>
        <ul id="listaJugadores">
            @foreach ($jugadores as $jugador)
                <li id="jugador_{{ $loop->index }}">
                    {{ $jugador->nombre }} - Puntos: <span class="puntos" data-id="{{ $jugador->id }}">0</span>
                </li>
            @endforeach
        </ul>

        <form id="formTrackeo">
            <label for="animal">Animal:</label>
            <select id="animal" name="animal" required>
                @foreach ($animales as $animal)
                    <option value="{{ $animal }}">{{ $animal }}</option>
                @endforeach
            </select>

            <label for="recinto">Recinto:</label>
            <select id="recinto" name="recinto" required>
                <option value="Selva">Selva</option>
                <option value="Desierto">Desierto</option>
                <option value="Montaña">Montaña</option>
                <option value="Bosque">Bosque</option>
                <option value="Lago">Lago</option>
            </select>

            <button type="button" class="btn-registrar" onclick="registrarMovimiento()">Registrar</button>
        </form>
    </div>

    <div class="turno">
        <form action="{{ route('partidas.finalizar', ['codigoPartida' => $codigoPartida]) }}" method="POST">
            @csrf
            <button type="submit" class="btn-turno">Finalizar Partida</button>
        </form>
        <button class="btn-turno" onclick="siguienteTurno()">Siguiente Turno</button>
    </div>
</div>

<!-- Tabla de registro -->
<div class="panel-registro">
    <h3>Registro de Movimientos</h3>
    <table id="tablaRegistro">
        <thead>
            <tr>
                <th>Jugador</th>
                <th>Animal</th>
                <th>Recinto</th>
                <th>Ronda</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
```

</div>

<script>
const jugadores = @json($jugadores->pluck('nombre'));
let ronda = 1;
let turno = 1;

// Mostrar primer jugador
document.getElementById('jugadorActual').textContent = jugadores[0];
resaltarTurno(turno);

// Registrar movimiento
function registrarMovimiento() {
    const jugador = jugadores[turno - 1];
    const animal = document.getElementById('animal').value;
    const recinto = document.getElementById('recinto').value;
    const tabla = document.querySelector('#tablaRegistro tbody');

    const fila = document.createElement('tr');
    fila.innerHTML = `<td>${jugador}</td><td>${animal}</td><td>${recinto}</td><td>${ronda}</td>`;
    tabla.appendChild(fila);

    // Actualizar puntos (ejemplo +1 por movimiento)
    const puntosElem = document.querySelector(`#listaJugadores li:nth-child(${turno}) .puntos`);
    puntosElem.textContent = parseInt(puntosElem.textContent) + 1;
}

// Cambiar al siguiente jugador
function siguienteTurno() {
    turno++;
    if(turno > jugadores.length) turno = 1;
    document.getElementById('jugadorActual').textContent = jugadores[turno - 1];
    resaltarTurno(turno);
}

// Finalizar ronda
function finalizarRonda() {
    ronda++;
    document.getElementById('numRonda').textContent = ronda;
    turno = 1;
    document.getElementById('jugadorActual').textContent = jugadores[turno - 1];
    resaltarTurno(turno);
}

// Resaltar jugador actual
function resaltarTurno(turnoActual) {
    document.querySelectorAll('#listaJugadores li').forEach(li => li.style.fontWeight = 'normal');
    const liActual = document.querySelector(`#listaJugadores li:nth-child(${turnoActual})`);
    if(liActual) liActual.style.fontWeight = 'bold';
}

// ======== DADO STL CON THREE.JS ========
const contenedor = document.getElementById('visorDado');
const escena = new THREE.Scene();
const camara = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setSize(200, 200);
renderer.setClearColor(0xf8f9fa, 1);
contenedor.appendChild(renderer.domElement);

const ambient = new THREE.AmbientLight(0xffffff, 1);
escena.add(ambient);
const directional = new THREE.DirectionalLight(0xffffff, 1.2);
directional.position.set(5,5,5);
escena.add(directional);

let dado;
const loader = new THREE.STLLoader();
loader.load("{{ url('dado/1 FICHA DADO ANIMALDRAFT PLAYCODE.stl') }}", (geometry) => {
    geometry.computeBoundingBox();
    const center = new THREE.Vector3();
    geometry.boundingBox.getCenter(center);
    geometry.translate(-center.x, -center.y, -center.z);

    const material = new THREE.MeshStandardMaterial({ color: 0xffcc00, metalness: 0.3, roughness: 0.6 });
    dado = new THREE.Mesh(geometry, material);
    dado.scale.set(0.08,0.08,0.08);
    escena.add(dado);

    camara.position.set(0, 0, 100);
    camara.lookAt(0,0,0);
    animar();
}, undefined, (error) => {
    console.error("Error loading STL:", error);
    const geometry = new THREE.BoxGeometry(10, 10, 10);
    const material = new THREE.MeshStandardMaterial({ color: 0xff0000 });
    dado = new THREE.Mesh(geometry, material);
    escena.add(dado);
    camara.position.set(0, 0, 50);
    camara.lookAt(0,0,0);
    animar();
});

function animar() {
    requestAnimationFrame(animar);
    if(dado) dado.rotation.y += 0.02;
    renderer.render(escena, camara);
}

function tirarDado() {
    const valor = Math.floor(Math.random() * 6) + 1;
    document.getElementById('valorDado').textContent = valor;
}
</script>

>>>>>>> a50c4ea (Actualizaciones del proyecto)
@endsection
