<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        $dishes = Dish::with(['package', 'parentDish', 'childDishes'])->get();
        $packages = Package::all();
        return view('admin.dashboard.dishes', [
            'user' => $user,
            'title' => 'Dishes',
            'dishes' => $dishes,
            'packages' => $packages
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:dishes,id',
            'package_id' => 'nullable|exists:packages,id',
            'price' => 'nullable|numeric',
        ]);

        Dish::create($request->only('name', 'parent_id', 'package_id', 'price'));

        return response()->json(['success' => true, 'message' => 'Dish added successfully.']);
    }

    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:dishes,id',
            'package_id' => 'nullable|exists:packages,id',
            'price' => 'nullable|numeric',
        ]);

        $dish->update($request->only('name', 'parent_id', 'package_id', 'price'));

        return response()->json(['success' => true, 'message' => 'Dish deleted successfully.']);
    }

    public function destroy(Dish $dish)
    {
        $dish->delete();

        return response()->json(['success' => true, 'message' => 'Dish deleted successfully.']);
    }
}
