<?php

namespace App\Modules\Asaas\Service;

use App\Modules\Asaas\DTO\Webhook\AsaasCreateOrUpdateWebhookDataDTO;
use App\Modules\Asaas\Http\AsaasHttpClient;
use App\Modules\Asaas\Jobs\SendPaymentDataAsaasJob;
use App\Modules\Asaas\Repositories\AsaasDalleManageRepository;
use App\Modules\Asaas\Repositories\AsaasPaymentInfoRepository;
use App\Repositories\UrlProjectRepository;

class AsaasWebhookService
{
    public function __construct(
        protected AsaasHttpClient $http,
        protected AsaasDalleManageRepository $manageRepository,
        protected AsaasPaymentInfoRepository $paymentInfoRepository,
        protected UrlProjectRepository $urlProjectRepository,
    ) {}

    public function checkWebhook(array $request)
    {
        $billing = $request['payment']['billingType'];
        $event = $request['event'];

        if ($billing === 'PIX' && $event === 'PAYMENT_RECEIVED') {
            return $this->handlePixPayment($request);
        }

        if ($billing === 'CREDIT_CARD') {
            return $this->handleCreditCard($request);
        }

        return null;
    }

    private function handleCreditCard(array $request)
    {
        $event = $request['event'];

        if ($event === 'PAYMENT_CREATED') {
            return $this->store($request);
        }

        if ($event === 'PAYMENT_CONFIRMED') {
            return $this->update($request);
        }

        return null;
    }

    private function store(array $request)
    {
        $dto = AsaasCreateOrUpdateWebhookDataDTO::fromRequest($request);

        if ($dto->external_reference === 'dalle_manage') {
            return $this->manageRepository->create($dto->toArray());
        }

        return null;
    }

    private function update(array $request)
    {
        $dto = AsaasCreateOrUpdateWebhookDataDTO::fromRequest($request);

        if ($dto->external_reference !== 'dalle_manage') {
            return null;
        }

        $updated = $this->manageRepository->update($dto->payment_id, $dto->toArray());

        if (! $updated) {
            return null;
        }

        $projectName = $this->getProjectName($request['payment']['externalReference']);
        $project = $this->urlProjectRepository->findByIdentifier($projectName);

        if ($project) {
            SendPaymentDataAsaasJob::dispatch($request, $project->base_url);

            return true;
        }

        return null;
    }

    private function handlePixPayment(array $request)
    {
        $pixId = $request['payment']['pixQrCodeId'];

        if (! $this->paymentInfoRepository->findByPaymentID($pixId)) {
            return null;
        }

        $projectName = $this->getProjectName($request['payment']['externalReference']);
        $project = $this->urlProjectRepository->findByIdentifier($projectName);

        if (! $project) {
            return null;
        }

        $this->store($request);

        $this->paymentInfoRepository->deleteByPaymentId($pixId);

        SendPaymentDataAsaasJob::dispatch($request, $project->base_url);

        return true;
    }

    private function getProjectName(string $externalReference): string
    {
        return explode('|', $externalReference)[0];
    }
}
