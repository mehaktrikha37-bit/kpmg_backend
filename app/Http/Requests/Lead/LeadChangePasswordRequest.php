<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class LeadChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => 'nullable|string',
            'new_password'     => 'required|string|min:6|confirmed',
            'is_force_reset'   => 'boolean',
        ];
    }
}
