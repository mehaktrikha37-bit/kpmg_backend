<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transfer;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        // Transfer 1 — Device 5 (Cisco Router), Branch 1 → Branch 2, pending
        Transfer::create([
            'transfer_number'          => 'TRF-2024-0001',
            'source_branch_id'         => 1,
            'source_branch_name'       => 'HQ - TechFix Central',
            'destination_branch_id'    => 2,
            'destination_branch_name'  => 'North Branch',
            'device_id'                => 5,
            'job_number'               => 'JOB-2024-0005',
            'device_info'              => 'Cisco RV340 Router | SN: CS-SN-00654',
            'customer_id'              => 1,
            'customer_name'            => 'Rahul Sharma',
            'reason'                   => 'expertise_unavailable',
            'reason_other'             => null,
            'remarks'                  => 'Chip-level networking expertise not available at HQ. Routing to North Branch.',
            'requested_by_id'          => 3,
            'requested_by_name'        => 'Amit Technician',
            'approved_by_id'           => null,
            'approved_by_name'         => null,
            'received_by_id'           => null,
            'received_by_name'         => null,
            'status'                   => 'pending',
            'requested_at'             => now()->subHours(4),
        ]);

        // Transfer 2 — Device 3 (Canon Printer), Branch 2 → Branch 1, received
        Transfer::create([
            'transfer_number'          => 'TRF-2024-0002',
            'source_branch_id'         => 2,
            'source_branch_name'       => 'North Branch',
            'destination_branch_id'    => 1,
            'destination_branch_name'  => 'HQ - TechFix Central',
            'device_id'                => 3,
            'job_number'               => 'JOB-2024-0003',
            'device_info'              => 'Canon PIXMA G3010 | SN: CN-SN-00789',
            'customer_id'              => 2,
            'customer_name'            => 'Priya Singh',
            'reason'                   => 'spare_unavailable',
            'reason_other'             => null,
            'remarks'                  => 'Printer spare parts not in stock at North Branch. Transferred to HQ.',
            'requested_by_id'          => 5,
            'requested_by_name'        => 'Suresh Delhi Tech',
            'approved_by_id'           => 2,
            'approved_by_name'         => 'Rajesh Kumar',
            'received_by_id'           => 3,
            'received_by_name'         => 'Amit Technician',
            'status'                   => 'received',
            'requested_at'             => now()->subDays(5),
            'approved_at'              => now()->subDays(4),
            'dispatched_at'            => now()->subDays(3),
            'received_at'              => now()->subDays(2),
        ]);
    }
}
