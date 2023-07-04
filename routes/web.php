<?php

use Illuminate\Support\Facades\Route;

// Home

Route::get('/', function () {
    return inertia('Test');
})->name('home');

// Services

Route::get('/services', function (){
    return inertia('Service');
})->name('service');

// Purchase Orders

