<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceReport extends Model
{
    protected $fillable = [
        'device_id', 'job_number', 'customer_id', 'customer_name',
        'customer_mobile', 'customer_address', 'device_type', 'brand',
        'model', 'serial_number', 'call_received_date', 'call_attended_date',
        'call_completed_date', 'call_type', 'service_type', 'problem_description',
        'accessories_received', 'action_taken', 'rectification_details',
        'engineer_remarks', 'estimate_amount', 'call_status',
        'customer_signature', 'employee_signature', 'created_by',
        'branch_id', 'branch_name',
    ];

    protected $casts = [
        'call_received_date' => 'datetime',
        'call_attended_date' => 'datetime',
        'call_completed_date' => 'datetime',
        'accessories_received' => 'array',
        'estimate_amount' => 'decimal:2',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
