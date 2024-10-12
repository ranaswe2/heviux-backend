<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string|in:small,medium,large,xlarge,xxlarge,xxxlarge', // Adjust based on your size options
            'user_id' => 'exists:users,id',
            'process_id' => 'string'
        ];
    }
}
