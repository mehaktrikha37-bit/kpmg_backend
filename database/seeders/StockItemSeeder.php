<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockItem;

class StockItemSeeder extends Seeder
{
    public function run(): void
    {
        // Branch 1 stock items
        StockItem::create([
            'item_code'          => 'STK-001',
            'name'               => 'Laptop Battery (HP Pavilion)',
            'part_number'        => 'HP-BAT-15-BS',
            'category'           => 'Battery',
            'compatible_devices' => 'HP Pavilion 15, HP Laptop 15',
            'brand'              => 'HP OEM',
            'quantity'           => 5,
            'reorder_level'      => 2,
            'unit_cost'          => 1200.00,
            'selling_price'      => 1800.00,
            'supplier'           => 'HP Parts India',
            'branch_id'          => 1,
            'branch_name'        => 'HQ - TechFix Central',
            'location'           => 'Rack A1',
            'warranty'           => '6 months',
            'condition'          => 'New',
            'unit'               => 'pcs',
            'added_by'           => 4,
        ]);

        StockItem::create([
            'item_code'          => 'STK-002',
            'name'               => 'DDR4 8GB RAM Module',
            'part_number'        => 'KVR32S22S8-8',
            'category'           => 'RAM',
            'compatible_devices' => 'Laptops / Desktops (DDR4)',
            'brand'              => 'Kingston',
            'quantity'           => 10,
            'reorder_level'      => 3,
            'unit_cost'          => 1500.00,
            'selling_price'      => 2200.00,
            'supplier'           => 'Kingston India',
            'branch_id'          => 1,
            'branch_name'        => 'HQ - TechFix Central',
            'location'           => 'Rack A2',
            'warranty'           => '1 year',
            'condition'          => 'New',
            'unit'               => 'pcs',
            'added_by'           => 4,
        ]);

        StockItem::create([
            'item_code'          => 'STK-003',
            'name'               => '256GB SSD SATA',
            'part_number'        => 'MZ-77E250B',
            'category'           => 'Storage',
            'compatible_devices' => 'Laptops / Desktops (SATA)',
            'brand'              => 'Samsung',
            'quantity'           => 7,
            'reorder_level'      => 2,
            'unit_cost'          => 2200.00,
            'selling_price'      => 3200.00,
            'supplier'           => 'Samsung India',
            'branch_id'          => 1,
            'branch_name'        => 'HQ - TechFix Central',
            'location'           => 'Rack B1',
            'warranty'           => '3 years',
            'condition'          => 'New',
            'unit'               => 'pcs',
            'added_by'           => 4,
        ]);

        StockItem::create([
            'item_code'          => 'STK-004',
            'name'               => 'Laptop Charger 65W (Dell)',
            'part_number'        => 'DA65NS4-00',
            'category'           => 'Charger / Adapter',
            'compatible_devices' => 'Dell Inspiron, Dell Vostro',
            'brand'              => 'Dell OEM',
            'quantity'           => 3,
            'reorder_level'      => 1,
            'unit_cost'          => 600.00,
            'selling_price'      => 950.00,
            'supplier'           => 'Dell Accessories India',
            'branch_id'          => 1,
            'branch_name'        => 'HQ - TechFix Central',
            'location'           => 'Rack C1',
            'warranty'           => '3 months',
            'condition'          => 'New',
            'unit'               => 'pcs',
            'added_by'           => 4,
        ]);

        StockItem::create([
            'item_code'          => 'STK-005',
            'name'               => 'Thermal Paste (Tube)',
            'part_number'        => 'MX-4-2G',
            'category'           => 'Consumables',
            'compatible_devices' => 'All CPUs / GPUs',
            'brand'              => 'Arctic',
            'quantity'           => 20,
            'reorder_level'      => 5,
            'unit_cost'          => 150.00,
            'selling_price'      => 250.00,
            'supplier'           => 'Arctic Direct',
            'branch_id'          => 1,
            'branch_name'        => 'HQ - TechFix Central',
            'location'           => 'Shelf D1',
            'warranty'           => null,
            'condition'          => 'New',
            'unit'               => 'tubes',
            'added_by'           => 4,
        ]);

        StockItem::create([
            'item_code'          => 'STK-006',
            'name'               => 'Canon PIXMA Ink Set (B/C/M/Y)',
            'part_number'        => 'CL-746-PG-745',
            'category'           => 'Printer Ink / Toner',
            'compatible_devices' => 'Canon PIXMA G3010, G2010',
            'brand'              => 'Canon',
            'quantity'           => 4,
            'reorder_level'      => 2,
            'unit_cost'          => 400.00,
            'selling_price'      => 650.00,
            'supplier'           => 'Canon India',
            'branch_id'          => 2,
            'branch_name'        => 'North Branch',
            'location'           => 'Shelf A1',
            'warranty'           => null,
            'condition'          => 'New',
            'unit'               => 'sets',
            'added_by'           => 5,
        ]);

        StockItem::create([
            'item_code'          => 'STK-007',
            'name'               => 'RJ45 Cat6 Patch Cable (1m)',
            'part_number'        => 'RJ45-CAT6-1M',
            'category'           => 'Networking',
            'compatible_devices' => 'Routers, Switches, Hubs',
            'brand'              => 'D-Link',
            'quantity'           => 15,
            'reorder_level'      => 5,
            'unit_cost'          => 80.00,
            'selling_price'      => 150.00,
            'supplier'           => 'D-Link India',
            'branch_id'          => 1,
            'branch_name'        => 'HQ - TechFix Central',
            'location'           => 'Shelf D2',
            'warranty'           => null,
            'condition'          => 'New',
            'unit'               => 'pcs',
            'added_by'           => 4,
        ]);
    }
}
