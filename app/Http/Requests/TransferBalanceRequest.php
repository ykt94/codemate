<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferBalanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_user_id' => ['required', 'integer', 'exists:users,id'],
            'to_user_id' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'comment' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
