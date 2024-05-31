<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();


        $packages = Package::with('category')->get();
        $categories = Category::all();

        return view('admin.dashboard.packages', [
            'user' => $user,
            'title' => 'Packages',
            'packages' => $packages,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $name = ucfirst($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required', // Add validation for category_id
            'price' => 'nullable|numeric', // Add validation for price
        ]);

        Package::create($request->only('name', 'category_id', 'price')); // Include category_id and price

        return response()->json(['success' => true, 'message' => 'Package added successfully.']);
    }

    public function update(Request $request, Package $package)
    {
        $name = ucfirst($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $package->update($request->only('name', 'categoryId', 'price'));

        return response()->json(['success' => true, 'message' => 'Package updated successfully.']);
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return response()->json(['success' => true, 'message' => 'Package deleted successfully.']);
    }
}
