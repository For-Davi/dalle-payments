<?php

namespace App\Modules\Asaas\Http\Controllers;

use App\Modules\Asaas\Service\AsaasClientService;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class AsaasClientController
{
    public function __construct(private AsaasClientService $service) {}

    public function store(Request $request)
    {
        try {
            $client = $this->service->create($request);

            return response()->json(['client' => $client]);
        } catch (\Exception $e) {
            ErrorLogger::log('Erro ao criar cliente:', $e, $request);

            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
