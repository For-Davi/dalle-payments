<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require base_path('app/Modules/Asaas/routes/asaas.php');

Route::prefix('mp')->group(function () {
    Route::post('/payment', function (Request $request) {
        return response()->json(['message' => 'Pagamento ativo']);
    })->middleware('verify.payment');
});
