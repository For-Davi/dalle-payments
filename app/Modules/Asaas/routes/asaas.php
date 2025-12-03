<?php

use App\Modules\Asaas\Http\Controllers\AsaasClientController;
use App\Modules\Asaas\Http\Controllers\AsaasController;
use App\Modules\Asaas\Http\Controllers\AsaasCreditCardController;
use App\Modules\Asaas\Http\Controllers\AsaasPixController;
use Illuminate\Support\Facades\Route;

Route::middleware(['check.asaas.access.token'])->group(function () {
    Route::post('/asaas-webhook', [AsaasController::class, 'webhook']);
});

Route::middleware(['check.access.token'])->prefix('asaas')->group(function () {
    Route::prefix('payment')->group(function () {
        Route::prefix('pix')->group(function () {
            Route::post('/', [AsaasPixController::class, 'create']);
            Route::post('delete-register/{userID}', [AsaasPixController::class, 'destroy']);
        });
        Route::prefix('credit-card')->group(function () {
            Route::post('/', [AsaasCreditCardController::class, 'create']);
        });
    });
    Route::prefix('client')->group(function () {
        Route::post('/', [AsaasClientController::class, 'store']);
    });
});
