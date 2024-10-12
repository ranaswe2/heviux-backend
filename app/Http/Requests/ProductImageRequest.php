<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'exists:products,id',
            'image_name' => 'string',
            'path' => 'string',
            'description' => 'nullable|string',
            'created_by' => 'exists:users,id',
            'modified_by' => 'nullable|exists:users,id',
        ];
    }
}