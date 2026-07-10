<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log(string $action, string $module, ?string $entityId = null, ?string $entityType = null, ?string $details = null)
    {
        $user = auth()->user();

        if (!$user) {
            return;
        }

        AuditLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'action' => $action,
            'module' => $module,
            'entity_id' => $entityId,
            'entity_type' => $entityType,
            'details' => $details,
            'branch_id' => $user->branch_id,
            'branch_name' => $user->branch_name,
            'ip_address' => Request::ip(),
        ]);
    }
}
