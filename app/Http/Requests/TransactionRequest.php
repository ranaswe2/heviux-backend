<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'process_id' => 'required|exists:orders,process_id',
            'total_amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'unique:transactions,transaction_id',
            'status' => 'required|string|in:pending,completed,failed',
        ];
    }
}
