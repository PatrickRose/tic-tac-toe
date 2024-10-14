<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Game $game): bool
    {
        return in_array($user->id, [$game->player_1_id, $game->player_2_id]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): bool
    {
        return $game->currentTurn() == $user->id;
    }
}
