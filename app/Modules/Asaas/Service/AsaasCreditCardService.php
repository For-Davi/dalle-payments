<?php

namespace App\Modules\Asaas\Service;
use App\Modules\Asaas\Service\AsaasClientService;
use App\Modules\Asaas\DTO\Charge\AsaasCreateChargeDTO;
use App\Modules\Asaas\DTO\CreditCard\AsaasCreateCreditCardDTO;
use App\Modules\Asaas\Repositories\AsaasDalleManageRepository;
use App\Modules\Asaas\Http\AsaasHttpClient;
use Illuminate\Support\Facades\Http;
use App\Utils\ErrorAsaasData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;

class AsaasCreditCardService   
{

    public function __construct(
    protected AsaasClientService $clientService, 
    protected AsaasHttpClient $http, 
    protected AsaasDalleManageRepository $dalleManageRepository
    ){}

    public function create($request)
    {
     $cpfCnpj = $request['creditCardHolderInfo']['cpfCnpj'];
    $response = $this->http->get("/customers");

    ErrorAsaasData::hasError($response, 'Erro ao buscar cliente');

    $customerID = null;
    $existingCustomerID = $this->existsClient($response['data'], $cpfCnpj);

    if ($existingCustomerID) {
    $customerID = $existingCustomerID;
} else {
    $clientData = [
        'name'    => $request['creditCardHolderInfo']['name'],
        'cpfCnpj' => $request['creditCardHolderInfo']['cpfCnpj'],
        'email'   => $request['creditCardHolderInfo']['email'],
        'mobilePhone' => $request['creditCardHolderInfo']['phone'],
    ];
    $newCustomer = $this->clientService->create($clientData);
    $customerID = $newCustomer['id'];
}

    $charge = $this->createCreditCardCharge($customerID, $request);

    $chargeID = $charge['id'];

    $payment = $this->payCreditCardCharge($chargeID, $request);

    return $this->isItPaid($payment['id']);
    }

    //Cria cobrança de cartão de crédito
    private function createCreditCardCharge(string $customerID, $paymentData)
    {
    $chargeDTO = AsaasCreateChargeDTO::fromRequest([
        'customer' => $customerID,
        'billingType' => 'CREDIT_CARD',
        'value' => $paymentData->value,
        'dueDate' => Carbon::now()->addHours(24)->toDateString(),
        'externalReference' => "{$paymentData->identifier}|user_{$paymentData->userID}",
        'description' => $paymentData->description,
        'installmentCount' => $paymentData->installmentCount,
        'totalValue' => $paymentData->totalValue,
        'installmentValue' => $paymentData->installmentValue,
    ]);

    $response = $this->http->post('/payments', $chargeDTO->toArray());

    ErrorAsaasData::hasError($response, 'Erro ao criar cobrança');

    return $response;
    }

    //Efetua o pagamento da cobrança de cartão de crédito
    private function payCreditCardCharge(string $chargeID, $creditCardData)
    {
        $paymentDTO = AsaasCreateCreditCardDTO::fromRequest($creditCardData);

        $response = $this->http->post("/payments/{$chargeID}/payWithCreditCard", $paymentDTO->toArray());

        ErrorAsaasData::hasError($response, 'Erro ao pagar cobrança');

        return $response;
    }

    private function existsClient(array $clients, string $cpfCnpj)
{
    foreach ($clients as $customer) {
        if (isset($customer['cpfCnpj']) && $customer['cpfCnpj'] === $cpfCnpj) {
            return $customer['id'];
        }
    }

    return false;
}
    private function isItPaid(string $paymentID)
    {
        $response = $this->http->get("/payments/{$paymentID}");

        ErrorAsaasData::hasError($response, 'Erro ao buscar pagamento');

        if($response['status'] === 'CONFIRMED'){
            return true;
        } else {
            return false;
        }
    }

}   