<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\AuditService;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key')->map->value;

        return response()->json([
            'success' => true,
            'data' => $settings,
            'message' => 'Settings retrieved',
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value, 'type' => is_array($value) ? 'json' : 'string']
            );
        }

        AuditService::log('update', 'settings');

        return response()->json([
            'success' => true,
            'message' => 'Settings updated',
        ]);
    }
}
