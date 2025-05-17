<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnifeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/knives', [KnifeController::class, 'index']);
Route::get('/knives/{knife}', [KnifeController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/knives', [KnifeController::class, 'store']);
    Route::put('/knives/{knife}', [KnifeController::class, 'update']);
    Route::delete('/knives/{knife}', [KnifeController::class, 'destroy']);
});