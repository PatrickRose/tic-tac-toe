<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Models\Game;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $games = Game::with('player1', 'player2')->forUser(Auth::user()->id)->get();

    return Inertia::render('Dashboard', ['games' => $games]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('game')->group(function () {
    Route::post('/', [GameController::class, 'store'])->name('game.create');
    Route::get('/{game}', [GameController::class, 'show'])->name('game.show');
    Route::get('/{game}/get', [GameController::class, 'getGame'])->name('game.get');
    Route::get('/{game}/join', [GameController::class, 'join'])->name('game.join');
    Route::post('/{game}/move', [GameController::class, 'move'])->name('game.move');
});

require __DIR__.'/auth.php';
