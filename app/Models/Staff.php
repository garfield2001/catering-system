<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'reservation_id',
        'staff_type',
        'number_of_staff',
        'service_hours',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
