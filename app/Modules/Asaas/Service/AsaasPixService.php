<?php

namespace App\Modules\Asaas\Service;

use App\Modules\Asaas\DTO\Pix\AsaasCreateOrUpdatePaymentInfoDTO;
use App\Modules\Asaas\DTO\Pix\AsaasCreatePixDTO;
use App\Modules\Asaas\Http\AsaasHttpClient;
use App\Modules\Asaas\Repositories\AsaasPaymentInfoRepository;
use App\Utils\ErrorAsaasData;

class AsaasPixService
{
    public function __construct(protected AsaasHttpClient $http, protected AsaasPaymentInfoRepository $paymentInfoRepository)
    {
        $this->addressKey = config('asaas.address_key');
        $this->http = $http;
    }

    public function create($request)
    {
        $pixDTO = AsaasCreatePixDTO::fromRequest([
            'format' => 'ALL',
            'addressKey' => $this->addressKey,
            'value' => $request->value,
            'externalReference' => "{$request->identifier}|user_{$request->userID}|subscription_{$request->subscriptionID}|month_qnty_{$request->monthQuantity}",
        ]);

        $response = $this->http->post('/pix/qrCodes/static', $pixDTO->toArray());

        ErrorAsaasData::hasError($response, 'Erro ao criar PIX');

        if ($this->existsPixTransaction($request)) {
            $this->updateTransaction($response);
        } else {
            $this->saveTransaction($response);
        }

        return $response;
    }

    private function existsPixTransaction($request)
    {
        return $this->paymentInfoRepository->findByUserId($request->userID);
    }

    private function updateTransaction($paymentData)
    {
        $parts = explode('|', $paymentData['externalReference']);
        $projectName = $parts[0];
        $userPart = $parts[1];
        $subscriptionPart = $parts[2];
        $monthQuantityPart = $parts[3];

        $userID = (int) str_replace('user_', '', $userPart);
        $subscriptionID = (int) str_replace('subscription_', '', $subscriptionPart);
        $monthQuantity = (int) str_replace('month_qnty_', '', $monthQuantityPart);

        $paymentInfoDTO = AsaasCreateOrUpdatePaymentInfoDTO::fromRequest([
            'paymentID' => $paymentData['id'],
            'userID' => $userID,
            'subscriptionID' => $subscriptionID,
            'monthQuantity' => $monthQuantity,
            'identifier' => $projectName,
        ]);

        return $this->paymentInfoRepository->update($userID, $paymentInfoDTO->toArray());
    }

    private function saveTransaction($paymentData)
    {
        $parts = explode('|', $paymentData['externalReference']);
        $projectName = $parts[0];
        $userPart = $parts[1];
        $subscriptionPart = $parts[2];
        $monthQuantityPart = $parts[3];

        $userID = (int) str_replace('user_', '', $userPart);
        $subscriptionID = (int) str_replace('subscription_', '', $subscriptionPart);
        $monthQuantity = (int) str_replace('month_qnty_', '', $monthQuantityPart);

        $paymentInfoDTO = AsaasCreateOrUpdatePaymentInfoDTO::fromRequest([
            'paymentID' => $paymentData['id'],
            'userID' => $userID,
            'subscriptionID' => $subscriptionID,
            'monthQuantity' => $monthQuantity,
            'identifier' => $projectName,
        ]);

        return $this->paymentInfoRepository->create($paymentInfoDTO->toArray());
    }
}
