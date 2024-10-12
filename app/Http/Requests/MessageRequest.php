<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sender_id' => 'exists:users,id',
            'receiver_id' => 'exists:users,id',
            'text' => 'nullable|string',
           // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5 MB maximum
    ];
    }
}
