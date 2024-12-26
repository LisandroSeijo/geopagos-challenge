<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/create', 'App\Http\Controllers\HomeController@create');


Route::post('/tournaments', 'App\Http\Controllers\Tournaments\CreateTournamentController@handle');
Route::get('/tournaments', 'App\Http\Controllers\Tournaments\ListTournamentController@handle');