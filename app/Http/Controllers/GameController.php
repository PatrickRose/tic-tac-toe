<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameMoveRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class GameController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Game::initialise($request->user()->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $game)
    {
        $game = Game::with('player1', 'player2')
            ->findOrFail($game);

        Gate::authorize('view', $game);

        return Inertia::render('Game', ['game' => $game]);
    }

    public function join(Game $game, Request $request)
    {
        $id = $request->user()->id;

        if ($game->player_1_id == $id) {
            return redirect()->back()->withErrors( ['game' => 'You are already in that game!']);
        }

        if ($game->player_2_id) {
            return redirect()->back()->withErrors( ['game' => 'You are already in that game!']);
        }

        $game->player_2_id = $id;

        $game->save();

        return redirect()->route('game.show', ['game' => $game]);
    }

    public function move(Game $game, GameMoveRequest $request)
    {
        $moves = $game->moves;
        $moves[] = $request->move;

        $game->moves = $moves;

        $game->save();

        $game->load('player1', 'player2');

        return $game;
    }
}
