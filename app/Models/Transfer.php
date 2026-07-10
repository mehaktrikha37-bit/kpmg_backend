<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    protected $fillable = [
        'transfer_number', 'source_branch_id', 'source_branch_name',
        'destination_branch_id', 'destination_branch_name', 'device_id',
        'job_number', 'device_info', 'customer_id', 'customer_name',
        'reason', 'reason_other', 'remarks', 'requested_by_id',
        'requested_by_name', 'approved_by_id', 'approved_by_name',
        'received_by_id', 'received_by_name', 'status', 'requested_at',
        'approved_at', 'dispatched_at', 'received_at', 'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'received_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function sourceBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'source_branch_id');
    }

    public function destinationBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'destination_branch_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requested_by_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'received_by_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(TransferImage::class);
    }
}
