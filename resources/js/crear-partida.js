document.addEventListener('DOMContentLoaded', () => {
    const numJugadoresInput = document.getElementById('num_jugadores');
    const contenedor = document.getElementById('campos-jugadores');

    function generarCamposJugadores() {
        const numJugadores = parseInt(numJugadoresInput.value);
        contenedor.innerHTML = '';

        // El jugador 1 es el creador, por eso empezamos en 2
        for (let i = 2; i <= numJugadores; i++) {
            const div = document.createElement('div');
            div.innerHTML = `
                <label for="jugador_${i}">ID  ${i}:</label>
                <input type="number" id="jugador_${i}" name="jugadores[]" min="1" required>
            `;
            contenedor.appendChild(div);
        }
    }

    // Inicializar campos al cargar la página
    generarCamposJugadores();

    // Escuchar cambios en el número de jugadores
    numJugadoresInput.addEventListener('change', generarCamposJugadores);
});
