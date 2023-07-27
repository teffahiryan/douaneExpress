<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;

// Home

Route::get('/', function () {
    return inertia('Home');
})->name('home');

// Services

Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
Route::post('/service', [ServiceController::class, 'store'])->name('service.create');
Route::put('/service/{service}', [ServiceController::class, 'update'])->name('service.update');
Route::delete('/service/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');

// Groups

Route::get('/groups', [GroupController::class, 'index'])->name('group.index');
Route::post('/group', [GroupController::class, 'store'])->name('group.create');
Route::put('/group/{group}', [GroupController::class, 'update'])->name('group.update');
Route::delete('/group/{group}', [GroupController::class, 'destroy'])->name('group.destroy');

// Purchase Orders

Route::get('/bons-de-commandes', [OrderController::class, 'index'])->name('order.index');
Route::post('/bons-de-commande', [OrderController::class, 'store'])->name('order.create');
Route::put('/bons-de-commande/{order}', [OrderController::class, 'update'])->name('order.update');
Route::delete('/bons-de-commande/{order}', [OrderController::class, 'destroy'])->name('order.destroy');

// Total Price

Route::get('/panier/total', [OrderController::class, 'totalPrice']);