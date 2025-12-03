<?php

namespace App\Modules\Asaas\Service;

use App\Modules\Asaas\DTO\Client\AsaasCreateClientDTO;
use App\Modules\Asaas\Http\AsaasHttpClient;
use App\Utils\ErrorAsaasData;

class AsaasClientService
{
    public function __construct(protected AsaasHttpClient $http) {}

    public function create($request)
    {
        $clientDTO = AsaasCreateClientDTO::fromRequest($request);

        $response = $this->http->post('/customers', $clientDTO->toArray());

        ErrorAsaasData::hasError($response, 'Erro ao criar cliente');

        return $response;
    } 
}
