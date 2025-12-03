<?php

namespace App\Modules\Asaas\DTO\Pix;

class AsaasCreatePixDTO
{
    public function __construct(
        public readonly string $addressKey,
        public readonly float $value,
        public readonly string $format,
        public readonly string $externalReference,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            format: $data['format'],
            addressKey: $data['addressKey'],
            value: $data['value'],
            externalReference: $data['externalReference']
        );
    }

    public function toArray(): array
    {
        return [
            'format' => $this->format,
            'addressKey' => $this->addressKey,
            'value' => $this->value,
            'externalReference' => $this->externalReference,
        ];
    }
}
