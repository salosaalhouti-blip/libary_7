<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class staffseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([
            "name"=>"ali",
            "email"=>"ali2@gmail.com",
            "password"=>bcrypt("12345678"),
            "role"=>"admin",
            "phone_number"=>"1234567890"
        ]);
        
    }
}
