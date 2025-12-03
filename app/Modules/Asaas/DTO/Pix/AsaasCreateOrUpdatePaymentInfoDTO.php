<?php

namespace App\Modules\Asaas\DTO\Pix;

class AsaasCreateOrUpdatePaymentInfoDTO
{
    public function __construct(
        public readonly string $payment_id,
        public readonly int $user_id,
        public readonly int $subscription_id,
        public readonly int $month_quantity,
        public readonly string $identifier,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            payment_id: $data['paymentID'],
            user_id: $data['userID'],
            subscription_id: $data['subscriptionID'],
            month_quantity: $data['monthQuantity'],
            identifier: $data['identifier'],
        );
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'user_id' => $this->user_id,
            'subscription_id' => $this->subscription_id,
            'month_quantity' => $this->month_quantity,
            'identifier' => $this->identifier,
        ];
    }
}
