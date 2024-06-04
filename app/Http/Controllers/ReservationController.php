<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /* $dishes = Dish::with(['package', 'parentDish', 'childDishes'])->get(); */

        return view('admin.dashboard.reservations', [
            'user' => $user,
            'title' => 'Reservations',
        ]);
    }
}
