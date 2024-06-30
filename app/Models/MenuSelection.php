<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSelection extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'reservation_id',
        'dish_id',
        'quantity',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
