<?php

namespace App\Modules\Asaas\Http\Requests\Pix;

use App\Enums\ProjectIdentifier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateAsaasPixRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => 'required|numeric|min:0.01|max:10000',
            'userID' => 'required|numeric',
            'subscriptionID' => 'required|numeric',
            'monthQuantity' => 'required|numeric',
            'identifier' => ['required', 'string', new Enum(ProjectIdentifier::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'O valor do pagamento PIX é obrigatório.',
            'value.numeric' => 'O valor do pagamento PIX deve ser um número.',
            'value.min' => 'O valor do pagamento PIX deve ser no mínimo 0.01.',
            'value.max' => 'O valor do pagamento PIX deve ser no máximo 10000.',
            'userID.required' => 'O ID do usuário é obrigatório.',
            'userID.numeric' => 'O ID do usuário deve ser numérico.',
            'subscriptionID.required' => 'O ID da assinatura é obrigatório.',
            'subscriptionID.numeric' => 'O ID da assinatura deve ser numérico.',
            'monthQuantity.required' => 'A quantidade de meses é obrigatório.',
            'monthQuantity.numeric' => 'A quantidade de meses deve ser numérica.',
            'identifier.required' => 'O identificador é obrigatório.',
            'identifier.string' => 'O identificador deve ser um texto válido.',
            'identifier.enum' => 'O identificador informado não é válido.',
        ];
    }
}
