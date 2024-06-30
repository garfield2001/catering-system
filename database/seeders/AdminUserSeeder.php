<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::create([
            'first_name' => 'Andrew',
            'last_name' => 'Torres',
            'email' => 'andrew_torres@gmail.com',
            'phone' => '09366950428',
            'username' => 'admin',
            'password' => Hash::make('12345')
        ]);
    }
}
