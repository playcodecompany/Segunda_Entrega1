// public/js/crear-partida.js

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
document.addEventListener('DOMContentLoaded', generarCamposJugadores);

// También escuchar cambios en la cantidad de jugadores
document.addEventListener('DOMContentLoaded', () => {
    const numJugadoresInput = document.getElementById('num_jugadores');
    if (numJugadoresInput) {
        numJugadoresInput.addEventListener('change', generarCamposJugadores);
    }
});
