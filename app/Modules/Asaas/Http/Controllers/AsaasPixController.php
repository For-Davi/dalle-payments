<?php

namespace App\Modules\Asaas\Http\Controllers;

use App\Modules\Asaas\Service\PixService;
use App\Modules\Asaas\Http\Requests\Pix\CreateAsaasPixRequest;
use App\Modules\Asaas\Repositories\AsaasPaymentInfoRepository;
use App\Modules\Asaas\Http\Requests\Pix\AsaasDeleteRegisterPixRequest;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsaasPixController
{
    public function __construct(private PixService $service, private AsaasPaymentInfoRepository $paymentInfoRepository) {}

    public function create(CreateAsaasPixRequest $request)
    {
        try {
            $pix = $this->service->create($request);

            return response()->json(['pix' => $pix]);
        } catch (\Exception $e) {
            ErrorLogger::log('Erro ao criar pagamento pix:', $e, $request);

            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destroy(AsaasDeleteRegisterPixRequest $request)
    {
        try {
            DB::beginTransaction();

            $result = $this->paymentInfoRepository->delete($request->route('userID'));

            if($result){
                DB::commit();

                return response()->json(['status' => 'ok'], 200);
            }
        } catch (\Exception $e) {
            ErrorLogger::log('Erro ao deletar registro do pagamento pix:', $e, $request);

            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
