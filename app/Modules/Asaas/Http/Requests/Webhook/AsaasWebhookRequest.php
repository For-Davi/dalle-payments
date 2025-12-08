<?php

namespace App\Modules\Asaas\Http\Requests\Webhook;

use Illuminate\Foundation\Http\FormRequest;

class AsaasWebhookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|string',
            'event' => 'required|string',
            'dateCreated' => 'required|date_format:Y-m-d H:i:s',
            'payment' => 'required|array',
            'payment.object' => 'required|string',
            'payment.id' => 'required|string',
            'payment.dateCreated' => 'required|date_format:Y-m-d',
            'payment.customer' => 'required|string',
            'payment.checkoutSession' => 'nullable|string',
            'payment.paymentLink' => 'nullable|string',
            'payment.value' => 'required|numeric',
            'payment.netValue' => 'required|numeric',
            'payment.originalValue' => 'nullable|numeric',
            'payment.interestValue' => 'nullable|numeric',
            'payment.description' => 'nullable|string',
            'payment.billingType' => 'required|string',
            'payment.confirmedDate' => 'nullable|date_format:Y-m-d',
            'payment.pixTransaction' => 'nullable|string',
            'payment.status' => 'required|string',
            'payment.dueDate' => 'required|date_format:Y-m-d',
            'payment.originalDueDate' => 'required|date_format:Y-m-d',
            'payment.paymentDate' => 'nullable|date_format:Y-m-d',
            'payment.clientPaymentDate' => 'nullable|date_format:Y-m-d',
            'payment.installmentNumber' => 'nullable|integer',
            'payment.invoiceUrl' => 'required|url',
            'payment.invoiceNumber' => 'nullable|integer',
            'payment.externalReference' => 'nullable|string',
            'payment.deleted' => 'required|boolean',
            'payment.anticipated' => 'required|boolean',
            'payment.anticipable' => 'required|boolean',
            'payment.creditDate' => 'nullable|date_format:Y-m-d',
            'payment.estimatedCreditDate' => 'nullable|date_format:Y-m-d',
            'payment.transactionReceiptUrl' => 'nullable|url',
            'payment.nossoNumero' => 'nullable|string',
            'payment.bankSlipUrl' => 'nullable|url',
            'payment.lastInvoiceViewedDate' => 'nullable|date_format:Y-m-d',
            'payment.lastBankSlipViewedDate' => 'nullable|date_format:Y-m-d',
            'payment.discount' => 'required|array',
            'payment.discount.value' => 'required|numeric',
            'payment.discount.limitDate' => 'nullable|date_format:Y-m-d',
            'payment.discount.dueDateLimitDays' => 'required|integer',
            'payment.discount.type' => 'required|string',
            'payment.fine' => 'required|array',
            'payment.fine.value' => 'required|numeric',
            'payment.fine.type' => 'required|string',
            'payment.interest' => 'required|array',
            'payment.interest.value' => 'required|numeric',
            'payment.interest.type' => 'required|string',
            'payment.postalService' => 'required|boolean',
            'payment.escrow' => 'nullable|array',
            'payment.escrow.id' => 'nullable|string',
            'payment.escrow.status' => 'nullable|string',
            'payment.escrow.expirationDate' => 'nullable|date_format:Y-m-d',
            'payment.escrow.finishDate' => 'nullable|date_format:Y-m-d',
            'payment.escrow.finishReason' => 'nullable|string',
            'payment.refunds' => 'nullable|array',
            'payment.refunds.dateCreated' => 'nullable|date_format:Y-m-d',
            'payment.refunds.status' => 'nullable|string',
            'payment.refunds.value' => 'nullable|numeric',
            'payment.refunds.endToEndIdentifier' => 'nullable|string',
            'payment.refunds.description' => 'nullable|string',
            'payment.refunds.effectiveDate' => 'nullable|date_format:Y-m-d',
            'payment.refunds.transactionReceiptUrl' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [

            // Evento
            'id.required' => 'Deve ser informado o id do evento.',
            'id.string' => 'O id do evento deve ser uma string.',
            'event.required' => 'Deve ser informado o tipo do evento.',
            'event.string' => 'O tipo do evento deve ser uma string.',
            'dateCreated.required' => 'A data de criação do evento deve ser informada.',
            'dateCreated.date_format' => 'A data de criação do evento deve estar no formato Y-m-d H:i:s.',

            // Payment
            'payment.required' => 'Os dados do pagamento devem ser enviados.',
            'payment.array' => 'Os dados do pagamento devem ser um array.',
            'payment.object.required' => 'O campo object do pagamento deve ser informado.',
            'payment.object.string' => 'O campo object do pagamento deve ser uma string.',
            'payment.id.required' => 'O id do pagamento deve ser informado.',
            'payment.id.string' => 'O id do pagamento deve ser uma string.',
            'payment.dateCreated.required' => 'A data de criação do pagamento deve ser informada.',
            'payment.dateCreated.date_format' => 'A data de criação do pagamento deve estar no formato Y-m-d.',
            'payment.customer.required' => 'O id do cliente deve ser informado.',
            'payment.customer.string' => 'O id do cliente deve ser uma string.',
            'payment.checkoutSession.string' => 'O checkoutSession deve ser uma string.',
            'payment.paymentLink.string' => 'O paymentLink deve ser uma string.',
            'payment.value.required' => 'O valor do pagamento deve ser informado.',
            'payment.value.numeric' => 'O valor do pagamento deve ser numérico.',
            'payment.netValue.required' => 'O valor líquido deve ser informado.',
            'payment.netValue.numeric' => 'O valor líquido deve ser numérico.',
            'payment.originalValue.numeric' => 'O valor original deve ser numérico.',
            'payment.interestValue.numeric' => 'O valor de juros deve ser numérico.',
            'payment.description.string' => 'A descrição deve ser uma string.',
            'payment.billingType.required' => 'O tipo de cobrança deve ser informado.',
            'payment.billingType.string' => 'O tipo de cobrança deve ser uma string.',
            'payment.confirmedDate.date_format' => 'A data de confirmação deve estar no formato Y-m-d.',
            'payment.pixTransaction.string' => 'A pixTransaction deve ser uma string.',
            'payment.status.required' => 'O status do pagamento deve ser informado.',
            'payment.status.string' => 'O status do pagamento deve ser uma string.',
            'payment.dueDate.required' => 'A data de vencimento deve ser informada.',
            'payment.dueDate.date_format' => 'A data de vencimento deve estar no formato Y-m-d.',
            'payment.originalDueDate.required' => 'A data de vencimento original deve ser informada.',
            'payment.originalDueDate.date_format' => 'A data de vencimento original deve estar no formato Y-m-d.',
            'payment.paymentDate.date_format' => 'A data de pagamento deve estar no formato Y-m-d.',
            'payment.clientPaymentDate.date_format' => 'A data de pagamento do cliente deve estar no formato Y-m-d.',
            'payment.installmentNumber.integer' => 'O número da parcela deve ser um número inteiro.',
            'payment.invoiceUrl.required' => 'A URL da fatura deve ser informada.',
            'payment.invoiceUrl.url' => 'A URL da fatura deve ser válida.',
            'payment.invoiceNumber.integer' => 'O número da fatura deve ser um número inteiro.',
            'payment.externalReference.string' => 'A referência externa deve ser uma string.',
            'payment.deleted.required' => 'O campo deleted deve ser informado.',
            'payment.deleted.boolean' => 'O campo deleted deve ser booleano.',
            'payment.anticipated.required' => 'O campo anticipated deve ser informado.',
            'payment.anticipated.boolean' => 'O campo anticipated deve ser booleano.',
            'payment.anticipable.required' => 'O campo anticipable deve ser informado.',
            'payment.anticipable.boolean' => 'O campo anticipable deve ser booleano.',
            'payment.creditDate.date_format' => 'A data de crédito deve estar no formato Y-m-d.',
            'payment.estimatedCreditDate.date_format' => 'A data estimada de crédito deve estar no formato Y-m-d.',
            'payment.transactionReceiptUrl.url' => 'A URL do comprovante de transação deve ser válida.',
            'payment.nossoNumero.string' => 'O nosso número deve ser uma string.',
            'payment.bankSlipUrl.url' => 'A URL do boleto deve ser válida.',
            'payment.lastInvoiceViewedDate.date_format' => 'A data de visualização da fatura deve estar no formato Y-m-d.',
            'payment.lastBankSlipViewedDate.date_format' => 'A data de visualização do boleto deve estar no formato Y-m-d.',

            // Discount
            'payment.discount.required' => 'Os dados de desconto devem ser enviados.',
            'payment.discount.array' => 'Os dados de desconto devem ser um array.',
            'payment.discount.value.required' => 'O valor de desconto deve ser informado.',
            'payment.discount.value.numeric' => 'O valor de desconto deve ser numérico.',
            'payment.discount.limitDate.date_format' => 'A data limite de desconto deve estar no formato Y-m-d.',
            'payment.discount.dueDateLimitDays.required' => 'O número de dias limite para desconto deve ser informado.',
            'payment.discount.dueDateLimitDays.integer' => 'O número de dias limite para desconto deve ser inteiro.',
            'payment.discount.type.required' => 'O tipo de desconto deve ser informado.',
            'payment.discount.type.string' => 'O tipo de desconto deve ser uma string.',

            // Fine
            'payment.fine.required' => 'Os dados da multa devem ser enviados.',
            'payment.fine.array' => 'Os dados da multa devem ser um array.',
            'payment.fine.value.required' => 'O valor da multa deve ser informado.',
            'payment.fine.value.numeric' => 'O valor da multa deve ser numérico.',
            'payment.fine.type.required' => 'O tipo da multa deve ser informado.',
            'payment.fine.type.string' => 'O tipo da multa deve ser uma string.',

            // Interest
            'payment.interest.required' => 'Os dados de juros devem ser enviados.',
            'payment.interest.array' => 'Os dados de juros devem ser um array.',
            'payment.interest.value.required' => 'O valor dos juros deve ser informado.',
            'payment.interest.value.numeric' => 'O valor dos juros deve ser numérico.',
            'payment.interest.type.required' => 'O tipo dos juros deve ser informado.',
            'payment.interest.type.string' => 'O tipo dos juros deve ser uma string.',

            // Postal service
            'payment.postalService.required' => 'O campo postalService deve ser informado.',
            'payment.postalService.boolean' => 'O campo postalService deve ser booleano.',

            // Escrow
            'payment.escrow.array' => 'Os dados de escrow devem ser um array.',
            'payment.escrow.id.string' => 'O id do escrow deve ser uma string.',
            'payment.escrow.status.string' => 'O status do escrow deve ser uma string.',
            'payment.escrow.expirationDate.date_format' => 'A data de expiração do escrow deve estar no formato Y-m-d.',
            'payment.escrow.finishDate.date_format' => 'A data de finalização do escrow deve estar no formato Y-m-d.',
            'payment.escrow.finishReason.string' => 'O motivo de finalização deve ser uma string.',

            // Refunds
            'payment.refunds.array' => 'Os dados de reembolso devem ser um array.',
            'payment.refunds.dateCreated.date_format' => 'A data de criação do reembolso deve estar no formato Y-m-d.',
            'payment.refunds.status.string' => 'O status do reembolso deve ser uma string.',
            'payment.refunds.value.numeric' => 'O valor do reembolso deve ser numérico.',
            'payment.refunds.endToEndIdentifier.string' => 'O identificador endToEnd deve ser uma string.',
            'payment.refunds.description.string' => 'A descrição do reembolso deve ser uma string.',
            'payment.refunds.effectiveDate.date_format' => 'A data efetiva do reembolso deve estar no formato Y-m-d.',
            'payment.refunds.transactionReceiptUrl.url' => 'A URL do comprovante de reembolso deve ser válida.',
        ];
    }
}
