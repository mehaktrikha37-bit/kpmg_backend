<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class LeadLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile'   => 'required|string|regex:/^[0-9]{10}$/',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.regex' => 'Username must be a valid 10-digit mobile number.',
        ];
    }
}
