<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ImagenesProductoController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/productos/{producto}/imagenes', [ImagenesProductoController::class, 'store']);
Route::delete('/imagenes/{id}', [ImagenesProductoController::class, 'destroy']);

Route::apiResource('productos', ProductoController::class);
Route::apiResource('categorias', CategoriaController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});