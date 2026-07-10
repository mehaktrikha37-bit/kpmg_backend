<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceImage extends Model
{
    protected $fillable = [
        'device_id', 'type', 'slot', 'image_path',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
