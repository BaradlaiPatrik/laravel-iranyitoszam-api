<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use Illuminate\Support\Facades\Route;

// Nyilvános végpontok
Route::post('/login', [AuthController::class, 'login']);

Route::get('/counties', [CountyController::class, 'index']);
Route::get('/counties/{id}', [CountyController::class, 'show']);

Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}', [CityController::class, 'show']);

// Tokenhez kötött (védett) végpontok
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/counties', [CountyController::class, 'store']);
    Route::put('/counties/{id}', [CountyController::class, 'update']);
    Route::delete('/counties/{id}', [CountyController::class, 'destroy']);

    Route::post('/cities', [CityController::class, 'store']);
    Route::put('/cities/{id}', [CityController::class, 'update']);
    Route::delete('/cities/{id}', [CityController::class, 'destroy']);
});