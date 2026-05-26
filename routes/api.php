<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS DE LA API (Sin Token)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| API PROTEGIDA CON SANCTUM (Requiere Token Bearer)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    | VER PRODUCTOS API (Punto 11)
    */
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('permission:ver productos,sanctum');

    /*
    | CONFIRMAR ENTREGA (Punto 12)
    */
    Route::post('/deliveries/{id}/confirm', [DeliveryController::class, 'confirm'])
        ->middleware('permission:confirmar entrega,sanctum');

    /*
    | INTENTO DE CREACIÓN - RUTA PARA DEMOSTRAR EL BLOQUEO (Punto 13)
    */
    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('permission:crear productos,sanctum');
        
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('permission:eliminar productos,sanctum');
});