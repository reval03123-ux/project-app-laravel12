<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::resource('products', ProductController::class);
Route::get('api/products', [ProductController::class, 'apiData'])->name('products.api');
