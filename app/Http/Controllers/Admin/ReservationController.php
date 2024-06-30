<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::with([
            'customer',
            'menuSelections',
            'payments',
            'staff',
            'equipmentRentals',
        ])->get();

        return view('admin.reservations', [
            'user' => $user,
            'title' => 'Reservations',
            'reservations' => $reservations
        ]);
    }
}
