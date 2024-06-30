<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        
        $dishes = Dish::with(['package', 'childDishes'])->get();
        $packages = Package::all();

        // Dishes that are parents
        $parentDishes = $dishes->filter(function ($dish) {
            return $dish->package == null && $dish->parent_id == null;
        });
        // Dishes that are children
        $childDishes = $dishes->filter(function ($dish) {
            return $dish->parent_id !== null || $dish->package !== null;
        });
        
        return view('admin.dishes', [
            'user' => $user,
            'title' => 'Dishes',
            'dishes' => $dishes,
            'parentDishes' => $parentDishes,
            'childDishes' => $childDishes,
            'packages' => $packages,
            'currentDish' => null
        ]);
    }

    public function store(Request $request)
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request


        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:dishes,id',
            'package_id' => 'nullable|exists:packages,id',
            'price' => 'nullable|numeric',
        ]);

        $dish = Dish::create($request->only('name', 'parent_id', 'package_id', 'price'));

        return response()->json(['success' => true, 'message' => 'Dish added successfully.', 'dish' => $dish]);
    }

    public function update(Request $request, Dish $dish)
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request


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
