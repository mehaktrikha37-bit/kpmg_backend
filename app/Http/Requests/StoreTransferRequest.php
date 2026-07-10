<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'destination_branch_id' => 'required|exists:branches,id',
            'device_id' => 'required|exists:devices,id',
            'reason' => 'required|in:motherboard_repair,chip_level_repair,expertise_unavailable,spare_unavailable,warranty_processing,other',
            'reason_other' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ];
    }
}
