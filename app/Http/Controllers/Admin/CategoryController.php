<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        $categories = Category::all();
        return view('admin.categories', [
            'user' => $user,
            'title' => 'Categories',
            'categories' => $categories
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge(['name' => $name]); // merge the modified input back into the request

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $category = Category::create($request->only('name', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully.',
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $name = ucwords($request->input('name')); // capitalizes first letter

        $request->merge([
            'name' => $name
        ]); // merge the modified input back into the request

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $category->update($request->only('name', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'category' => $category
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }
}
