<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name', 'code', 'mobile', 'email', 'password', 'designation',
        'branch_id', 'branch_name', 'role', 'is_active', 'must_change_password',
        'is_first_login', 'assigned_devices', 'completed_jobs', 'avatar_url', 'joined_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'must_change_password' => 'boolean',
        'is_first_login' => 'boolean',
        'joined_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignedDevices(): HasMany
    {
        return $this->hasMany(Device::class, 'assigned_technician_id');
    }

    public function createdDevices(): HasMany
    {
        return $this->hasMany(Device::class, 'created_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }
}
