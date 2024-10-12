<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'small' => 'required|integer|min:0',
            'medium' => 'required|integer|min:0',
            'large' => 'required|integer|min:0',
            'xlarge' => 'required|integer|min:0',
            'xxlarge' => 'required|integer|min:0',
            'xxxlarge' => 'required|integer|min:0',
            'created_by' => 'exists:users,id',
            'modified_by' => 'nullable|exists:users,id',
        ];
    }
}
