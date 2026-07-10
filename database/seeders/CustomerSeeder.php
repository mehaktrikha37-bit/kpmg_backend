<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'Rahul Sharma',
            'mobile' => '9876543210',
            'email' => 'rahul@example.com',
            'address' => 'Andheri West',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'branch_id' => 1,
        ]);

        Customer::create([
            'name' => 'Priya Singh',
            'mobile' => '9123456789',
            'email' => 'priya@example.com',
            'address' => 'Connaught Place',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'branch_id' => 2,
        ]);
    }
}
