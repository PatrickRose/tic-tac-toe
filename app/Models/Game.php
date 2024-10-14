<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public static function initialise(int $id):Game
    {
        $game = new Game;
        $game->player_1_id = $id;
        $game->moves = [];

        $game->saveOrFail();

        return $game;
    }

    public function player1()
    {
        return $this->belongsTo(User::class, 'player_1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player_2_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'moves' => 'json',
        ];
    }
}
