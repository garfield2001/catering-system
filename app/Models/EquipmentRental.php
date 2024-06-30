<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRental extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'reservation_id',
        'equipment_type',
        'quantity',
        'rental_cost',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
