<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceStatusHistory extends Model
{
    protected $table = 'device_status_history';

    protected $fillable = [
        'device_id', 'status', 'description', 'performed_by',
        'performed_by_name', 'branch_id', 'branch_name',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'performed_by');
    }
}
