<?php

namespace App\Modules\Asaas\DTO\CreditCard;

class AsaasCreateCreditCardDTO
{
    public function __construct(
        public readonly string $holderName,
        public readonly string $number,
        public readonly string $expiryMonth,
        public readonly string $expiryYear,
        public readonly string $ccv,
        public readonly string $name,
        public readonly string $email,
        public readonly string $cpfCnpj,
        public readonly string $postalCode,
        public readonly string $addressNumber,
        public readonly ?string $addressComplement,
        public readonly string $phone,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            holderName: $data['creditCard']['holderName'],
            number: $data['creditCard']['number'],
            expiryMonth: $data['creditCard']['expiryMonth'],
            expiryYear: $data['creditCard']['expiryYear'],
            ccv: $data['creditCard']['ccv'],
            name: $data['creditCardHolderInfo']['name'],
            email: $data['creditCardHolderInfo']['email'],
            cpfCnpj: $data['creditCardHolderInfo']['cpfCnpj'],
            postalCode: $data['creditCardHolderInfo']['postalCode'],
            addressNumber: $data['creditCardHolderInfo']['addressNumber'],
            addressComplement: $data['creditCardHolderInfo']['addressComplement'] ?? null,
            phone: $data['creditCardHolderInfo']['phone'],
        );
    }

    public function toArray(): array
    {
        return [
            'creditCard' => [
                'holderName' => $this->holderName,
                'number' => $this->number,
                'expiryMonth' => $this->expiryMonth,
                'expiryYear' => $this->expiryYear,
                'ccv' => $this->ccv,
            ],
            'creditCardHolderInfo' => [
                'name' => $this->name,
                'email' => $this->email,
                'cpfCnpj' => $this->cpfCnpj,
                'postalCode' => $this->postalCode,
                'addressNumber' => $this->addressNumber,
                'addressComplement' => $this->addressComplement,
                'phone' => $this->phone,
            ],
        ];
    }
}
