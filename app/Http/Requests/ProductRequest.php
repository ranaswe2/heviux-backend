<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules()
{
    return [
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'sub_category' => 'required|string|max:255',
        'fabric' => 'required|string|max:255',
        'GSM' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
       'created_by' => 'required|exists:users,id',
       'modified_by' => 'nullable|exists:users,id',
    ];
}
}
