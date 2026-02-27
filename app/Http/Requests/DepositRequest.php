<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Utils\NumberHelper;

class DepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'O valor do depósito é obrigatório.',
            'amount.numeric'  => 'O valor deve ser numérico.',
            'amount.min'      => 'O depósito deve ser maior que zero.',
        ];
    }

    protected function prepareForValidation()
    {
        $valor = NumberHelper::parseCurrency($this->input('amount'));

        $this->merge([
            'amount' => $valor,
        ]);
    }
}
