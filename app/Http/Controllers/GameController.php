<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
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

        return Inertia::render('Game', ['game' => $game]);
    }
}
