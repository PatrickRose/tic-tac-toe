<?php

namespace App\Models;

use App\GameState;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $appends = ['game_state'];

    public static function initialise(int $id):Game
    {
        $game = new Game;
        $game->player_1_id = $id;
        $game->moves = [];

        $game->saveOrFail();

        return $game;
    }

    protected function gameState(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->calculateGameState()
        );
    }

    public function player1()
    {
        return $this->belongsTo(User::class, 'player_1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player_2_id');
    }

    public function currentTurn()
    {
        $moves = $this->moves;

        return count($moves) % 2 == 0 ? $this->player_1_id : $this->player_2_id;
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

    private function calculateGameState(): GameState
    {
        if (count($this->moves) > 8) {
            return GameState::DRAW;
        }

        $cases = [
            // Horizontal
            [1,2,3],
            [4,5,6],
            [7,8,9],
            // Vertical
            [1,4,7],
            [2,5,8],
            [3,6,9],
            // Diagonal
            [1,5,9],
            [3,5,7],
        ];

        $board = array_fill(1, 9, '');
        foreach($this->moves as $index => $move) {
            $board[$move] = $index % 2 ? 'x' : 'o';
        }

        foreach($cases as $case) {
            // Build a string out of the cases
            $string = $board[$case[0]] . $board[$case[1]] . $board[$case[2]];

            if (strlen($string) != 3) {
                // If the string length isn't 3, then at least one option isn't set
                continue;
            }

            if ($string == 'xxx') {
                return GameState::PLAYER_1;
            }

            if ($string == 'ooo') {
                return GameState::PLAYER_2;
            }
        }

        return GameState::IN_PROGRESS;
    }
}
