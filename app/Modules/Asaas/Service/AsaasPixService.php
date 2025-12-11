<?php

namespace App\Modules\Asaas\Service;

use App\Modules\Asaas\DTO\Pix\AsaasCreateOrUpdatePaymentInfoDTO;
use App\Modules\Asaas\DTO\Pix\AsaasCreatePixDTO;
use App\Modules\Asaas\Http\AsaasHttpClient;
use App\Modules\Asaas\Repositories\AsaasPaymentInfoRepository;
use App\Utils\ErrorAsaasData;

class AsaasPixService
{
    private string $addressKey;

    public function __construct(
        protected AsaasHttpClient $http,
        protected AsaasPaymentInfoRepository $paymentInfoRepository
    ) {
        $this->addressKey = config('asaas.address_key');
    }

    public function create(object $request): array
    {
        $externalReference = sprintf(
            '%s|user_%s|subscription_%s|month_qnty_%s',
            $request->identifier,
            $request->userID,
            $request->subscriptionID,
            $request->monthQuantity
        );

        $pixDTO = AsaasCreatePixDTO::fromRequest([
            'format' => 'ALL',
            'addressKey' => $this->addressKey,
            'value' => (float) $request->value,
            'externalReference' => $externalReference,
        ]);

        $response = $this->http->post('/pix/qrCodes/static', $pixDTO->toArray());

        ErrorAsaasData::hasError($response, 'Erro ao criar PIX');

        $paymentData = $response;

        if ($this->existsPixTransaction($request->userID)) {
            $this->updateTransaction($paymentData);
        } else {
            $this->saveTransaction($paymentData);
        }

        return $response;
    }

    private function existsPixTransaction(int $userID): bool
    {
        return ! is_null($this->paymentInfoRepository->findByUserId($userID));
    }

    private function parseExternalReference(string $externalReference): array
    {
        $pattern = '/(.*?)\|user_(\d+)\|subscription_(\d+)\|month_qnty_(\d+)/';

        if (preg_match($pattern, $externalReference, $matches)) {

            return [
                'projectName' => $matches[1],
                'userID' => (int) $matches[2],
                'subscriptionID' => (int) $matches[3],
                'monthQuantity' => (int) $matches[4],
            ];
        }

        throw new \InvalidArgumentException("Formato de externalReference inválido: $externalReference");
    }

    private function createPaymentInfoDTO(array $paymentData): AsaasCreateOrUpdatePaymentInfoDTO
    {
        $parsedData = $this->parseExternalReference($paymentData['externalReference']);

        return AsaasCreateOrUpdatePaymentInfoDTO::fromRequest([
            'paymentID' => $paymentData['id'],
            'userID' => $parsedData['userID'],
            'subscriptionID' => $parsedData['subscriptionID'],
            'monthQuantity' => $parsedData['monthQuantity'],
            'identifier' => $parsedData['projectName'],
        ]);
    }

    private function updateTransaction(array $paymentData): mixed
    {
        $paymentInfoDTO = $this->createPaymentInfoDTO($paymentData);
        $userID = $paymentInfoDTO->user_id;

        return $this->paymentInfoRepository->update($userID, $paymentInfoDTO->toArray());
    }

    private function saveTransaction(array $paymentData): mixed
    {
        $paymentInfoDTO = $this->createPaymentInfoDTO($paymentData);

        return $this->paymentInfoRepository->create($paymentInfoDTO->toArray());
    }
}
