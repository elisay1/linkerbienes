<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\UbicacionController;
use App\Http\Controllers\API\BienController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Rutas para categorías
Route::apiResource('categorias', CategoriaController::class);

// Rutas para ubicaciones
Route::apiResource('ubicaciones', UbicacionController::class);

// Rutas para bienes
Route::apiResource('bienes', BienController::class);
Route::get('bienes/search/filters', [BienController::class, 'search']);