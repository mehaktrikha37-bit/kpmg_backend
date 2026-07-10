<?php

namespace App\Services;

use App\Models\StockItem;

class StockCodeService
{
    public static function generate(): string
    {
        $prefix = "STK-";

        $lastItem = StockItem::where('item_code', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastItem) {
            // Extract the sequential part
            $parts = explode('-', $lastItem->item_code);
            $lastNumber = intval(end($parts));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
