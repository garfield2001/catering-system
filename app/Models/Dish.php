<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'dish_id', 'name', 'price'];

    // Define the relationship with the Package model
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Define the self-referencing relationship
    public function parentDish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    // Define the relationship to child dishes
    public function childDishes()
    {
        return $this->hasMany(Dish::class, 'dish_id');
    }
}
