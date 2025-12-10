<?php

namespace App\Modules\Asaas\Http\Controllers;

use App\Modules\Asaas\Http\Requests\CreditCard\AsaasCreateChargeCreditCardRequest;
use App\Modules\Asaas\Service\AsaasCreditCardService;
use App\Utils\ErrorLogger;

class AsaasCreditCardController
{
    public function __construct(protected AsaasCreditCardService $service) {}

    public function create(AsaasCreateChargeCreditCardRequest $request)
    {
        try {
            $result = $this->service->create($request);

            return response()->json(['result' => $result], 200);
        } catch (\Exception $e) {
            ErrorLogger::log('Erro ao criar cobrança:', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
