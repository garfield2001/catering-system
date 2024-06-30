<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUlids;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'reservation_id',
        'payment_date',
        'amount_paid',
        'payment_method',
        'balance_due',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
