<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            EmployeeSeeder::class,
            CustomerSeeder::class,
            DeviceSeeder::class,
            ServiceReportSeeder::class,
            StockItemSeeder::class,
            TransferSeeder::class,
            SettingsSeeder::class,
            // ── Lead Management Module ──
            LeadDatabaseSeeder::class,
        ]);
    }
}
