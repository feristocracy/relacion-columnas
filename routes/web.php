<?php

use App\Http\Controllers\JuegoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [JuegoController::class, 'landing']);
Route::post('/iniciar', [JuegoController::class, 'iniciar']);
Route::get('/juego/{jugador}', [JuegoController::class, 'jugar']);
Route::post('/resultado/{jugador}', [JuegoController::class, 'guardarResultado']);
Route::get('/scores', [JuegoController::class, 'scores']);