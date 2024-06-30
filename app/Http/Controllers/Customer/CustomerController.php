<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $title = 'Zek Catering and Kitchen Services';
        return view('Customer.index', ['title' => $title, 'user' => $user]);
    }
}
