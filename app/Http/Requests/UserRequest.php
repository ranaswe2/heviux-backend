<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'nullable|string|regex:/^(\+?[0-9]{1,4}\s?)?([0-9]\s?[-.]?\s?){6,14}[0-9]$/',
        'image_name' => 'nullable|string',
        'image_path' => 'nullable|string',
        'password' => 'required|string|min:6|confirmed',
        'address' => 'nullable|string|max:511',
        'is_admin' => 'boolean',
        'current_otp' => 'nullable|string',
        ];
        
    }
}
