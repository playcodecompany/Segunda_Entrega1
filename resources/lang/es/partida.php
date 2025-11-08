<?php

return [

    // Crear partida
    'title_create' => 'Crear Partida',
    'heading_create' => 'CREAR PARTIDA',
    'name_label' => 'Nombre de la partida:',
    'players_label' => 'Cantidad total de jugadores (2-5):',
    'create_button' => 'CREAR',
    'player_id_label' => 'ID Jugador',

    // Trackeo de partida
    'title_track' => 'Trackeo de Partida',
    'heading_track' => 'SEGUIMIENTO DE PARTIDA',

    // Panel izquierdo - reglas
    'rules_title' => 'Reglas de los Recintos',
    'rules' => [
        'bosque' => 'El Bosque Uniforme: Solo animales de la misma especie. Se colocan de izquierda a derecha. Puntos: 2, 4, 8, 12, 18, 24.',
        'prado' => 'El Prado Variado: Solo animales distintos. Se colocan de izquierda a derecha. Puntos: 1, 3, 6, 10, 15, 21.',
        'desierto' => 'El Desierto del Amor: Cada pareja de animales iguales suma 5 puntos. Animales sin pareja no suman.',
        'refugio' => 'El Refugio Trío: Hasta 3 animales. Exactamente 3 animales colocados suman 7 puntos.',
        'trono' => 'El Trono del Animal: Solo 1 animal. Al final gana 7 puntos el jugador que tenga más de esa especie en su tablero. En empate, ambos ganan 7.',
        'isla' => 'La Isla Única: Solo 1 animal. Al final suma 7 puntos si es el único de su especie en tu parque.',
        'rio' => 'El Río: Cada animal colocado suma 1 punto.',
    ],
    'rules_mode_title' => 'Modo de 2 jugadores',
    'rules_mode' => [
        'r1' => 'Se juega en 4 rondas en lugar de 2.',
        'r2' => '2 animales de cada especie se devuelven a la caja antes de comenzar.',
        'r3' => 'Cada jugador toma 6 animales al azar al inicio de cada ronda.',
        'r4' => 'Solo se pueden colocar 3 animales por ronda.',
        'r5' => 'Después de colocar, se devuelve 1 animal a la caja.',
        'r6' => 'Luego se intercambian los restantes.',
        'r7' => 'Al final de la ronda 4, cada jugador tendrá 12 animales.',
    ],

    

    // Dado
    'dice_result' => 'Resultado:',
    'dice_button' => 'Tirar Dado',

    // Panel derecho
    'round' => 'Ronda',
    'turn_of' => 'Turno de:',
    'tracking' => 'Trackeo',
    'animal_label' => 'Animal:',
    'enclosure_label' => 'Recinto:',
    'register_button' => 'Registrar Movimiento',
    'finish_button' => 'Finalizar Partida',

    // Animales
    'animales' => [
        'tortuga'   => 'Tortuga',
        'camello'   => 'Camello',
        'caracol'   => 'Caracol',
        'serpiente' => 'Serpiente',
        'conejo'    => 'Conejo',
        'raton'     => 'Ratón',
        // agregá más animales aquí si necesitás...
    ],

    // Recintos (nombres cortos para mostrar)
    'recintos' => [
        'bosque'   => 'El Bosque Uniforme',
        'prado'    => 'El Prado Variado',
        'isla'     => 'La Isla Única',
        'desierto' => 'El Desierto del Amor',
        'refugio'  => 'El Refugio Trío',
        'trono'    => 'El Trono del Animal',
        'rio'      => 'El Río',
    ],

    // Tablas
    'movements_title' => 'Registro de Movimientos',
    'table_player'     => 'Jugador',
    'table_animal'     => 'Animal',
    'table_enclosure'  => 'Recinto',
    'table_round'      => 'Ronda',

    'score_title'  => 'Puntuación',
    'table_points' => 'Puntos',
    'table_tokens' => 'Fichas',
];
