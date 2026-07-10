<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_id' => 'required|exists:devices,id',
            'call_received_date' => 'nullable|date',
            'call_attended_date' => 'nullable|date',
            'call_completed_date' => 'nullable|date',
            'call_type' => 'required|in:warranty,out_warranty,amc',
            'service_type' => 'required|in:onsite,carry_in,one_hour',
            'problem_description' => 'required|string',
            'accessories_received' => 'nullable|array',
            'action_taken' => 'nullable|string',
            'rectification_details' => 'nullable|string',
            'engineer_remarks' => 'nullable|string',
            'estimate_amount' => 'nullable|numeric|min:0',
            'call_status' => 'required|in:completed,pending_spare,pending_technical_support,customer_confirmation,other',
            'customer_signature' => 'nullable|string',
            'employee_signature' => 'nullable|string',
        ];
    }
}
