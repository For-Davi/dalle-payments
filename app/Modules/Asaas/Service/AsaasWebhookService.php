<?php

namespace App\Modules\Asaas\Service;

use App\Modules\Asaas\DTO\Webhook\AsaasCreateOrUpdateWebhookDataDTO;
use App\Modules\Asaas\Jobs\SendEventPixJob;
use App\Modules\Asaas\Http\AsaasHttpClient;
use App\Modules\Asaas\Repositories\AsaasDalleManageRepository;
use App\Modules\Asaas\Repositories\AsaasPaymentInfoRepository;

class AsaasWebhookService
{
    public function __construct(protected AsaasHttpClient $http, protected AsaasDalleManageRepository $manageRepository, protected AsaasPaymentInfoRepository $paymentInfoRepository){}

    public function checkWebhook($request)
    {
        if($request['payment']['billingType'] === 'PIX' && $request['event'] === 'PAYMENT_RECEIVED'){
            $this->checkPaymentPix($request);
        }
        if($request['event'] === 'PAYMENT_CREATED'){
            return $this->store($request);
        } else {
            return $this->update($request);
        }
    }

    private function store($request)
    {
        $parts = explode('|', $request['payment']['externalReference']);
            $projectName = $parts[0];
            $userPart = $parts[1];
            $userId = str_replace('user_', '', $userPart);  

        $webhookDataDTO = AsaasCreateOrUpdateWebhookDataDTO::fromRequest([
        'event_id' => $request['id'],
    'event' => $request['event'],
    'change_date' => $request['dateCreated'],
    'object' => $request['payment']['object'],
    'payment_id' => $request['payment']['id'],
    'payment_date_created' => $request['payment']['dateCreated'],
    'customer_id' => $request['payment']['customer'],
    'checkout_session' => $request['payment']['checkoutSession'] ?? null,
    'payment_link' => $request['payment']['paymentLink'] ?? null,
    'value' => $request['payment']['value'],
    'net_value' => $request['payment']['netValue'],
    'original_value' => $request['payment']['originalValue'] ?? null,
    'description' => $request['payment']['description'] ?? null,
    'billing_type' => $request['payment']['billingType'],
    'confirmed_date' => $request['payment']['confirmedDate'] ?? null,
    'pix_transaction' => $request['payment']['pixTransaction'] ?? null,
    'status' => $request['payment']['status'],
    'due_date' => $request['payment']['dueDate'],
    'original_due_date' => $request['payment']['originalDueDate'],
    'settlement_date' => $request['payment']['paymentDate'] ?? null,
    'client_payment_date' => $request['payment']['clientPaymentDate'] ?? null,
    'installment_number' => $request['payment']['installmentNumber'] ?? null,
    'invoice_url' => $request['payment']['invoiceUrl'],
    'invoice_number' => $request['payment']['invoiceNumber'] ?? null,
    'external_reference' => $projectName,
    'deleted' => $request['payment']['deleted'],
    'anticipated' => $request['payment']['anticipated'],
    'anticipable' => $request['payment']['anticipable'],
    'credit_date' => $request['payment']['creditDate'] ?? null,
    'estimated_credit_date' => $request['payment']['estimatedCreditDate'] ?? null,
    'transaction_receipt_url' => $request['payment']['transactionReceiptUrl'] ?? null,
    'nosso_numero' => $request['payment']['nossoNumero'] ?? null,
    'bank_slip_url' => $request['payment']['bankSlipUrl'] ?? null,
    'last_invoice_viewed_date' => $request['payment']['lastInvoiceViewedDate'] ?? null,
    'last_bank_slip_viewed_date' => $request['payment']['lastBankSlipViewedDate'] ?? null,
    'discount_value' => $request['payment']['discount']['value'] ?? 0,
    'discount_limit_date' => $request['payment']['discount']['limitDate'] ?? null,
    'due_date_limit_days' => $request['payment']['discount']['dueDateLimitDays'] ?? null,
    'discount_type' => $request['payment']['discount']['type'] ?? null,
    'fine_value' => $request['payment']['fine']['value'] ?? null,
    'fine_type' => $request['payment']['fine']['type'] ?? null,
    'interest_value' => $request['payment']['interest']['value'] ?? null,
    'interest_type' => $request['payment']['interest']['type'] ?? null,
    'postal_service' => $request['payment']['postalService'] ?? null,
    'escrow_id' => $request['payment']['escrow']['id'] ?? null,
    'escrow_status' => $request['payment']['escrow']['status'] ?? null,
    'escrow_expiration_date' => $request['payment']['escrow']['expirationDate'] ?? null,
    'escrow_finish_date' => $request['payment']['escrow']['finishDate'] ?? null,
    'escrow_finish_reason' => $request['payment']['escrow']['finishReason'] ?? null,
    'refund_date_created' => $request['payment']['refunds']['dateCreated'] ?? null,
    'refund_status' => $request['payment']['refunds']['status'] ?? null,
    'refund_value' => $request['payment']['refunds']['value'] ?? null,
    'refund_end_to_end_identifier' => $request['payment']['refunds']['endToEndIdentifier'] ?? null,
    'refund_description' => $request['payment']['refunds']['description'] ?? null,
    'refund_effective_date' => $request['payment']['refunds']['effectiveDate'] ?? null,
    'refund_transaction_receipt_url' => $request['payment']['refunds']['transactionReceiptUrl'] ?? null,
    'user_id' => (int) $userId,
    'pix_qr_code_id' => $request['payment']['pixQrCodeId'] ?? null
]);

        switch($webhookDataDTO->external_reference){
            case 'dalle_manage':
             return $this->manageRepository->create($webhookDataDTO->toArray());
            break;
        }
    }

