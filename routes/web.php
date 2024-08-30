<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{search?}', [ProductController::class, 'index'])->name('products_list');

Route::get('/contact', [ContactController::class, 'home'])->name('contact');

Route::post('/sendMail', [ContactController::class, 'send'])->name('send');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/add_newsletter', [UserController::class, 'addNewsLetter'])->name('addNewsLetter');


// Only connect user
Route::middleware(['auth'])->group(function () {

    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    Route::get('/updateProfils', [UserController::class, 'edit'])->name('updateProfils');
    
    Route::post('/profilUpdated', [UserController::class, 'update']);
    
    Route::get('/profils', [UserController::class, 'index'])->name('profils');

    Route::get('/products_list', [ProductController::class, 'list'])->name('products_list_admin');

    Route::delete('/delete_product/{id}', [ProductController::class, 'destroy'])->name('delete_product');

    // Create a new product form
    Route::get('/create_product', [ProductController::class, 'create'])->name('create_product');

    // Create a new product backend
    Route::post('/new_product', [ProductController::class, 'store'])->name('store_product');    

    // Edit a product form
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('edit');
  
    // Edit a product backend
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update');

});

