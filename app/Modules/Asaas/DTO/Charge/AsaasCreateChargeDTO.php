<?php

namespace App\Modules\Asaas\DTO\Charge;

use Carbon\Carbon;

class AsaasCreateChargeDTO
{
    private function __construct(
        public readonly string $customer,
        public readonly string $billingType,
        public readonly float $value,
        public readonly string $dueDate,
        public readonly string $externalReference,
        public readonly ?string $description,
        public readonly ?int $installmentCount,
        public readonly ?float $totalValue,
        public readonly ?float $installmentValue,
    ) {}

    public static function fromData($data, string $customerID): self
    {
        return new self(
            customer: $customerID,
            billingType: 'CREDIT_CARD',
            value: $data['value'],
            dueDate: Carbon::now()->addHours(24)->toDateString(),
            externalReference: self::makeExternalReference($data),
            description: $data['description'] ?? null,
            installmentCount: $data['installmentCount'] ?? null,
            totalValue: $data['totalValue'] ?? null,
            installmentValue: $data['installmentValue'] ?? null,
        );
    }

    private static function makeExternalReference($data): string
    {
        return sprintf(
            '%s|user_%s|subscription_%s|month_qnty_%s',
            $data['identifier'],
            $data['userID'],
            $data['subscriptionID'],
            $data['monthQuantity']
        );
    }

    public function toArray(): array
    {
        return [
            'customer' => $this->customer,
            'billingType' => $this->billingType,
            'value' => $this->value,
            'dueDate' => $this->dueDate,
            'externalReference' => $this->externalReference,
            'description' => $this->description,
            'installmentCount' => $this->installmentCount,
            'totalValue' => $this->totalValue,
            'installmentValue' => $this->installmentValue,
        ];
    }
}
