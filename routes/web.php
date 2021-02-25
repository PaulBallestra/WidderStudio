<?php

use Illuminate\Support\Facades\Route;

//Racine
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/reservation', [App\Http\Controllers\ReservationController::class, 'show'])->name('reservation');

Route::post('/reservation', [App\Http\Controllers\ReservationController::class, 'send'])->name('reservation.send');
