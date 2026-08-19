<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadExecutiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\LeadUser $user */
        $user = auth('lead')->user();
        return $user && $user->role === 'super_admin';
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|unique:lead_users,email,' . $id,
            'branch'      => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'status'      => 'required|string|in:active,inactive',
            'password'    => 'nullable|string|min:6',
        ];
    }
}
