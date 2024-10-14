<?php

namespace App;

enum GameState: string
{
    case DRAW = 'draw';
    case IN_PROGRESS = 'in_progress';
    case PLAYER_1 = 'player_1';
    case PLAYER_2 = 'player_2';
}
