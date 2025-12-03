<?php

namespace App\Modules\Asaas\DTO\Client;

class AsaasCreateClientDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $cpfCnpj,
        public readonly ?string $email,
        public readonly ?string $mobilePhone,
        public readonly ?string $address,
        public readonly ?string $addressNumber,
        public readonly ?string $postalCode,
        public readonly ?string $company,
        public readonly ?string $complement,
        public readonly ?string $province,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            cpfCnpj: $data['cpfCnpj'],
            email: $data['email'] ?? null,
            mobilePhone: $data['mobilePhone'] ?? null,
            address: $data['address'] ?? null,
            addressNumber: $data['addressNumber'] ?? null,
            postalCode: $data['postalCode'] ?? null,
            company: $data['company'] ?? null,
            complement: $data['complement'] ?? null,
            province: $data['province'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'cpfCnpj' => $this->cpfCnpj,
            'email' => $this->email,
            'mobilePhone' => $this->mobilePhone,
            'address' => $this->address,
            'addressNumber' => $this->addressNumber,
            'postalCode' => $this->postalCode,
            'company' => $this->company,
            'complement' => $this->complement,
            'province' => $this->province,
        ];
    }
}
