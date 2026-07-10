<?php

namespace App\Services;

use App\Models\Device;

class JobNumberService
{
    public static function generate(): string
    {
        $year = date('Y');
        $prefix = "JOB-{$year}-";

        $lastDevice = Device::where('job_number', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastDevice) {
            // Extract the sequential part
            $parts = explode('-', $lastDevice->job_number);
            $lastNumber = intval(end($parts));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public static function generateReceipt(): string
    {
        $year = date('Y');
        $prefix = "RCP-{$year}-";

        $lastDevice = Device::where('receipt_number', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastDevice) {
            // Extract the sequential part
            $parts = explode('-', $lastDevice->receipt_number);
            $lastNumber = intval(end($parts));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
