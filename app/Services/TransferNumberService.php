<?php

namespace App\Services;

use App\Models\Transfer;

class TransferNumberService
{
    public static function generate(): string
    {
        $year = date('Y');
        $prefix = "TRN-{$year}-";

        $lastTransfer = Transfer::where('transfer_number', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransfer) {
            // Extract the sequential part
            $parts = explode('-', $lastTransfer->transfer_number);
            $lastNumber = intval(end($parts));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
