<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'category' => 'required|in:all,men,women,kids',
            'percentage' => 'required|numeric|between:1,99',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'created_by' => 'exists:users,id',
            'modified_by' => 'nullable|exists:users,id',
        ];
    }
}
