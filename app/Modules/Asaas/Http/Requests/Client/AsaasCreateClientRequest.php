<?php

namespace App\Modules\Asaas\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class AsaasCreateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|numeric',
            'name' => 'required|string|min:3|max:30',
            'cpfCnpj' => ['required', 'string', 'regex:/^\d{11}$|^\d{14}$/'],
            'email' => 'nullable|string|email|max:50',
            'mobilePhone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'addressNumber' => 'nullable|string|max:15',
            'postalCode' => 'nullable|string|max:8',
            'company' => 'required|string|min:3|max:30',
            'complement' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O campo ID é obrigatório.',
            'id.numeric' => 'O campo ID deve ser um número.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O nome deve ter no máximo 30 caracteres.',
            'cpfCnpj.required' => 'O CPF/CNPJ é obrigatório.',
            'cpfCnpj.string' => 'O CPF/CNPJ deve ser um texto.',
            'cpfCnpj.regex' => 'O CPF/CNPJ deve conter exatamente 11 ou 14 dígitos numéricos.',
            'email.string' => 'O e-mail deve ser um texto.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.max' => 'O e-mail deve ter no máximo 50 caracteres.',
            'mobilePhone.string' => 'O celular deve ser um texto.',
            'mobilePhone.max' => 'O celular deve ter no máximo 20 caracteres.',
            'address.string' => 'O endereço deve ser um texto.',
            'address.max' => 'O endereço deve ter no máximo 255 caracteres.',
            'addressNumber.string' => 'O número do endereço deve ser um texto.',
            'addressNumber.max' => 'O número do endereço deve ter no máximo 15 caracteres.',
            'postalCode.string' => 'O CEP deve ser um texto.',
            'postalCode.max' => 'O CEP deve conter no máximo 8 caracteres.',
            'company.required' => 'O nome da empresa é obrigatório.',
            'company.string' => 'O nome da empresa deve ser um texto.',
            'company.min' => 'O nome da empresa deve ter no mínimo 3 caracteres.',
            'company.max' => 'O nome da empresa deve ter no máximo 30 caracteres.',
            'complement.string' => 'O complemento deve ser um texto.',
            'complement.max' => 'O complemento deve ter no máximo 255 caracteres.',
            'province.string' => 'A província deve ser um texto.',
            'province.max' => 'A província deve ter no máximo 100 caracteres.',
        ];
    }
}
