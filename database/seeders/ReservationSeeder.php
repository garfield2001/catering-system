<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::create([
            'reference_number' => '4023-2039-49234',
            'customer_id' => 1,
            'reservation_date' => now(),
            'event_date' => Carbon::parse('2024-06-12 13:00:00'),
            'duration' => 4,
            'event_type' => 'Wedding',
            'venue' => 'Family Country Hotel',
            'number_of_guests' => 250,
            'total_cost' => '30000',
            'payment_status' => 'pending',
            'booking_status' => 'pending',
        ]);
    }
}
