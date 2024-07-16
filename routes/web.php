<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home2', [App\Http\Controllers\HomeController::class, 'home'])->name('home2');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('product');