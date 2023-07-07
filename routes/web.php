<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;

// Home

Route::get('/', function () {
    return inertia('Home');
})->name('home');

// Services

Route::get('/services', [ServiceController::class, 'index'])->name('service.index');

// Purchase Orders

Route::get('/bons-de-commandes', [OrderController::class, 'index'])->name('order.index');
Route::get('/bons-de-commande/{id}', [OrderController::class, 'show'])->name('order.show');