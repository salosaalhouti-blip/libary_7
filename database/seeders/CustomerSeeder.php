<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'Ahmed',
            'phone_number' => '0911111111',
            'password' => '12345678',
            'balance' => 100,
            'address' => 'Benghazi'
        ]);
    }
}