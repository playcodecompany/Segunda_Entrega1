document.addEventListener('DOMContentLoaded', () => { 
    const app = document.getElementById('trackeoApp');
    const partidaId = app.dataset.partidaId || app.getAttribute('data-partida-id');
    const jugadores = JSON.parse(app.dataset.jugadores);
    const animales = JSON.parse(app.dataset.animales);
    const numRondaEl = document.getElementById('numRonda');
    const jugadorActualEl = document.getElementById('jugadorActual');
    const tablaRegistroBody = document.querySelector('#tablaRegistro tbody');
    const tablaPuntosBody = document.querySelector('#tablaPuntos tbody');
    const animalSelect = document.getElementById('animal');
    const recintoSelect = document.getElementById('recinto');
    const valorDadoEl = document.getElementById('valorDado');
    const visorDadoEl = document.getElementById('visorDado');

    let totalRondas = jugadores.length === 2 ? 4 : 2;
    let fichasPorRonda = 6;
    let maxColocablesPorRonda = jugadores.length === 2 ? 3 : fichasPorRonda;

    let ronda = 1;
    let turno = 0;
    let resultadoDado = 0;

    jugadores.forEach(j => {
        j.fichas = fichasPorRonda;
        j.colocadosEnRonda = 0;
        j.puntos = 0;
    });

    const parque = {};
    jugadores.forEach(j => parque[j.id] = {});

    const dadoSignificados = {
        1: "La Pradera",
        2: "El Desierto",
        3: "Zona viva",
        4: "Zona muerta",
        5: "Sin animales",
        6: "La Cascabel"
    };

    const capacidad = {
        'bosque': 6,
        'prado': 6,
        'desierto': 12,
        'refugio': 3,
        'trono': 1,
        'isla': 1,
        'río': 12
    };

    function actualizarJugador() {
        jugadorActualEl.textContent = jugadores[turno].nombre;
    }

    function actualizarTablaPuntos() {
        tablaPuntosBody.innerHTML = '';
        jugadores.forEach(j => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${j.nombre}</td><td>${j.puntos}</td><td>${j.fichas}</td>`;
            tablaPuntosBody.appendChild(tr);
        });
    }

    function siguienteTurno() {
        turno++;
        if (turno >= jugadores.length) turno = 0;

        if (jugadores.every(j => j.colocadosEnRonda >= maxColocablesPorRonda)) {
            if (ronda < totalRondas) {
                ronda++;
                numRondaEl.textContent = ronda;
                jugadores.forEach(j => {
                    j.fichas = fichasPorRonda;
                    j.colocadosEnRonda = 0;
                });
                alert(`¡Comienza la ronda ${ronda}!`);
            } else {
                calcularPuntosFinales();
                return;
            }
        }

        resultadoDado = 0;
        valorDadoEl.textContent = '-';
        visorDadoEl.textContent = '-';
        actualizarJugador();
        actualizarTablaPuntos();
    }

    document.getElementById('btnTirarDado').addEventListener('click', () => {
        resultadoDado = Math.floor(Math.random() * 6) + 1;
        valorDadoEl.textContent = resultadoDado;
        visorDadoEl.textContent = dadoSignificados[resultadoDado];
    });

    document.getElementById('btnRegistrar').addEventListener('click', () => {
        const jugador = jugadores[turno];
        const animal = animalSelect.value;
        const recinto = recintoSelect.value;

        if (!animal || !recinto) {
            alert('Selecciona un animal y un recinto.');
            return;
        }

        if (jugador.colocadosEnRonda >= maxColocablesPorRonda || jugador.fichas <= 0) {
            alert(`${jugador.nombre} ya no puede colocar más animales esta ronda.`);
            siguienteTurno();
            return;
        }

        if (!parque[jugador.id][recinto]) parque[jugador.id][recinto] = [];
        if (parque[jugador.id][recinto].length >= capacidad[recinto]) {
            alert(`No puedes colocar más animales en ${recinto}`);
            return;
        }

        parque[jugador.id][recinto].push(animal);
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${jugador.nombre}</td><td>${animal}</td><td>${recinto}</td><td>${ronda}</td>`;
        tablaRegistroBody.appendChild(tr);

        jugador.colocadosEnRonda++;
        jugador.fichas--;

        actualizarPuntosJugador(jugador);
        actualizarTablaPuntos();
        siguienteTurno();
    });

    function actualizarPuntosJugador(jugador) {
        let total = 0;
        for (const r in parque[jugador.id]) {
            const animalesRecinto = parque[jugador.id][r];
            let puntos = 0;
            switch(r) {
                case 'bosque':
                    if (animalesRecinto.every(a => a === animalesRecinto[0])) {
                        const n = animalesRecinto.length;
                        const puntosPorLugar = [2,4,8,12,18,24];
                        puntos = puntosPorLugar[n-1] || 0;
                    }
                    break;
                case 'prado':
                    const distintos = new Set(animalesRecinto);
                    if (distintos.size === animalesRecinto.length) {
                        const puntosPorLugar = [1,3,6,10,15,21];
                        puntos = puntosPorLugar[animalesRecinto.length-1] || 0;
                    }
                    break;
                case 'desierto':
                    const counts = {};
                    animalesRecinto.forEach(a => counts[a] = (counts[a]||0)+1);
                    for (const c in counts) puntos += Math.floor(counts[c]/2)*5;
                    break;
                case 'refugio':
                    if (animalesRecinto.length === 3) puntos = 7;
                    break;
                case 'trono':
                    animalesRecinto.forEach(a => {
                        const maxOtros = Math.max(...jugadores.filter(j2=>j2.id!==jugador.id).map(j2=>(parque[j2.id][r]||[]).filter(x=>x===a).length));
                        if (animalesRecinto.filter(x=>x===a).length >= maxOtros) puntos = 7;
                    });
                    break;
                case 'isla':
                    if (animalesRecinto.length === 1) {
                        const especie = animalesRecinto[0];
                        const totalEspecie = Object.values(parque[jugador.id]).flat().filter(x=>x===especie).length;
                        puntos = totalEspecie === 1 ? 7 : 0;
                    }
                    break;
                case 'rio':
                    puntos = animalesRecinto.length;
                    break;
            }
            total += puntos;
        }
        jugador.puntos = total;
    }

    function calcularPuntosFinales() {
    jugadores.forEach(j => actualizarPuntosJugador(j));
    actualizarTablaPuntos();

    fetch(`/partidas/${partidaId}/finalizar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            resultados: jugadores.map(j => ({
                jugador_id: j.id,
                puntos: j.puntos
            }))
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Puntos guardados:', data);
        window.location.href = `/partidas/${partidaId}/resumen`;
    })
    .catch(err => console.error('Error al guardar puntos:', err));
}


document.getElementById('btnFinalizar').addEventListener('click', () => {
    calcularPuntosFinales(); 
});



    actualizarJugador();
    actualizarTablaPuntos();
});
