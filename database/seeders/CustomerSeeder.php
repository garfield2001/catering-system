<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'first_name' => 'Erik',
            'last_name' => 'Santos',
            'contact_number' => '09366940319',
            'email_address' => 'eriksantos44@gmail.com',
            'address' => 'Zone 1 lot 29 Banahaw Street Labangal General Santos City'
        ]);
    }
}
