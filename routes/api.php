<?php
require __DIR__ . '/mercado-pago.php';
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

Route::prefix('mp')->group(function () {
    Route::post('/payment', function (Request $request){
        return response()->json(['message' => 'Pagamento ativo']);
    })->middleware('verify.payment');
});
