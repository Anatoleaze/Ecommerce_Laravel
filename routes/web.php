<?php

use Illuminate\Support\Facades\Route;




Auth::routes();


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products/{search?}', [App\Http\Controllers\ProductController::class, 'index'])->name('products_list');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'home'])->name('contact');

Route::post('/sendMail', [App\Http\Controllers\ContactController::class, 'send'])->name('send');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

Route::get('/add_newsletter', [App\Http\Controllers\UserController::class, 'addNewsLetter'])->name('addNewsLetter');

// Only connect user
Route::middleware(['auth'])->group(function () {
    
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

    Route::get('/updateProfils', [App\Http\Controllers\UserController::class, 'edit'])->name('updateProfils');
    
    Route::post('/profilUpdated', [App\Http\Controllers\UserController::class, 'update']);
    
    Route::get('/profils', [App\Http\Controllers\UserController::class, 'index'])->name('profils');
});

