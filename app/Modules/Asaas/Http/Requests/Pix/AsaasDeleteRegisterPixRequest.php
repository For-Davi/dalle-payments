<?php

namespace App\Modules\Asaas\Http\Requests\Pix;

use App\Enums\ProjectIdentifier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AsaasDeleteRegisterPixRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userID' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'userID.required' => 'O ID do usuário é obrigatório.',
            'userID.numeric' => 'O ID do usuário deve ser numérico.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
