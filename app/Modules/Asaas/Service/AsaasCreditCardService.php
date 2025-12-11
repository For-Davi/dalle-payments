<?php

namespace App\Modules\Asaas\Service;

use App\Modules\Asaas\DTO\Charge\AsaasCreateChargeDTO;
use App\Modules\Asaas\DTO\CreditCard\AsaasCreateCreditCardDTO;
use App\Modules\Asaas\Http\AsaasHttpClient;
use App\Utils\ErrorAsaasData;

class AsaasCreditCardService
{
    public function __construct(
        protected AsaasClientService $clientService,
        protected AsaasHttpClient $http,
    ) {}

    public function create(array $request)
    {
        $cpfCnpj = $request['creditCardHolderInfo']['cpfCnpj'];

        $customers = $this->http->get('/customers');
        ErrorAsaasData::hasError($customers, 'Erro ao buscar cliente');

        $customerID = $this->existsClient($customers['data'], $cpfCnpj)
            ?: $this->createNewClient($request)['id'];

        $charge = $this->createCreditCardCharge($customerID, $request);
        $payment = $this->payCreditCardCharge($charge['id'], $request);

        return $this->isItPaid($payment['id']);
    }

    private function createNewClient(array $request)
    {
        $info = $request['creditCardHolderInfo'];

        return $this->clientService->create([
            'name' => $info['name'],
            'cpfCnpj' => $info['cpfCnpj'],
            'email' => $info['email'],
            'mobilePhone' => $info['phone'],
        ]);
    }

    private function createCreditCardCharge(string $customerID, array $data)
    {
        $chargeDTO = AsaasCreateChargeDTO::fromData($data, $customerID);

        $response = $this->http->post('/payments', $chargeDTO->toArray());
        ErrorAsaasData::hasError($response, 'Erro ao criar cobrança');

        return $response;
    }

    private function payCreditCardCharge(string $chargeID, array $data)
    {
        $paymentDTO = AsaasCreateCreditCardDTO::fromRequest($data);

        $response = $this->http->post(
            "/payments/{$chargeID}/payWithCreditCard",
            $paymentDTO->toArray()
        );

        ErrorAsaasData::hasError($response, 'Erro ao pagar cobrança');

        return $response;
    }

    private function existsClient(array $clients, string $cpfCnpj): ?string
    {
        foreach ($clients as $customer) {
            if (($customer['cpfCnpj'] ?? null) === $cpfCnpj) {
                return $customer['id'];
            }
        }

        return null;
    }

    private function isItPaid(string $paymentID): bool
    {
        $response = $this->http->get("/payments/{$paymentID}");
        ErrorAsaasData::hasError($response, 'Erro ao buscar pagamento');

        return $response['status'] === 'CONFIRMED';
    }
}
