<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $packages = Package::with('category', 'dishes')->get();
        $categories = Category::all();

        return view('admin.packages', [
            'user' => $user,
            'title' => 'Packages',
            'packages' => $packages,
            'categories' => $categories
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
            'category_id' => 'required', // Add validation for category_id
            'price' => 'nullable|numeric', // Add validation for price
        ]);

        $package = Package::create($request->only('name', 'category_id', 'price')); // Include category_id and price

        /* $category = Category::find($request->category_id); */


        // Load the related category
        $package->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Package added successfully.',
            'package' => $package
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // Load the related category
        /* $package->load('category'); */

        $package->update($request->only('name', 'category_id', 'price'));

        return response()->json(['success' => true, 'message' => 'Package updated successfully.', 'package' => $package]);
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return response()->json(['success' => true, 'message' => 'Package deleted successfully.']);
    }
}
