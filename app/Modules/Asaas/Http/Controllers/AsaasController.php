<?php

namespace App\Modules\Asaas\Http\Controllers;

use App\Modules\Asaas\Service\AsaasWebhookService;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsaasController
{
    public function __construct(protected AsaasWebhookService $service) {}

    public function webhook(Request $request)
    {
        try {
            DB::beginTransaction();

            $status = $this->service->checkWebhook($request);

            if ($status) {
                DB::commit();

                return response()->json([200]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao receber webhook:', $e, $request);

            return response()->json(['message' => 'Erro ao receber webhook'], 500);
        }
    }
}
