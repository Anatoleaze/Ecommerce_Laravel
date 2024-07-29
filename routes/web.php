<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home2', [App\Http\Controllers\HomeController::class, 'home'])->name('home2');

Route::get('/products/{search?}', [App\Http\Controllers\ProductController::class, 'index'])->name('products_list');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'home'])->name('contact');

Route::post('/sendMail', [App\Http\Controllers\ContactController::class, 'send'])->name('send');

