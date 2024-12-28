<?php

use Illuminate\Support\Facades\Route;

Route::post('/tournaments', 'App\Http\Controllers\Tournaments\CreateTournamentController@handle');
Route::get('/tournaments', 'App\Http\Controllers\Tournaments\ListTournamentController@handle');
Route::put('/tournaments/{id}', 'App\Http\Controllers\Tournaments\UpdateTournamentController@handle');
Route::get('/tournaments/{id}', 'App\Http\Controllers\Tournaments\FindTournamentController@handle');
Route::post('/tournaments/{tournamentId}/play-phase', 'App\Http\Controllers\Tournaments\PlayPhaseController@handle');
Route::post('/tournaments/generate', 'App\Http\Controllers\Tournaments\GenerateTournamentController@handle');
