<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
