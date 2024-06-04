<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        $categories = Category::all();
        return view('admin.dashboard.categories', [
            'user' => $user,
            'title' => 'Categories',
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name,
        ]); // merge the modified input back into the request

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->only('name'));

        return response()->json(['success' => true, 'message' => 'Category added successfully.']);
    }

    public function update(Request $request, Category $category)
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->only('name'));

        return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }
}
