<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryChargeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'price' => 'required|numeric|min:0.01', // Adjust the validation rules as needed
            'created_by' => 'required|exists:super_admins,id',
            'modified_by' => 'nullable|exists:users,id',
        ];
    }
}
