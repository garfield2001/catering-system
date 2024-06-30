<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Bellylechon Packages
        Dish::create([
            'package_id' => Package::where('name', 'Package A')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Lechon Belly 3kgs (Uncooked Weight)',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package A')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Garlic Chicken',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package A')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Sotanghon Guisado',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package A')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Lumpia Shanghai',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package B')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Lechon Belly 3kgs (uncooked weight)',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package B')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Beef Steak',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package B')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Garlic Chicken',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package B')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Sotanghon Guisado',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package B')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Lumpia Shanghai',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package C')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Lechon Belly 5kgs (Uncooked Weight)',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package C')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Beef Steak',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package C')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Lumpia Shanghai',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package C')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Sotanghon Guisado',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package C')->whereHas('category', function ($query) {
                $query->where('name', 'Bellychon Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Garlic Chicken',
            'price' => null
        ]);

        // Catering Packages
        Dish::create([
            'package_id' => Package::where('name', 'Package A')->whereHas('category', function ($query) {
                $query->where('name', 'Catering Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Beef',
            'price' => null
        ]);

        Dish::create([
            'package_id' => Package::where('name', 'Package A')->whereHas('category', function ($query) {
                $query->where('name', 'Catering Packages');
            })->first()->id,
            'parent_id' => null,
            'name' => 'Chicken',
            'price' => null
        ]);

        
    }
}
