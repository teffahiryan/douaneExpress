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
Route::post('/service', [ServiceController::class, 'create'])->name('service.create');
Route::post('/service/{service}', [ServiceController::class, 'update'])->name('service.update');
Route::post('/service/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');

// Purchase Orders

Route::get('/bons-de-commandes', [OrderController::class, 'index'])->name('order.index');
Route::get('/bons-de-commande/{id}', [OrderController::class, 'show'])->name('order.show');
Route::post('/bons-de-commande', [OrderController::class, 'create'])->name('order.create');
Route::post('/bons-de-commande/{order}', [OrderController::class, 'update'])->name('order.update');
Route::post('/bons-de-commande/{order}', [OrderController::class, 'destroy'])->name('order.destroy');