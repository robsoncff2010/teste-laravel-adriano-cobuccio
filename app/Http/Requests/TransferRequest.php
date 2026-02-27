<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Utils\NumberHelper;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'exists:users,id', 'different:sender_id'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.required'  => 'O destinatário é obrigatório.',
            'receiver_id.exists'    => 'O destinatário informado não existe.',
            'receiver_id.different' => 'Você não pode transferir para si mesmo.',
            'amount.required'       => 'O valor da transferência é obrigatório.',
            'amount.numeric'        => 'O valor deve ser numérico.',
            'amount.min'            => 'O valor deve ser maior que zero.',
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
