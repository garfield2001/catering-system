<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'category_id' => Category::where('name', 'Bellychon Packages')->first()->id,
            'name' => 'Package A',
            'price' => 4000
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Bellychon Packages')->first()->id,
            'name' => 'Package B',
            'price' => 5000
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Bellychon Packages')->first()->id,
            'name' => 'Package C',
            'price' => 6500
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Catering Packages')->first()->id,
            'name' => 'Package A',
            'price' => 280
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Catering Packages')->first()->id,
            'name' => 'Package B',
            'price' => 310
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Catering Packages')->first()->id,
            'name' => 'Package C',
            'price' => 350
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Catering Packages')->first()->id,
            'name' => 'Package D',
            'price' => 380
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal A',
            'price' => 129
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal B',
            'price' => 129
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal C',
            'price' => 129
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal D',
            'price' => 149
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal E',
            'price' => 149
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal F',
            'price' => 149
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal G',
            'price' => 169
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal H',
            'price' => 169
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Pack Lunch')->first()->id,
            'name' => 'Meal I',
            'price' => 169
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Beef',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Pork',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Chicken',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Seafoods',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Pasta',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Vegetables',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Noodles',
            'price' => null
        ]);

        Package::create([
            'category_id' => Category::where('name', 'Food Tray')->first()->id,
            'name' => 'Dessert',
            'price' => null
        ]);
    }
}
