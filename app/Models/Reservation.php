<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'reference_number',
        'customer_id',
        'event_date',
        'reservation_date',
        'event_type',
        'venue',
        'number_of_guests',
        'total_cost',
        'payment_status',
        'booking_status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function menuSelections()
    {
        return $this->hasMany(MenuSelection::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function equipmentRentals()
    {
        return $this->hasMany(EquipmentRental::class);
    }
}
