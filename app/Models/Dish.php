<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory, HasUlids;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['package_id', 'parent_id', 'name', 'price'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function parentDish()
    {
        return $this->belongsTo(Dish::class, 'parent_id');
    }
    public function childDishes()
    {
        return $this->hasMany(Dish::class, 'parent_id');
    }
    public function menuSelections()
    {
        return $this->hasMany(MenuSelection::class);
    }
}
