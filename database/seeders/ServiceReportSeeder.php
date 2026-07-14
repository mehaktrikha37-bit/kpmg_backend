<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceReport;

class ServiceReportSeeder extends Seeder
{
    public function run(): void
    {
        // Service report for Device 1 (JOB-2024-0001) — completed
        ServiceReport::create([
            'device_id'              => 1,
            'job_number'             => 'JOB-2024-0001',
            'customer_id'            => 1,
            'customer_name'          => 'Rahul Sharma',
            'customer_mobile'        => '9876543210',
            'customer_address'       => 'Andheri West, Mumbai',
            'device_type'            => 'laptop',
            'brand'                  => 'HP',
            'model'                  => 'Pavilion 15',
            'serial_number'          => 'HP-SN-00123',
            'call_received_date'     => now()->subDays(7),
            'call_attended_date'     => now()->subDays(6),
            'call_completed_date'    => now()->subDays(1),
            'call_type'              => 'out_warranty',
            'service_type'           => 'carry_in',
            'problem_description'    => 'Laptop not turning on, no display.',
            'accessories_received'   => json_encode(['charger', 'bag']),
            'action_taken'           => 'Replaced faulty DC jack and reflowed GPU solder joints.',
            'rectification_details'  => 'DC jack replacement + GPU reflow soldering done.',
            'engineer_remarks'       => 'Device tested successfully for 2 hours. Ready for delivery.',
            'estimate_amount'        => 1800.00,
            'call_status'            => 'completed',
            'created_by'             => 3,
            'branch_id'              => 1,
            'branch_name'            => 'HQ - TechFix Central',
        ]);

        // Service report for Device 4 (JOB-2024-0004) — completed & delivered
        ServiceReport::create([
            'device_id'              => 4,
            'job_number'             => 'JOB-2024-0004',
            'customer_id'            => 2,
            'customer_name'          => 'Priya Singh',
            'customer_mobile'        => '9123456789',
            'customer_address'       => 'Connaught Place, Delhi',
            'device_type'            => 'laptop',
            'brand'                  => 'Lenovo',
            'model'                  => 'ThinkPad E14',
            'serial_number'          => 'LN-SN-00321',
            'call_received_date'     => now()->subDays(10),
            'call_attended_date'     => now()->subDays(9),
            'call_completed_date'    => now()->subDays(4),
            'call_type'              => 'warranty',
            'service_type'           => 'carry_in',
            'problem_description'    => 'Battery draining very fast, device shutting down at 30%.',
            'accessories_received'   => json_encode(['charger']),
            'action_taken'           => 'Battery replaced under warranty.',
            'rectification_details'  => 'OEM battery unit replaced. Calibration done.',
            'engineer_remarks'       => 'Battery health at 100% post replacement. Delivered to customer.',
            'estimate_amount'        => 0.00,
            'call_status'            => 'completed',
            'created_by'             => 3,
            'branch_id'              => 1,
            'branch_name'            => 'HQ - TechFix Central',
        ]);

        // Service report for Device 2 (JOB-2024-0002) — pending spare parts
        ServiceReport::create([
            'device_id'              => 2,
            'job_number'             => 'JOB-2024-0002',
            'customer_id'            => 1,
            'customer_name'          => 'Rahul Sharma',
            'customer_mobile'        => '9876543210',
            'customer_address'       => 'Andheri West, Mumbai',
            'device_type'            => 'desktop',
            'brand'                  => 'Dell',
            'model'                  => 'OptiPlex 7090',
            'serial_number'          => 'DL-SN-00456',
            'call_received_date'     => now()->subDays(3),
            'call_attended_date'     => now()->subDays(2),
            'call_completed_date'    => null,
            'call_type'              => 'amc',
            'service_type'           => 'onsite',
            'problem_description'    => 'System freezing intermittently under heavy load.',
            'accessories_received'   => json_encode(['keyboard', 'mouse']),
            'action_taken'           => 'Ran diagnostics. RAM modules showing errors. Ordered replacement.',
            'rectification_details'  => null,
            'engineer_remarks'       => 'Awaiting spare RAM modules from supplier.',
            'estimate_amount'        => 2500.00,
            'call_status'            => 'pending_spare',
            'created_by'             => 3,
            'branch_id'              => 1,
            'branch_name'            => 'HQ - TechFix Central',
        ]);
    }
}
