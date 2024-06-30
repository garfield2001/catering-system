<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Catering Packages',
            'description' => 'Minimum of 50 Persons'
        ]);

        Category::create([
            'name' => 'Bellychon Packages',
            'description' => 'Each tray good for 15 pax'
        ]);

        Category::create([
            'name' => 'Food Pack Lunch',
            'description' => 'Minimum of 10 Pax'
        ]);

        Category::create([
            'name' => 'Food Tray',
            'description' => 'Each tray good for 15 pax'
        ]);
    }
}
