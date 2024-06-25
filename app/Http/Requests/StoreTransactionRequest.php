<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => 'required',
            'payer_id' => 'required',
            'payee_id' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'This field is required.',
            'payer_id.required' => 'This field is required.',
            'payee_id.required' => 'This field is required.',
            'status.required' => 'This field is required.',
        ];
    }
}
