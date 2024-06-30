<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateringPackagesController extends Controller
{
    public function index(){

        $user = Auth::user();
        $dishes = Dish::with(['package', 'parentDish', 'childDishes'])->get();

        return view('Admin.catering_packages', [
            'title' => 'Catering Packages',
            'user' => $user,
            'dishes' => $dishes
        ]);
    }
}
