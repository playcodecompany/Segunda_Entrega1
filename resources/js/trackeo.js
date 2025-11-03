document.addEventListener('DOMContentLoaded', () => {
const app = document.getElementById('trackeoApp');
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


let totalRondas = 2;  
let fichasPorRonda = 6;  
let maxColocablesPorRonda = fichasPorRonda;  

if (jugadores.length === 2) {  
    totalRondas = 4;  
    maxColocablesPorRonda = 3;  
}  

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

// Palabras que muestra el dado, solo visual  
const dadoSignificados = {  
    1: "La Pradera",  
    2: "El Desierto",  
    3: "Zona viva",  
    4: "Zona muerta",  
    5: "Sin animales",  
    6: "La Cascabel"  
};  

const capacidad = {  
    'El Bosque Uniforme': 6,  
    'El Prado Variado': 6,  
    'El Desierto del Amor': 12,  
    'El Refugio Trío': 3,  
    'El Trono del Animal': 1,  
    'La Isla Única': 1,  
    'El Río': 12  
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

// Dado solo visual  
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
            case 'El Bosque Uniforme':  
                if (animalesRecinto.every(a => a === animalesRecinto[0])) {  
                    const n = animalesRecinto.length;  
                    const puntosPorLugar = [2,4,8,12,18,24];  
                    puntos = puntosPorLugar[n-1] || 0;  
                }  
                break;  
            case 'El Prado Variado':  
                const distintos = new Set(animalesRecinto);  
                if (distintos.size === animalesRecinto.length) {  
                    const puntosPorLugar = [1,3,6,10,15,21];  
                    puntos = puntosPorLugar[animalesRecinto.length-1] || 0;  
                }  
                break;  
            case 'El Desierto del Amor':  
                const counts = {};  
                animalesRecinto.forEach(a => counts[a] = (counts[a]||0)+1);  
                for (const c in counts) puntos += Math.floor(counts[c]/2)*5;  
                break;  
            case 'El Refugio Trío':  
                if (animalesRecinto.length === 3) puntos = 7;  
                break;  
            case 'El Trono del Animal':  
                animalesRecinto.forEach(a => {  
                    const maxOtros = Math.max(...jugadores.filter(j2=>j2.id!==jugador.id).map(j2=>(parque[j2.id][r]||[]).filter(x=>x===a).length));  
                    if (animalesRecinto.filter(x=>x===a).length >= maxOtros) puntos = 7;  
                });  
                break;  
            case 'La Isla Única':  
                if (animalesRecinto.length === 1) {  
                    const especie = animalesRecinto[0];  
                    const totalEspecie = Object.values(parque[jugador.id]).flat().filter(x=>x===especie).length;  
                    puntos = totalEspecie === 1 ? 7 : 0;  
                }  
                break;  
            case 'El Río':  
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

    const maxPuntos = Math.max(...jugadores.map(j=>j.puntos));  
    const ganadores = jugadores.filter(j=>j.puntos===maxPuntos);  
    if (ganadores.length === 1) {  
        alert(`¡Ganador: ${ganadores[0].nombre} con ${ganadores[0].puntos} puntos!`);  
    } else {  
        alert(`¡Empate entre: ${ganadores.map(j=>j.nombre).join(', ')}!`);  
    }  
}  

actualizarJugador();  
actualizarTablaPuntos();  


});
