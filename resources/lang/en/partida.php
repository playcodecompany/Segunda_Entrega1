<?php

return [

    // Create game
    'title_create' => 'Create Game',
    'heading_create' => 'CREATE GAME',
    'name_label' => 'Game name:',
    'players_label' => 'Total number of players (2-5):',
    'create_button' => 'CREATE',
    'player_id_label' => 'Player ID',


    // Game tracking
    'title_track' => 'Game Tracking',
    'heading_track' => 'GAME TRACKING',

    // Left panel - rules
    'rules_title' => 'Enclosure Rules',
    'rules' => [
        'bosque' => 'The Uniform Forest: Only animals of the same species. Fill left to right. Points: 2, 4, 8, 12, 18, 24.',
        'prado' => 'The Diverse Meadow: Only different animals. Fill left to right. Points: 1, 3, 6, 10, 15, 21.',
        'desierto' => 'The Desert of Love: Each matching pair earns 5 points. Unpaired animals score nothing.',
        'refugio' => 'The Trio Shelter: Up to 3 animals. Exactly 3 animals give 7 points.',
        'trono' => 'The Animal Throne: Only 1 animal. The player with the most of that species gets 7 points. Ties share points.',
        'isla' => 'The Unique Island: Only 1 animal. 7 points if it’s the only one of its species.',
        'rio' => 'The River: Each animal placed gives 1 point.',
    ],
    'rules_mode_title' => '2-Player Mode',
    'rules_mode' => [
        'r1' => 'Played in 4 rounds instead of 2.',
        'r2' => '2 animals of each species are removed before starting.',
        'r3' => 'Each player draws 6 random animals per round.',
        'r4' => 'Only 3 animals can be placed per round.',
        'r5' => 'After placement, 1 animal is returned to the box.',
        'r6' => 'Players exchange the remaining animals.',
        'r7' => 'At the end of round 4, each player will have 12 animals.',
    ],

    // Dice
    'dice_result' => 'Result:',
    'dice_button' => 'Roll Dice',

    // Right panel
    'round' => 'Round',
    'turn_of' => 'Turn of:',
    'tracking' => 'Tracking',
    'animal_label' => 'Animal:',
    'enclosure_label' => 'Enclosure:',
    'register_button' => 'Register Move',
    'finish_button' => 'Finish Game',

    // Animals
    'animales' => [
        'tortuga'   => 'Turtle',
        'camello'   => 'Camel',
        'caracol'   => 'Snail',
        'serpiente' => 'Snake',
        'conejo'    => 'Rabbit',
        'raton'     => 'Mouse',
        // add more if needed...
    ],

    // Enclosures (display names)
    'recintos' => [
        'bosque'   => 'Uniform Forest',
        'prado'    => 'Diverse Meadow',
        'isla'     => 'Unique Island',
        'desierto' => 'Desert of Love',
        'refugio'  => 'Trio Shelter',
        'trono'    => 'Animal Throne',
        'rio'      => 'The River',
    ],

    // Tables
    'movements_title' => 'Move Log',
    'table_player'     => 'Player',
    'table_animal'     => 'Animal',
    'table_enclosure'  => 'Enclosure',
    'table_round'      => 'Round',

    'score_title'  => 'Scoreboard',
    'table_points' => 'Points',
    'table_tokens' => 'Tokens',
];
