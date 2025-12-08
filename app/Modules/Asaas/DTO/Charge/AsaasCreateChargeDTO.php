<?php

namespace App\Modules\Asaas\DTO\Charge;

class AsaasCreateChargeDTO
{
    public function __construct(
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

    public static function fromRequest($data): self
    {
        return new self(
            customer: $data['customer'],
            billingType: $data['billingType'],
            value: $data['value'],
            dueDate: $data['dueDate'],
            externalReference: $data['externalReference'],
            description: $data['description'] ?? null,
            installmentCount: $data['installmentCount'] ?? null,
            totalValue: $data['totalValue'] ?? null,
            installmentValue: $data['installmentValue'] ?? null,
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
