<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KnifeController;
use App\Http\Controllers\CartController;

Route::get('/knives', [KnifeController::class, 'index'])->name('knives.index');

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/knives', [KnifeController::class, 'index'])->name('knives.index');
    Route::resource('knives', KnifeController::class)->except(['index']);
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

