<?php

namespace Database\Seeders;

use App\Models\LeadUser;
use Illuminate\Database\Seeder;

class LeadDatabaseSeeder extends Seeder
{
    /**
     * Seed the lead_users table with an admin + sample sales executives.
     */
    public function run(): void
    {
        LeadUser::create([
            'employee_id'      => 'EMP0001',
            'name'             => 'Super Admin',
            'mobile'           => '9876543210',
            'email'            => 'admin@kpmgleadmanager.com',
            'password'         => 'Password@123',
            'role'             => 'super_admin',
            'branch'           => 'Main Headquarters',
            'designation'      => 'System Administrator',
            'status'           => 'active',
            'is_temp_password' => false,
        ]);

        LeadUser::create([
            'employee_id'      => 'EMP0002',
            'name'             => 'Sales Executive One',
            'mobile'           => '9876543211',
            'email'            => 'exec1@kpmgleadmanager.com',
            'password'         => 'KPMG#9911',
            'role'             => 'sales_executive',
            'branch'           => 'Downtown Branch',
            'designation'      => 'Sales Consultant',
            'status'           => 'active',
            'is_temp_password' => true,
            'temp_password'    => 'KPMG#9911',
        ]);

        LeadUser::create([
            'employee_id'      => 'EMP0003',
            'name'             => 'Sales Executive Two',
            'mobile'           => '9876543212',
            'email'            => 'exec2@kpmgleadmanager.com',
            'password'         => 'KPMG#9922',
            'role'             => 'sales_executive',
            'branch'           => 'Uptown Mall Store',
            'designation'      => 'Senior Associate',
            'status'           => 'active',
            'is_temp_password' => true,
            'temp_password'    => 'KPMG#9922',
        ]);
    }
}
