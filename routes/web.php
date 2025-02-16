<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;

use App\Models\FraisLivraison;

Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{search?}', [ProductController::class, 'index'])->name('products_list');

Route::get('/contact', [ContactController::class, 'home'])->name('contact');

Route::post('/sendMail', [ContactController::class, 'send'])->name('send');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/add_newsletter', [UserController::class, 'addNewsLetter'])->name('addNewsLetter');

// Get Country of database
Route::get('/pays', function () {
    return response()->json(FraisLivraison::pluck('pays'));
});

// Get Frais de livrais by pays selected
Route::get('/frais-livraison/{pays}', function ($pays) {
    $fraisLivraison = FraisLivraison::where('pays', $pays)->first();

    if ($fraisLivraison) {
        return response()->json([
            'frais' => $fraisLivraison->frais
        ]);
    }

    return response()->json(['frais' => 0], 404);
});

// Only connect user
Route::middleware(['auth'])->group(function () {

    

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
    Route::get('/product/{id}', [ProductController::class, 'edit'])->name('edit');
  
    // Edit a product backend
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('update');

    Route::get('/order',[OrderController::class, 'index'])->name('order');

    // Add to cart (basket)
    Route::post('/cart/store',[CartController::class, 'store'])->name('store');

    // Remove from cart (basket)
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);

    // Count products in cart (basket)
    Route::get('/cart/count', [CartController::class, 'getCartCount']);

    // Get cart of user
    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    // Show cart of user
    Route::get('/cart/show', [CartController::class, 'show'])->name('cart_show');

    // Update quantity of product in cart (basket)
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart_update');

    Route::post('/check-promo', [PromoController::class, 'checkPromo']);


});

