<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;




Auth::routes();

// Index route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// // Use the ProductController for handling product-related routes
Route::middleware(['auth'])->group(function () {

    // Route for creating a new product
    Route::get('create', [ProductController::class, 'create'])->name('product.create');
    
    // Route for creating a new product
    Route::post('store', [ProductController::class, 'store'])->name('product.store');
    
    // Route for displaying a specific product
    Route::get('read/{id}', [ProductController::class, 'read'])->name('product.read');

    // Route for updating an existing product
    Route::get('update/{id}/edit', [ProductController::class, 'edit'])->name('product.update');

    // Route for updating an existing product
    Route::put('update/{id}', [ProductController::class, 'update'])->name('product.update');

    // Route for deleting a product
    Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

});


