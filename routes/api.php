<?php

use App\Http\Controllers\Api\TrashPriceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Price Management API endpoints
    Route::get('/prices', [TrashPriceApiController::class, 'index']);
    Route::get('/prices/{id}', [TrashPriceApiController::class, 'show']);
    Route::get('/price-history', [TrashPriceApiController::class, 'history']);
    Route::get('/price-trend/{id}', [TrashPriceApiController::class, 'trend']);
    Route::get('/prediction/{id}', [TrashPriceApiController::class, 'prediction']);
    Route::get('/statistics', [TrashPriceApiController::class, 'statistics']);

    // Admin only API endpoints
    Route::middleware('role:admin')->group(function () {
        Route::post('/prices', [TrashPriceApiController::class, 'store']);
        Route::put('/prices/{id}', [TrashPriceApiController::class, 'update']);
        Route::delete('/prices/{id}', [TrashPriceApiController::class, 'destroy']);
    });
});