    private function update($request)
    {
        $parts = explode('|', $request['payment']['externalReference']);
            $projectName = $parts[0];
            $userPart = $parts[1];
            $userId = (int) str_replace('user_', '', $userPart);  

        $webhookDataDTO = AsaasCreateOrUpdateWebhookDataDTO::fromRequest([
        'event_id' => $request['id'],
    'event' => $request['event'],
    'change_date' => $request['dateCreated'],
    'object' => $request['payment']['object'],
    'payment_id' => $request['payment']['id'],
    'payment_date_created' => $request['payment']['dateCreated'],
    'customer_id' => $request['payment']['customer'],
    'checkout_session' => $request['payment']['checkoutSession'] ?? null,
    'payment_link' => $request['payment']['paymentLink'] ?? null,
    'value' => $request['payment']['value'],
    'net_value' => $request['payment']['netValue'],
    'original_value' => $request['payment']['originalValue'] ?? null,
    'description' => $request['payment']['description'] ?? null,
    'billing_type' => $request['payment']['billingType'],
    'confirmed_date' => $request['payment']['confirmedDate'] ?? null,
    'pix_transaction' => $request['payment']['pixTransaction'] ?? null,
    'status' => $request['payment']['status'],
    'due_date' => $request['payment']['dueDate'],
    'original_due_date' => $request['payment']['originalDueDate'],
    'settlement_date' => $request['payment']['paymentDate'] ?? null,
    'client_payment_date' => $request['payment']['clientPaymentDate'] ?? null,
    'installment_number' => $request['payment']['installmentNumber'] ?? null,
    'invoice_url' => $request['payment']['invoiceUrl'],
    'invoice_number' => $request['payment']['invoiceNumber'] ?? null,
    'external_reference' => $projectName,
    'deleted' => $request['payment']['deleted'],
    'anticipated' => $request['payment']['anticipated'],
    'anticipable' => $request['payment']['anticipable'],
    'credit_date' => $request['payment']['creditDate'] ?? null,
    'estimated_credit_date' => $request['payment']['estimatedCreditDate'] ?? null,
    'transaction_receipt_url' => $request['payment']['transactionReceiptUrl'] ?? null,
    'nosso_numero' => $request['payment']['nossoNumero'] ?? null,
    'bank_slip_url' => $request['payment']['bankSlipUrl'] ?? null,
    'last_invoice_viewed_date' => $request['payment']['lastInvoiceViewedDate'] ?? null,
    'last_bank_slip_viewed_date' => $request['payment']['lastBankSlipViewedDate'] ?? null,
    'discount_value' => $request['payment']['discount']['value'] ?? 0,
    'discount_limit_date' => $request['payment']['discount']['limitDate'] ?? null,
    'due_date_limit_days' => $request['payment']['discount']['dueDateLimitDays'] ?? null,
    'discount_type' => $request['payment']['discount']['type'] ?? null,
    'fine_value' => $request['payment']['fine']['value'] ?? null,
    'fine_type' => $request['payment']['fine']['type'] ?? null,
    'interest_value' => $request['payment']['interest']['value'] ?? null,
    'interest_type' => $request['payment']['interest']['type'] ?? null,
    'postal_service' => $request['payment']['postalService'] ?? null,
    'escrow_id' => $request['payment']['escrow']['id'] ?? null,
    'escrow_status' => $request['payment']['escrow']['status'] ?? null,
    'escrow_expiration_date' => $request['payment']['escrow']['expirationDate'] ?? null,
    'escrow_finish_date' => $request['payment']['escrow']['finishDate'] ?? null,
    'escrow_finish_reason' => $request['payment']['escrow']['finishReason'] ?? null,
    'refund_date_created' => $request['payment']['refunds']['dateCreated'] ?? null,
    'refund_status' => $request['payment']['refunds']['status'] ?? null,
    'refund_value' => $request['payment']['refunds']['value'] ?? null,
    'refund_end_to_end_identifier' => $request['payment']['refunds']['endToEndIdentifier'] ?? null,
    'refund_description' => $request['payment']['refunds']['description'] ?? null,
    'refund_effective_date' => $request['payment']['refunds']['effectiveDate'] ?? null,
    'refund_transaction_receipt_url' => $request['payment']['refunds']['transactionReceiptUrl'] ?? null,
    'user_id' => $userId,
    'pix_qr_code_id' => $request['payment']['pixQrCodeId'] ?? null
]);

        switch($webhookDataDTO->external_reference){
            case 'dalle_manage':
             return $this->manageRepository->update($webhookDataDTO->payment_id, $webhookDataDTO->toArray());
            break;
        }
    }

    private function checkPaymentPix($request)
    {
        if($this->paymentInfoRepository->findById($request['payment']['pixQrCodeId'])){
            $this->store($request);
            $this->paymentInfoRepository->delete($request['payment']['pixQrCodeId']);
            SendEventPixJob::dispatch(true);
        } else {
            SendEventPixJob::dispatch(false);
        }
    }
}
